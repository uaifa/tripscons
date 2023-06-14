<?php

namespace App\Http\Controllers\api;

use App\Events\Counters;
use App\Http\Controllers\Controller;
use App\Libs\Image\Optimizer;
use App\Models\Accommodation;
use App\Models\Activity;
use App\Models\DeviceDetail;
use App\Models\GuideActivity;
use App\Models\Image;
use App\Models\Image as modelImage;
use App\Models\Notification;
use App\Models\Participant;
use App\Models\PlannedTrip;
use App\Models\TripMate;
use App\Models\TripMateDestination;
use App\Models\TripMateInvitation;
use App\Models\User;
use App\Notifications\PushNotification;
use App\Traits\HostServiceBookingTrait;
use App\Traits\RadiusDistanceTrait;
use App\Traits\SendEmailTrait;
use App\Traits\ServiceTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Lcobucci\JWT\Exception;

class TripMateController extends Controller
{

    use RadiusDistanceTrait;

    protected $status = 200;
    protected $response = [];
    protected $user;
    protected $provider;
    protected $tripmate_invitaion_id;
    protected $model;

    // Model Declaration
    public function model()
    {
        return TripMate::class;
    }
    // Create trip Api
    public function createTrip(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'destination' => 'required',
            'activities' => 'required',
            //            'images' => 'jpeg,png,jpg,gif,svg,NEF,nef',
            'date_from' => 'required|date|date_format:Y-m-d',
            'date_to' => 'required|date|date_format:Y-m-d',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->status);
        }
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $trip_id = $request->trip_id;
        if ($trip_id == null || $trip_id == "") {
            $tripmateDate = TripMate::where('user_id', $request->user()->id)
                ->where(function ($query) use ($date_from, $date_to) {
                    $query->wherebetween('date_from', [$date_from, $date_to])
                        ->orwherebetween('date_to', [$date_from, $date_to]);
                })
                ->first();
            if ($tripmateDate) {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = "You've already created trip between these date. Kindly Choose another date";
                return response()->json($this->response, $this->status);
            } else {
                // Image uploader in image table with unique trip id
                // create user trip
                $tripmate = new TripMate();
                $tripmate->user_id = $request->user()->id;
                $tripmate->date_from = $request->date_from;
                $tripmate->date_to = $request->date_to;
                $tripmate->description = $request->description;
                $tripmate->pick_up = $request->user()->address;
                $tripmate->destination = $request->destination;
                $tripmate->save();
                $tripmates = TripMate::with('images', 'activities')->where('id', $tripmate->id)->first();
                $this->CreateActivities($request->activities, $tripmate->id);

                $title = "Trip Plan";
                $message = "Trip plan published successfully and other's can now join your trip.";
                $action     = "user/setting";
                $admin = User::where('role_id', User::ADMIN_ROLE_ID)->first();
                if (isset($admin) && !empty($admin)) {
                    PushNotification::createNotification($request->user(), $admin->id, $title, $message, User::TYPE_TRIP_MATE, $action, $request->user()->id);
                }

                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Trip created successfully.';
                $this->response['data'] = $tripmates;
                return response()->json($this->response, $this->status);
            }
        } else {
            $tripmate = TripMate::with('images', 'activities')->where('id', $trip_id)->first();
            $tripmate->date_from = $request->date_from;
            $tripmate->date_to = $request->date_to;
            $tripmate->description = $request->description;
            $tripmate->pick_up = $request->user()->address;
            $tripmate->destination = $request->destination;
            $tripmate->save();
            $this->CreateActivities($request->activities, $tripmate->id);
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Trip Updated successfully.';
            $this->response['data'] = $tripmate;
            return response()->json($this->response, $this->status);
        }
    }
    // create random unique trip id
    public function tripMateId()
    {
        $tripMateId = rand(100, 123456789);
        return $tripMateId;
    }
    // image uplaoder for trip mate
    public function imageUploader($request, $tripMateId)
    {
        // return $request->all();
        $folderPath = '/assets/uploads/trip_mate/';
        $TripImage = [];
        if ($request->hasfile('images')) {
            $images[] = $request->file('images');
            foreach ($images as $image) {
                $imgName = $image->getClientOriginalName();
                $image = $image->move(public_path() . $folderPath, $imgName);
                Optimizer::optimize($image);
                $TripImage = new Image();
                $TripImage->name = $imgName;
                $TripImage->module_id = $tripMateId;
                $TripImage->module = TripMate::TRIP_MATE;
                $TripImage->type = TripMate::IMAGE_TYPE1;
                $TripImage->save();
            }
        }
    }

    public function optimizeImageUploader($request, $tripMateId)
    {
        $destinationPath = '/assets/uploads/trip_mate/';

        try {
            $TripImage = [];
            if ($request->hasfile('images')) {
                $files[] = $request->file('images');
                foreach ($files as $file) {
                    $image_full_name = pathinfo($files->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $files->getClientOriginalExtension();
                    $img = \Image::make($file->getRealPath());
                    $width = getimagesize($file)[0];
                    $height = getimagesize($file)[1];
                    if ($width > 3000) {
                        $width = $width / 4;
                        $height = $height / 4;
                    }
                    if ($width > 2000) {
                        $width = $width / 3;
                        $height = $height / 3;
                    }
                    if ($width > 1000) {
                        $width = $width / 2;
                        $height = $height / 2;
                    }

                    $img->resize($width, $height, function ($constraint) {
                        // $img->resize(400, 150, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath . '/' . $image_full_name);
                    $TripImage = new modelImage;
                    $TripImage->name = $image_full_name;
                    $TripImage->module_id = $tripMateId;
                    $TripImage->module = TripMate::TRIP_MATE;
                    $TripImage->type = TripMate::IMAGE_TYPE1;
                    $TripImage->save();
                    if ($TripImage->save()) {
                        $this->status = 200;
                    } else {
                        $this->status = 422;
                    }
                }
            }
        } catch (Exception $e) {
            $this->status = 422;
            $this->response['message'] = "Image Size is greater than 2 MB";
        }
    }
    // Create Activities for trip
    public function CreateActivities($activities, $tripMateId)
    {
        $activities = json_decode($activities, true);
        $activity = [];
        try {
            $guideActivity = GuideActivity::where('guide_id', $tripMateId)->where('type', TripMate::TRIP_MATE)->first();
            if ($guideActivity) {
                $guideActivity = GuideActivity::where('guide_id', $tripMateId)->where('type', TripMate::TRIP_MATE)->delete();
            }
            foreach ($activities as $key => $value) {
                $activity[$key]['name'] = $value['name'];
                $activity[$key]['image'] = $value['image'];
                $activity[$key]['guide_id'] = $tripMateId;
                $activity[$key]['type'] = TripMate::TRIP_MATE;
            }
            GuideActivity::insert($activity);
        } catch (\Exception $e) {
        }
    }
    // Create destinations for trip
    public function CreateDestinations($request, $tripMateId)
    {
        try {
            $destination['trip_id'] = $tripMateId;
            $destination['type'] = TripMate::TRIP_MATE;

            $latitude = explode(",",  $request->lat);
            foreach ($latitude as $key => $value) {
                $destination[$key]['lat'] = $value;
            }
            $longitude = explode(",",  $request->lng);
            foreach ($longitude as $key => $value) {
                $destination[$key]['lng'] = $value;
            }
            $cities = explode(",",  $request->city);
            foreach ($cities as $key => $value) {
                $destination[$key]['city'] = $value;
            }
            $states = explode(",",  $request->state);
            foreach ($states as $key => $value) {
                $destination[$key]['state'] = $value;
            }
            $country = explode(",",  $request->country);
            foreach ($country as $key => $value) {
                $destination[$key]['country'] = $value;
            }
            TripMateDestination::insert($destination);
        } catch (\Exception $e) {
        }
    }
    // Create Activities for trip
    public function tripMateList(Request $request)
    {
        $tripMate = TripMate::with('images', 'activities', 'single_image')
            ->where("user_id", $request->user()->id)
            ->whereDate('date_from', '>=', date('Y-m-d'))
            ->orderBy('id', 'DESC')
            ->paginate(Config::get('global.pagination_records'));

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Planned Trip list Successfully';
        $this->response['data'] = $tripMate;
        return response()->json($this->response, $this->status);
    }
    // Past Trips
    public function pastTripsList(Request $request)
    {
        $tripMate = TripMate::with('images', 'activities')
            ->where("user_id", $request->user()->id)
            ->whereDate('date_from', "<", date('Y-m-d'))
            ->orderBy('id', 'DESC')
            ->paginate(Config::get('global.pagination_records'));

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Trip list Successfully';
        $this->response['data'] = $tripMate;
        return response()->json($this->response, $this->status);
    }
    // upcoming trip listing on public screen for every users.
    public function tripMateListing(Request $request)
    {
        $tripmateId = $request->trip_mate_id;
        if ($request->request_user_id != null) {
            $request_user_id = $request->request_user_id;
            $actvities = GuideActivity::where('guide_id', $request_user_id)->get();
            $tripMateListing = TripMate::with('images', 'activities')
                ->with(['trip_mate_invitation' => function ($q) use ($request_user_id) {
                    $q->where('request_user_id', $request_user_id);
                }])
                ->whereDate('date_from', ">=", date('Y-m-d'))
                ->where("user_id", $tripmateId)
                ->where("destination", "like", "%" . $request->destination . "%")
                //                ->whereHas('activities',function ($q) use ($actvities) {
                //                    $q->whereIn('name','like',"%".$actvities."%");
                //                })
                ->get();
        } else {
            $tripMateListing = TripMate::with('images', 'activities')
                ->where("user_id", $tripmateId)
                ->whereDate('date_from', ">=", date('Y-m-d'))
                ->where("destination", "like", "%" . $request->destination . "%")
                ->get();
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Trip list Successfully';
        $this->response['data'] = $tripMateListing;
        return response()->json($this->response, $this->status);
    }
    // past trip listing on public screen for every users.
    public function pastTripMateListing(Request $request)
    {
        $tripmateId = $request->trip_mate_id;
        if ($request->request_user_id != null) {
            $request_user_id = $request->request_user_id;
            $actvities = GuideActivity::where('guide_id', $request_user_id)->get();
            $tripMateListing = TripMate::with('images', 'activities')
                ->with(['trip_mate_invitation' => function ($q) use ($request_user_id) {
                    $q->where('request_user_id', $request_user_id);
                }])
                ->whereDate('date_from', "<", date('Y-m-d'))
                ->where("user_id", $tripmateId)
                ->where("destination", "like", "%" . $request->destination . "%")
                //                ->whereHas('activities',function ($q) use ($actvities) {
                //                    $q->whereIn('name','like',"%".$actvities."%");
                //                })
                ->get();
        } else {
            $tripMateListing = TripMate::with('images', 'activities')
                ->where("user_id", $tripmateId)
                ->whereDate('date_from', "<", date('Y-m-d'))
                ->where("destination", "like", "%" . $request->destination . "%")
                ->get();
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Trip list Successfully';
        $this->response['data'] = $tripMateListing;
        return response()->json($this->response, $this->status);
    }
    //Send Invites on public screen
    public function tripMates(Request $request)
    {
        $user = $request->user() ? $request->user() : null;
        $distance_result = '';
        $rad = 50;
        $lat = 0;
        $lng = 0;
        $fromDate = $request->date_from;
        $toDate = $request->date_to;
        $destination = $request->destination;
        $country = $request->country;
        $state = $request->state;
        $city = $request->city;

        $distance_result = 'ROUND(DEGREES(ACOS(SIN(RADIANS(' . $lat . ')) 
                    * SIN(RADIANS(lat)) 
                    + COS(RADIANS(' . $lat . '))  
                    * COS(RADIANS(lat))
                    * COS(RADIANS(' . $lng . ' - lng)))) * 69.09)';


        if (isset($request->lat) && !empty($request->lat) && isset($request->lng) && !empty($request->lng)) {
            $lat = round($request->lat, 8);
            $lng = round($request->lng, 8);
            $rad = isset($request->radius) ? (int)$request->radius : 0;

            $rad = floor($rad / 1000);

            $checkedActivities = [];
            if ($request->activities != null && $request->activities != "") {
                $selectedActivities = json_decode($request->activities, true);
                $checkedActivities = array_column($selectedActivities, 'name');

                // foreach ($selectedActivities as $value)
                // {
                //     $checkedActivities = $value['name'];
                // }
            }
            // dd($checkedActivities);
            $activities = GuideActivity::select('name')
                ->where(function ($guide) use ($user) {
                    if ($user) {
                        $guide->where('user_id', $user->id);
                    }
                })
                ->orwhere('type', 'trip_mate')
                ->groupBy('name')
                ->pluck('name');

            $distance_result = 'ROUND(DEGREES(ACOS(SIN(RADIANS(' . $lat . ')) 
                    * SIN(RADIANS(lat)) 
                    + COS(RADIANS(' . $lat . '))  
                    * COS(RADIANS(lat))
                    * COS(RADIANS(' . $lng . ' - lng)))) * 69.09)';

            $data = User::addSelect(DB::raw($distance_result . " as distance"))->where(function ($query) use ($distance_result, $rad, $user, $destination) {
                if (!empty($distance_result) && !empty($rad)) {
                    return $query->selectRaw("{$distance_result} AS distance")
                        ->whereRaw("{$distance_result} < ?", [$rad]);
                }
                if ($user != null) {
                    return $query->where('id', '!=', $user->id);
                }
                if ($user != null) {
                    return $query->where('address', 'like', '%' . $destination . '%');
                }
            })
                ->with([
                    'trip_mates' => function ($t) use ($activities, $user, $checkedActivities) {
                        return $t->with('images', 'activities')
                            ->whereHas('activities', function ($a) use ($activities, $user, $checkedActivities) {

                                if ($user != null) {
                                    return $a->whereIn('name', 'like', '%' . $activities . '%');
                                }
                                if ($checkedActivities != null && $checkedActivities != "") {
                                    return $a->whereIn('name', $checkedActivities);
                                }
                            })
                            ->whereDate('date_from', ">=", date('Y-m-d'));
                    }
                ])
                ->whereHas('trip_mates', function ($query) use ($fromDate, $toDate) {
                    if ($fromDate) {
                        return $query->whereDate('date_from', '>=', date('Y-m-d', strtotime($fromDate)));
                    } else {
                        return $query->whereDate('date_from', ">=", date('Y-m-d'));
                    }
                    if ($toDate) {
                        return $query->whereDate('date_to', '=<', date('Y-m-d', strtotime($fromDate)));
                    } else {
                        return $query->whereDate('date_from', ">=", date('Y-m-d'));
                    }
                })
                ->paginate(Config::get('global.pagination_records'));
        } else {
            $data = User::withOut('participants')->with([
                'trip_mates' => function ($t) {
                    return $t->with('images', 'activities');
                }
            ])->whereHas('trip_mates', function ($query) {
                return $query->whereDate('date_from', ">=", date('Y-m-d'));
            })->paginate(Config::get('global.pagination_records'));
        }

        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Trip list Successfully';
        $this->response['data'] = $data;
        return response()->json($this->response, $this->status);
    }
    // Send Invitation Request
    public function tripMateInvitation(Request $request)
    {
        try {
            $this->user = $request->user();
            $tripMate = $this->model()::where('id', $request->trip_id)->first();
            $this->provider = User::where('id', $tripMate->user_id)->first();
            $tripMateInvite = TripMateInvitation::where('trip_id', $request->trip_id)->where('request_user_id', $request->user()->id)->first();
            if ($tripMateInvite) {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Trip invitation already sent';
                $this->response['data'] = $tripMateInvite;
                return response()->json($this->response, $this->status);
            } else {
                $tripMateInvitation = new TripMateInvitation();
                $tripMateInvitation->trip_id = $request->trip_id;
                $tripMateInvitation->request_user_id = $request->user()->id;
                $tripMateInvitation->status = "SEND_INVITATION";
                $tripMateInvitation->save();
                $this->tripmate_invitaion_id = $tripMateInvitation->id;

                $title = "Trip Plan";
                $message = "You have 1 new tripmate request. To see invitation details";
                $action     = "user/setting";
                PushNotification::createNotification($this->provider, $request->user()->id, $title, $message, User::TYPE_TRIP_MATE_INVITATION, $action, $tripMateInvitation->id);

                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Trip invitation sent successfully';
                $this->response['data'] = $tripMateInvitation;

                return response()->json($this->response, $this->status);
            }
        } catch (\Exception $e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function getInvitationList(Request $request)
    {
        $userId = $request->user()->id;
        try {
            $tripsInvitations = TripMateInvitation::with(['trip_mate' => function ($q) {
                $q->with('images', 'activities');
            }])->with('users')
                ->whereHas('trip_mate', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                //                ->where('status','!=','REJECTED')
                ->paginate(Config::get('global.pagination_records'));

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Trip list Successfully';
            $this->response['data'] = $tripsInvitations;
            return response()->json($this->response, $this->status);
        } catch (Exception $e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function getSendRequestList(Request $request)
    {
        $userId = $request->user()->id;
        try {
            $tripsInvitations = TripMateInvitation::with(['trip_mate' => function ($q) {
                $q->with('images', 'activities');
            }])->with('users')
                ->where('request_user_id', $request->user()->id)
                ->paginate(Config::get('global.pagination_records'));

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Trip list Successfully';
            $this->response['data'] = $tripsInvitations;
            return response()->json($this->response, $this->status);
        } catch (Exception $e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function latestTripMates()
    {
        $tripMates = User::whereHas('trip_mates', function ($q) {
            $q->whereDate('date_from', ">=", date('Y-m-d'))
                ->orderBy('id', 'DESC');
        })
            ->get()
            ->take(6);
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['message'] = 'Trip list Successfully';
        $this->response['data'] = $tripMates;
        return response()->json($this->response, $this->status);
    }

    public function TripMateDetails($id)
    {
        try {
            $tripMateDetail = TripMate::where('id', $id)
                ->with('images', 'activities', 'single_image', 'users', 'trip_mate_invitation')
                ->first();

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Plan Trip Detail';
            $this->response['data'] = $tripMateDetail;
            return response()->json($this->response, $this->status);
        } catch (\Exception $e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function TripMateDelete($id)
    {
        try {
            Image::where('module_id', $id)->where('module', TripMate::TRIP_MATE)->delete();
            GuideActivity::where('guide_id', $id)->where('type', TripMate::TRIP_MATE)->delete();
            TripMate::where('id', $id)->delete();

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Trip Plan Deleted Successfully';
            return response()->json($this->response, $this->status);
        } catch (\Exception $e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function TripMateAccept(Request $request)
    {
        try {
            $tripMateInvite = TripMateInvitation::where('id', $request->id)->first();
            if ($tripMateInvite) {
                $tripMateInvite->status = "ACCEPTED";
                $tripMateInvite->save();
                $receiver = User::where('id', $tripMateInvite->request_user_id)->first();
                $title = "Trip Plan";
                $message = "Your invitation has been accepted.Now you can chat and discuss the trip plan";
                $action     = "user/setting";
                PushNotification::createNotification($receiver, $request->user()->id, $title, $message, User::TYPE_TRIP_MATE_INVITATION_ACCEPT, $action, $tripMateInvite->id);
            }
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Thank you very much for accepting the invitation, you can chat and discuss the trip plan';
            $this->response['data'] = $tripMateInvite;
            return response()->json($this->response, $this->status);
        } catch (\Exception $e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function TripMateReject(Request $request)
    {
        try {
            $tripMateInvite = TripMateInvitation::where('id', $request->id)->first();
            if ($tripMateInvite) {
                $tripMateInvite->status = "REJECTED";
                $tripMateInvite->save();


                $receiver = User::where('id', $tripMateInvite->request_user_id)->first();
                $title = "Trip Plan";
                $message = "Your invitation has been declined.";
                $action     = "user/setting";
                PushNotification::createNotification($receiver, $request->user()->id, $title, $message, User::TYPE_TRIP_MATE_INVITATION_REJECT, $action, $tripMateInvite->id);
            }
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Invitation request rejected.';
            $this->response['data'] = $tripMateInvite;
            return response()->json($this->response, $this->status);
        } catch (\Exception $e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function sendNotification()
    {
        try {
            $device_token = [];
            $receiver_id = $this->provider->id;
            $deviceTokens = DeviceDetail::select('device_token')->where('user_id', $receiver_id)->get();
            foreach ($deviceTokens as $key => $deviceToken) {
                $device_token[$key] = $deviceToken->device_token;
            }
            $notification = new Notification();
            $notification->user_id = $receiver_id;
            $notification->sender_id = $this->user->id;
            $notification->receiver_id = $receiver_id;
            $notification->message = $this->model()::TITLE;
            $notification->body = $this->model()::MESSAGE;
            $notification->type = $this->model()::TYPE;
            $notification->actions = $this->model()::ACTION;
            $notification->seen = 0;
            $notification->status = $this->model()::STATUS;
            $notification->active = 1;
            $notification->save();
            PushNotification::deviceBadgesUpdate($receiver_id, $this->model()::TYPE);
            PushNotification::sendNotification([
                'message' => $this->model()::MESSAGE,
                'title' => $this->model()::TITLE,
                'device_tokens' => $device_token,
                'user' => $this->provider,
                'payload' => [
                    'id' =>  $this->tripmate_invitaion_id,
                    'type' => $this->model()::TYPE,
                    'sender_id' => $this->user->id,
                ]
            ]);
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Notification send successfully.';
            return response()->json($this->response, $this->status);
        } catch (\Exception $e) {
            $this->status = 401;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }
}
