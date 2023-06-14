<?php


namespace App\Tripscon\Services\TripOperator;


use App\Models\Activity;
use App\Models\ActivityLink;
use App\Models\AgendaDay;
use App\Models\Facility;
use App\Tripscon\Interfaces\iTripOperatorService;
use App\Models\UserTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Trip implements iTripOperatorService
{
    /**
     * @var array
     */
    protected $res = [];
    protected $status = 200;

    /**
     * @Description Create or Update
     *
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function createOrUpdate(Request $request)
    {
        $allImages = [];
        $refType = 'trip:operator:trip';
        $request->validate([
            'title' => 'required',
            'trip_type' => 'required',
            'level' => 'required',
            'group_size' => 'required',
            'travelers_age' => 'required',
            'selectedActivities' => 'required',
            'location' => 'required',
            'included' => 'required',
            'excluded' => 'required',
            'highlights' => 'required',
            'about_trip' => 'required',
            'instructions' => 'required',
            'price' => 'required',
            'free_age' => 'required',
            'paid_age' => 'required',
            'price_for_paid_age' => 'required',
        ]);

        if ($request->agenda_type == 'daywise') {
            $request->validate([
                'agenda_day' => 'required',
                'agenda' => 'required',
            ]);
        } elseif ($request->agenda_type == 'datewise') {
            $request->validate([
                'agenda_date_from' => 'required',
                'agenda_date_to' => 'required',
                'agenda' => 'required',
            ]);
        }

        if ($request->enquiry_allow) {
            $request->validate([
                'enquiry_response' => 'required|gt:0',
            ]);
        }

        if ($request->id) {
            UserTrip::find((int)$request->id)->update([
                'user_id' => Auth::id(),
                'ref_type' => $refType,
                'title' => $request->title,
                'trip_type' => $request->trip_type,
                'level' => $request->level,
                'group_size' => (int)$request->group_size,
                'travelers_age' => (int)$request->travelers_age,
                'enquiry_allow' => $request->enquiry_allow,
                'enquiry_response' => (int)$request->enquiry_response ?? null,
                'location' => $request->location ? json_encode($request->location) : null,
                'included' => $request->included ? json_encode($request->included) : null,
                'excluded' => $request->excluded ? json_encode($request->excluded) : null,
                'highlights' => $request->highlights ? json_encode($request->excluded) : null,
                'about_trip' => $request->about_trip ?? null,
                'instructions' => $request->instructions ?? null,
                'agenda_type' => $request->agenda_type,
                'agenda_day' => $request->agenda_type == 'daywise' ? (int)$request->agenda_day : null,
                'agenda_date_from' => $request->agenda_date_from ?? null,
                'agenda_date_to' => $request->agenda_date_to ?? null,
                'price' => (int)$request->price,
                'free_age' => (int)$request->free_age,
                'paid_age' => (int)$request->paid_age,
                'price_for_paid_age' => (int)$request->price_for_paid_age,
            ]);
            $trip = UserTrip::find((int)$request->id);
            $this->res['message'] = 'trip Updated Successfully.';
        } else {
            $trip = UserTrip::create([
                'user_id' => Auth::id(),
                'ref_type' => $refType,
                'title' => $request->title,
                'trip_type' => $request->trip_type,
                'level' => $request->level,
                'group_size' => (int)$request->group_size,
                'travelers_age' => (int)$request->travelers_age,
                'enquiry_allow' => $request->enquiry_allow,
                'enquiry_response' => (int)$request->enquiry_response ?? null,
                'location' => $request->location ? json_encode($request->location) : null,
                'included' => $request->included ? json_encode($request->included) : null,
                'excluded' => $request->excluded ? json_encode($request->excluded) : null,
                'highlights' => $request->highlights ? json_encode($request->excluded) : null,
                'about_trip' => $request->about_trip ?? null,
                'instructions' => $request->instructions ?? null,
                'agenda_type' => $request->agenda_type,
                'agenda_day' => $request->agenda_type == 'daywise' ? (int)$request->agenda_day : null,
                'agenda_date_from' => $request->agenda_date_from ?? null,
                'agenda_date_to' => $request->agenda_date_to ?? null,
                'price' => (int)$request->price,
                'free_age' => (int)$request->free_age,
                'paid_age' => (int)$request->paid_age,
                'price_for_paid_age' => (int)$request->price_for_paid_age,
            ]);
            $this->res['message'] = 'trip Created Successfully.';
        }

        $selectedActivities = $request->selectedActivities;
        ActivityLink::deleteByRef($trip->id, $refType);
        if ($selectedActivities) {
            foreach ($selectedActivities as $i => $selectedActivity) {
                $activity = Activity::getByName($selectedActivity['name']);
                if ($activity) {
                    ActivityLink::create([
                        'active' => 1,
                        'type' => $refType,
                        'ref_id' => $trip->id,
                        'activity_id' => $activity->id
                    ]);
                }
            }
        }

        $agendas = $request->agenda;
        AgendaDay::deleteByRef(Auth::id(), $trip->id, $refType);
        if ($agendas) {
            foreach ($agendas as $agenda) {
                $dayNo = $agenda['dayNumber'];
                $activities = $agenda['activities'];
                if ($activities) {
                    foreach ($activities as $activity) {
                        AgendaDay::create([
                            'user_id' => Auth::id(),
                            'ref_id' => $trip->id,
                            'ref_type' => $refType,
                            'day' => $dayNo,
                            'time' => $activity['time'],
                            'description' => $activity['description'],
                            'location' => $activity['location'] ? json_encode($activity['location']) : '',
                        ]);
                    }
                }
            }
        }

        // images upload
        $files = $request['files'];
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

        if ($files) {
            $dirPath = 'basic/images/trips/';
            foreach ($files as $file) {
                if (!is_array($file)) {
                    $filename = Str::random(40) . '.png';
                    $imageInfo = explode(";base64,", $file);
                    $image = str_replace(' ', '+', $imageInfo[1]);
                    file_put_contents(public_path($dirPath . $filename), base64_decode($image));
                    array_push($allImages, [
                        'primary' => $allImages ? 0 : 1,
                        'fileName' => $filename,
                        'path' => $dirPath,
                        'url' => getDomainName() . '/' . $dirPath . $filename,
                        'mimeType' => 'png'
                    ]);
                }
            }
        }
        if ($allImages) {
            $trip->update([
                'images' => json_encode($allImages)
            ]);
        }

        return response()->json($this->res, $this->status);
    }

    /**
     * @Description Upload Image
     *
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function uploadImage(Request $request)
    {
        // TODO: Implement uploadImage() method.
    }

    /**
     * @Description Get All Record
     *
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function getAll()
    {
        $allTrips = UserTrip::getAllByUserId(Auth::id(), 'trip:operator:trip');
        return response(['allTrips' => $allTrips], 200);
    }

    /**
     * @Description Get All Images of single record
     *
     * @param $id
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function getAllImages($id)
    {
        $allImages = [];
        $trip = UserTrip::find($id);
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

        return response([
            'images' => $allImages,
        ], 200);
    }

    /**
     * @Description Make Primary Image
     *
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function makePrimaryImage(Request $request)
    {
        // TODO: Implement makePrimaryImage() method.
    }

    /**
     * @Description Delete Image
     *
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function deleteImage(Request $request)
    {
        $allImages = [];
        $id = $request->id;
        $fileName = $request->fileName;
        $trip = UserTrip::find($id);
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
     * @Description delete record
     *
     * @param $id
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function delete($id)
    {
        UserTrip::find($id)->delete();
        AgendaDay::deleteByRef(Auth::id(),$id,'trip:operator:trip');
        ActivityLink::deleteByRef($id,'trip:operator:trip');
        return response()->json(['message' => 'Trip Deleted Successfully.'], 200);
    }
}
