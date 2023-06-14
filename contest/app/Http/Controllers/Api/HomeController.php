<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Entry;
use App\Models\User;
use App\Models\Vote;
use Carbon\Carbon;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\Auth;
use Image;
use Laravel\Passport\HasApiTokens;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;

class HomeController extends Controller
{
    protected $status = 200;
    protected $response = [];

    public function Contests() {
        try {
            $contests = contest::get();
            foreach ($contests as $contest){
                $contest->entries = Entry::whereIn('id', $contest->winner_list)
                    ->with(['user'=>function ($q){
                        $q->select('id','name','phone','address','country','image');
                    }])
                    ->get();
            }
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $contests;
            return response()->json($this->response, $this->status);
        }
        catch (Exception $e){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['data'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function Entries(Request $request) {
        try {

            $newest=$request->newest;
            $oldest=$request->oldest;
            $recent=$request->recent;

            $entries = Entry::where('contest_id',$request->contest_id)
                ->when($newest,function ($q) use($newest) {
                    if($newest == true) {
                        $q->orderByDESC('created_at');
                    }
                })
                ->when($oldest,function ($q) use($oldest){
                    if($oldest == true) {
                        $q->orderBy('created_at');
                    }
                })

                ->when($recent,function ($q) use($recent){
                    if($recent == true) {
                        $q->orderByDesc('votes');
                    }
                })
                ->with(['user'=>function ($q){
                    $q->select('id','name','phone','address','country','image');
                }])
                ->paginate(24);
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $entries;
            return response()->json($this->response, $this->status);
        }
        catch (Exception $e){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['data'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function submitEntry(Request $request) {
        if ($request->user()){
            $userId=  $request->user()->id;
            $phone = $request->user()->phone;
            $thumbnailPath = '';
            $myEntry = Entry::where('user_id', $userId)->where('contest_id', $request->contest)->get()->count();
            if($myEntry == 10){
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] =  "You can submit one Entry per contest";
                return response()->json($this->response, $this->status);
            }
            $validator = \Validator::make($request->all(), [
                'title' => 'required|min:10|max:50',
                'acceptTerms' => 'accepted',
                'description' => 'max:200',
                'attachment' => 'required|mimes:png,jpg,jpeg,gif,mp4,mov,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,application/octet-stream,video/x-ms-wmv|max:51960',
                'phone' => 'required|min:11|numeric',
                'location' => 'required',
            ]);
            if ($validator->fails()) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = $validator->errors()->first();
                return response()->json($this->response, $this->status);
            }
            if ($request->contest == Contest::IMAGE_CONTEST)
                $path = $request->attachment->store('media');
            elseif($request->contest == Contest::VIDEO_CONTEST) {
                if ($request->hasFile('attachment')) {
                    $path = $request->file('attachment')->store('media');
                    if ($request->thumbnail != null) {
                        $thumbnailPath = $request->thumbnail->store('media');
                    }
                    // $thumbnailPath = $this->generateThumbnail($request->attachment);
                    // $thumbnailImg = $this->getVideoThumbnail($path,$thumbnailPath);
                }
            }
            $entry = Entry::forceCreate([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => $userId,
                'contest_id' => $request->contest,
                'media_path' => $path,
                'thumbnail' => $thumbnailPath,
                'phone' => $request->phone,
                'location' => $request->location,
            ]);

            if($phone == '' || $phone == null){
                $request->user()->phone = $request->phone;
                $request->user()->update();
            }
            $image = Storage::disk('media')->get(str_replace('media/', '', $path));
            if ($request->contest == Contest::IMAGE_CONTEST && str_starts_with($request->attachment->getMimeType(), 'image/')){
                $image = Image::make($image)->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('jpg');
            }
            elseif($request->contest == Contest::VIDEO_CONTEST){
                if ($request->thumbnail != null){
                    $thumbImage = Storage::disk('media')->get(str_replace('media/', '', $thumbnailPath));
                    Storage::put('media/thumb_'.str_replace('media/', '', $thumbnailPath), $thumbImage);
                }
            }
            Storage::put('media/thumb_'.str_replace('media/', '', $path), $image);

            if($request->contest == Contest::VIDEO_CONTEST){
                $filePath = $entry->media_path;
                $filePathreplace = str_replace("media/", "stream/", $filePath);
                $entry->media_path = $filePathreplace;
                $entry->update();
            }
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'You have successfully participated in the contest';
            $this->response['data'] = $entry;
            return response()->json($this->response, $this->status);
        } else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] =  "User is not logged in";
            return response()->json($this->response, $this->status);

        }

    }

    public function voteCast(Request $request) {
        try {
            if($request->user()){
                $twentyFourHoursAgo = Carbon::now()->subDay();
                $lastVote = Vote::where('created_at', '>', $twentyFourHoursAgo)
                    ->where('contest_id', $request->contest_id)
                    ->where('user_id', $request->user()->id)
                    ->count();
                if($lastVote){
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = 'You can only vote once in 24 hours';
                    return response()->json($this->response, $this->status);
                } else {
                    $entry = Entry::find($request->entry_id);
                    $entry->votes += 1;
                    $entry->update();

                    Vote::forceCreate([
                        'entry_id' => $entry->id,
                        'contest_id' => $request->contest_id,
                        'user_id' => Auth::id()
                    ]);
                    $this->status = 200;
                    $this->response['success'] = true;
                    $this->response['message'] = 'Your vote is counted and you can vote again after 24 hours.';
                    return response()->json($this->response, $this->status);
                }
            } else {
                $this->status = 400;
                $this->response['error'] = false;
                $this->response['message'] = "User is not loggedIn!";
                return response()->json($this->response, $this->status);
            }
        } catch (Exception $e){
            $this->status = 400;
            $this->response['error'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }

    }

    public function getEntry(Request $request)
    {
        if ($request->user()) {
            $userId = $request->user()->id;
            $myEntry = Entry::where('user_id', $userId)->where('contest_id', $request->contest_id)->get()->count();
            if ($myEntry != 0) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = "You can submit one image per contest";
                return response()->json($this->response, $this->status);
            }
            else{
                $this->status = 200;
                $this->response['success'] = true;
                return response()->json($this->response, $this->status);
            }
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] =  "User is not logged in";
            return response()->json($this->response, $this->status);
        }
    }

    public function socialRegister(Request $request) {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'device_type' => 'required',
            'device_token' => 'required',
            'social_platform' => 'required',
            'social_platform_id' => 'required',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }

        $name = $request->name;
        $email = $request->email;
        $social_platform = $request->social_platform;
        $social_platform_id = $request->social_platform_id;
        $device_type = $request->device_type;
        $device_token = $request->device_token;

        if (User::where('social_platform_id', $social_platform_id)->where('social_platform', $social_platform)->exists()) {
            User::where('social_platform_id', $social_platform_id)->where('social_platform', $social_platform)
                ->update([
                    'name' => $name,
                    'device_type' => $device_type,
                    'device_token' => $device_token,
                    'social_platform' => $social_platform,
                    'social_platform_id' => $social_platform_id,
                ]);
            $user = User::where('social_platform_id', $social_platform_id)->where('social_platform', $social_platform)->first();
            $isNew =false;
        } else {
            $isNew =false;
            if (User::where('email', $email)->exists()) {
                $user = User::where('email', $email)->update([
                    'name' => $name,
                    'device_type' => $device_type,
                    'device_token' => $device_token,
                    'social_platform' => $social_platform,
                    'social_platform_id' => $social_platform_id,
                ]);
                $user = User::where('email', $email)->first();
            } else {
                $isNew =true;
                $user = User::Create([
                    'name' => $name,
                    'email' => $email,
                    'device_type' => $device_type,
                    'device_token' => $device_token,
                    'social_platform' => $social_platform,
                    'social_platform_id' => $social_platform_id,
                ]);
            }
        }
        if ($user) {
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['isNew'] = $isNew;
            $this->response['message'] = 'user has been logged in.';

            Auth::login($user);
            $user = Auth::user();
            $token = $user->createToken('TripsConContest')->accessToken;
            $user->update([
                'api_token' => $token,
                'verified'=>1,
            ]);

            if ($files = $request->file('image')) {
                $image_full_name = pathinfo($files->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('/assets/uploads/users'); //Creating Sub directory in Public
                $files->move($destinationPath, $image_full_name);
                $user->update([
                    'image' => $image_full_name
                ]);
            }

            $users = Auth::user();
            $this->response['data'] = $users->makeVisible('api_token');
        }
        return response()->json($this->response, $this->status);
    }

    private function generateThumbnail($video) {
        $tempPath = tempnam(sys_get_temp_dir(), 'thumbnail_');

        $thumbnailTime = '00:00:03'; // time in the video where you want to take the thumbnail
        $cmd = "ffmpeg -i {$video->getPathname()} -ss {$thumbnailTime} -vframes 1 {$tempPath}";
        exec($cmd);
        return $tempPath;
    }

    private function getVideoThumbnail($videoPath, $thumbnailPath)
    {
        $ffmpeg = FFMpeg::create();

        $video = $ffmpeg->open($videoPath);

        // Get the duration of the video
        $duration = $video->getDuration();

        // Get the middle frame of the video as the thumbnail
        $frame = $video->frame(TimeCode::fromSeconds($duration / 2));
        $frame->save($thumbnailPath);

        return $thumbnailPath;
    }

    public function EntryDetail(Request $request)
    {
        try {
            $entry = Entry::where('id', $request->id)
                ->with('contest')
                ->with(['user' => function ($q) {
                    $q->select('id', 'name', 'phone', 'address', 'country', 'image');
                }])
                ->first();
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $entry;
            return response()->json($this->response, $this->status);
        } catch (Exception $e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['data'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function deleteEntry(Request $request){
        try {
            $entryId=$request->entry_id;
            $entry =Entry::where('id',$entryId)->where('user_id',$request->user()->id)->delete();
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] =  "Your entry has been deleted successfully";
            return response()->json($this->response, $this->status);
        }
        catch (Exception $e){
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['data'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function getCommentsCount($entry_id){
        $myEntry = Entry::select('id')->withCount('comments')->where('id', $entry_id)->first();
        
        $this->status = 200;
        $this->response['data'] = $myEntry;
        $this->response['success'] = true;
        return response()->json($this->response, $this->status);
        
    }

}
