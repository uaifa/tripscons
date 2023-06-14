<?php


namespace App\Tripscon\Services\TravellerHost;


use App\Models\Activity;
use App\Models\ActivityLink;
use App\Tripscon\Interfaces\iHostService;
use App\Models\User;
use App\Models\UserCity;
use App\Models\UserHostTrip;
use App\Models\UserState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class HostTrip implements iHostService
{

    /**
     * @inheritDoc
     */
    public function createOrUpdate(Request $request)
    {
        $status = 200;
        $message = 'Record Updated Successfully.';

        User::find(Auth::id())->update([
           'host_out_of_city'=>$request->is_host
        ]);

//        $request->validate([
//            'selectedActivities' => 'required'
//        ]);
//        $out_of_city = $request->out_of_city;
//        if ($out_of_city == '1') {
//            $request->validate([
//                'country_id' => 'required',
//                'selectedState' => 'required',
//            ], [
//                'country_id.required' => 'Please, Select Country,',
//                'selectedState.required' => 'Please, Select State,',
//            ]);
//        }
//
//        if ($out_of_city == '1') {
//            $selectedStateIds = $request->selectedState;
//            UserState::getDelete('user_host_trips', $request->id);
//        }
//        if ($request->id) {
//            UserHostTrip::whereId($request->id)->update([
//                'user_id' => Auth::id(),
//                'country_id' => (int)$request->country_id,
//                'out_of_city' =>  (int)$request->out_of_city
//            ]);
//            $trip = UserHostTrip::find($request->id);
//            $status = 200;
//            $message = 'Trip Updated Successfully';
//        } else {
//            $trip = UserHostTrip::create([
//                'user_id' => Auth::id(),
//                'out_of_city' =>  (int)$request->out_of_city
//            ]);
//            $status = 200;
//            $message = 'Trip Created Successfully';
//        }
//
//        if ($out_of_city == '1') {
//            if ($selectedStateIds) {
//                foreach ($selectedStateIds as $selectedStateId) {
//                    UserState::create([
//                        'user_id' => Auth::id(),
//                        'ref_id' => $trip->id,
//                        'ref_type' => 'user_host_trips',
//                        'state_id' => (int)$selectedStateId
//                    ]);
//                }
//                $status = 200;
//                $message = 'Trip Updated Successfully';
//            }
//        }
//
//
//        $selectedActivities = $request->selectedActivities;
//        ActivityLink::deleteByRef($trip->id, 'user_host_trips');
//        if ($selectedActivities) {
//            foreach ($selectedActivities as $i => $selectedActivity) {
//                $activity = Activity::getByName($selectedActivity['name']);
//                if ($activity) {
//                    ActivityLink::create([
//                        'active' => 1,
//                        'type' => 'trip:previous',
//                        'ref_id' => $trip->id,
//                        'activity_id' => $activity->id
//                    ]);
//                }
//            }
//        }

        return response(['message' => $message], $status);
    }

    /**
     * @inheritDoc
     */
    public function uploadImage(Request $request)
    {
        $allImages = [];
        $id = $request->id;
        $file = $request['file'];
        $trip = UserHostTrip::find($id);
        if ($trip) {
            if ($trip->images) {
                $images = json_decode($trip->images);
                if ($images) {
                    foreach ($images as $image) {
                        array_push($allImages, $image);
                    }
                }
            }
        }

        if ($file) {
            $dirPath = 'basic/images/transports/';
            $filename = Str::random(40) . '.png';
            Image::make($file)->save(public_path($dirPath . $filename));
            array_push($allImages, [
                'primary' => $allImages ? 0 : 1,
                'fileName' => $filename,
                'path' => $dirPath,
                'url' => getDomainName() . '/' . $dirPath . $filename,
                'mimeType' => 'png'
            ]);
        }
        if ($allImages) {
            $trip->update([
                'images' => json_encode($allImages)
            ]);
        }
        return response()->json(['message' => 'Image Uploaded.'], 200);
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        $userTrips = UserHostTrip::getByUserId(Auth::id());
        return response(['host_trips' => $userTrips], 200);
    }

    /**
     * @inheritDoc
     */
    public function getAllImages($id)
    {
        $allImages = [];
        $trip = UserHostTrip::find($id);
        if ($trip) {
            if ($trip->images) {
                $images = json_decode($trip->images);
                if ($images) {
                    foreach ($images as $image) {
                        array_push($allImages, $image);
                    }
                }
            }
        }
        return response(['images' => $allImages], 200);
    }

    /**
     * @inheritDoc
     */
    public function makePrimaryImage(Request $request)
    {
        $allImages = [];
        $primary = null;
        $id = $request->id;
        $fileName = $request->fileName;
        $trip = UserHostTrip::find($id);
        if ($trip) {
            if ($trip->images) {
                $images = json_decode($trip->images);
                if ($images) {
                    foreach ($images as $image) {
                        if ($image->fileName == $fileName) {
                            $primary = 1;
                        } else {
                            $primary = 0;
                        }
                        array_push($allImages, [
                            'primary' => $primary,
                            'fileName' => $image->fileName,
                            'path' => $image->path,
                            'url' => $image->url,
                            'mimeType' => $image->mimeType
                        ]);
                    }
                }
            }
        }
        if ($allImages) {
            $trip->update([
                'images' => json_encode($allImages)
            ]);
        }
        return response()->json(['message' => 'Primary Image Selected.'], 200);
    }

    /**
     * @inheritDoc
     */
    public function deleteImage(Request $request)
    {
        $allImages = [];
        $id = $request->id;
        $fileName = $request->fileName;
        $trip = UserHostTrip::find($id);
        if ($trip) {
            if ($trip->images) {
                $images = json_decode($trip->images);
                if ($images) {
                    foreach ($images as $image) {
                        if ($image->fileName == $fileName) {
                            deleteFile(json_encode($image));
                        } elseif ($image->fileName != $fileName) {
                            array_push($allImages, [
                                'primary' => isset($image->primary) ? $image->primary : 0,
                                'fileName' => $image->fileName,
                                'path' => $image->path,
                                'url' => $image->url,
                                'mimeType' => $image->mimeType
                            ]);
                        }
                    }
                }
            }
        }
        $trip->update([
            'images' => json_encode($allImages)
        ]);
        return response()->json(['message' => 'Image Delete Successfully.'], 200);
    }

    /**
     * @inheritDoc
     */
    public function delete($id)
    {
        UserHostTrip::whereId((int)$id)->delete();
        return response()->json(['message' => 'Trip Deleted Successfully.'], 200);
    }
}
