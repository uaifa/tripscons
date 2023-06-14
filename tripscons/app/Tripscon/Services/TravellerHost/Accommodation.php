<?php


namespace App\Tripscon\Services\TravellerHost;


use App\Models\AboutAccommodation;
use App\Models\AboutAccommodationLink;
use App\Models\AccommodationSubType;
use App\Models\AccommodationType;
use App\Models\BedsTypesLink;
use App\Models\Facility;
use App\Models\FacilityLink;
use App\Models\NearByPlacesLink;
use App\Models\SafetyAmenityLink;
use App\Models\ShareAccommodationLink;
use App\Tripscon\Interfaces\iHostService;
use App\Models\UserAccommodation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Accommodation implements iHostService
{

    /**
     * @inheritDoc
     */
    public function createOrUpdate(Request $request)
    {
        $status = 422;
        $message = 'Unprocessable Entity';

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'no_of_people' => 'required|gt:0',
            'selectedFacilities' => 'required',
            'perNight' => 'required|gt:0',
            'latitude' => 'required',
            'longitude' => 'required',
            'location' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
            'type_id' => 'required',
            'sub_type_id' => 'required',
            'property_type' => 'required',
            'phone_code' => 'required',
//            'noticeBeforeGuest' => 'required|gt:0',
            'canStayExtraDaysMax' => 'required|gt:0',
            'canStayExtraDaysMin' => 'required|gt:0',
            'personalSetup' => 'required',
//            'getInTouch' => 'required',
            'selectedArrangements' => 'required',
            'arrangementCounters' => 'required',
        ], [
            'location.required' => 'Please, Enter Address.',
            'latitude.required' => 'Please, Select address from map.',
            'longitude.required' => 'Please, Select address from map.',
            'type_id.required' => 'Please, Select Accommodation Type.',
            'sub_type_id.required' => 'Please, Select Accommodation Exact Type.',
            'property_type.required' => 'Please, What kind of place is required.',
//            'noticeBeforeGuest.required' => 'Please, Enter Days for notice.',
            'canStayExtraDaysMax.required' => 'Please, Enter Days for user can stay maximum.',
            'canStayExtraDaysMin.required' => 'Please, Enter Days for user can stay minimum.',
            'selectedArrangements.required' => 'Please, Add sleeping arrangements.',
            'arrangementCounters.required' => 'Please, Add sleeping arrangements.',
        ]);

        if ($request->noticeBeforeType == 'hours') {
            $request->validate([
                'noticeBeforeHours' => 'required|gt:0',
            ]);
        } elseif ($request->noticeBeforeType == 'days') {
            $request->validate([
                'noticeBeforeDays' => 'required|gt:0',
            ]);
        }
        if ($request->enquiry_allow) {
            $request->validate([
                'enquiry_response' => 'required|gt:0',
            ]);
        }
        if ($request->smart_pricing) {
            $request->validate([
                'min_price' => 'required|gt:0',
                'max_price' => 'required|gt:0',
            ]);
        }
        if ($request->useProfileNumber == false) {
            $request->validate([
                'phone' => 'required',
            ]);
        }
        if ((int)$request->sub_type_id == 1) {
            $request->validate([
                'apartment_type' => 'required',
            ]);
        } elseif ((int)$request->sub_type_id == 2) {
            $request->validate([
                'flats' => 'required',
            ]);
        } elseif ((int)$request->sub_type_id == 10) {
            $request->validate([
                'stars' => 'required',
            ]);
        }

        if ((int)$request->type_id == 1 || (int)$request->type_id == 2) {
            $request->validate([
                'rooms' => 'required',
            ]);
        }

        if ($request->id) {
            $accommodation = UserAccommodation::find($request->id);
            UserAccommodation::find($request->id)->update([
                'title' => $request->title,
                'type' => $request->type,
                'no_of_people' => $request->no_of_people,
                'description' => $request->description,
                'per_night' => (int)$request->perNight,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'latitude' => round($request->latitude, 8),
                'longitude' => round($request->longitude, 8),
                'rules' => $request->rules ? json_encode($request->rules) : '',
                'active' => true,
                'type_id' => (int)$request->type_id,
                'type_name' => AccommodationType::find((int)$request->type_id)['name'],
                'sub_type_id' => (int)$request->sub_type_id,
                'sub_type_name' => AccommodationSubType::find((int)$request->sub_type_id)['name'],
                'property_type' => (string)$request->property_type,
                'smart_pricing' => $request->smart_pricing ? 1 : 0,
                'min_price' => (int)$request->min_price,
                'max_price' => (int)$request->max_price,
                'can_stay_max' => (int)$request->canStayExtraDaysMax,
                'can_stay_min' => (int)$request->canStayExtraDaysMin,
                'private_bath' => (int)$request->privateBath,
                'personal_setup' => (int)$request->personalSetup,
//                'listing_as_company' => (int)$request->listingAsCompany,
                'discount_week_1' => (int)$request->week_1_discount,
                'discount_week_2' => (int)$request->week_2_discount,
                'discount_week_3' => (int)$request->week_3_discount,
                'discount_week_4' => (int)$request->week_4_discount,
                'use_profile_number' => $request->useProfileNumber ? 1 : 0,
                'phone' => (int)$request->phone,
                'phone_code' => $request->phone_code,
//                'guest_can_contact' => (int)$request->getInTouch,
                'clean_fee' => (int)$request->clean_fee ?? 0,
                'service_fee' => (int)$request->service_fee ?? 0,
//                'taxes_fees' => (int)$request->taxes_fees ?? 0,
                'limit_people' => (int)$request->limit_people ?? 0,
                'extra_price' => (int)$request->extra_price ?? 0,
//                'country' => $location ? (string)$location['country'] : $accommodation->country,
//                'state' => $location ? (string)$location['administrative_area_level_1'] : $accommodation->state,
//                'city' => $location ? (string)$location['locality'] : $accommodation->city,
                'enquiry_allow' => $request->enquiry_allow,
                'enquiry_response' => (int)$request->enquiry_response ?? null,
                'pre_arrival_notice' => (string)$request->noticeBeforeType,
                'notice_before_in_days' => (int)$request->noticeBeforeDays,
                'notice_before_in_hours' => (int)$request->noticeBeforeHours,
                'location' => $request->location,
                'shared_bath' => (int)$request->sharedBath,
                'flexibility_hours' => $request->allow_flex_hour && (int)$request->flexibility_hours ? (int)$request->flexibility_hours : null,
                'occupancy_limit_percentage' => (int)$request->occupancy_limit_percentage,
                'occupancy_rate_percentage' => (int)$request->occupancy_rate_percentage,
                'advance_pay' => (int)$request->advance_pay,
                'video_url' => $request->video_url ? json_encode($request->video_url) : null,
                'apartment_type' => (int)$request->sub_type_id == 1 ? $request->apartment_type : null,
                'flats' => (int)$request->sub_type_id == 2 ? $request->flats : null,
                'stars' => (int)$request->sub_type_id == 10 ? $request->stars : null,
                'rooms' => (int)$request->type_id == 1 || (int)$request->type_id == 2 ? $request->rooms : null,
                'important_points' => $request->aboutAccommodationDesc ? json_encode($request->aboutAccommodationDesc) : null,
                'belongings' => (int)$request->personalSetup == 1 && $request->belongings ? json_encode($request->belongings) : null,

            ]);
            $accommodation = UserAccommodation::find($request->id);
            $status = 200;
            $message = 'Accommodation Updated Successfully';
        } else {
            $accommodation = UserAccommodation::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'type' => $request->type,
                'no_of_people' => $request->no_of_people,
                'description' => $request->description,
                'per_night' => (int)$request->perNight,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'latitude' => round($request->latitude, 8),
                'longitude' => round($request->longitude, 8),
                'rules' => $request->rules ? json_encode($request->rules) : '',
                'active' => true,
                'type_id' => (int)$request->type_id,
                'type_name' => AccommodationType::find((int)$request->type_id)['name'],
                'sub_type_id' => (int)$request->sub_type_id,
                'sub_type_name' => AccommodationSubType::find((int)$request->sub_type_id)['name'],
                'property_type' => (string)$request->property_type,
                'smart_pricing' => $request->smart_pricing ? 1 : 0,
                'min_price' => (int)$request->min_price,
                'max_price' => (int)$request->max_price,
                'can_stay_max' => (int)$request->canStayExtraDaysMax,
                'can_stay_min' => (int)$request->canStayExtraDaysMin,
                'private_bath' => (int)$request->privateBath,
                'personal_setup' => (int)$request->personalSetup,
//                'listing_as_company' => (int)$request->listingAsCompany,
                'discount_week_1' => (int)$request->week_1_discount,
                'discount_week_2' => (int)$request->week_2_discount,
                'discount_week_3' => (int)$request->week_3_discount,
                'discount_week_4' => (int)$request->week_4_discount,
                'use_profile_number' => $request->useProfileNumber ? 1 : 0,
                'phone' => (int)$request->phone,
                'phone_code' => $request->phone_code,
//                'guest_can_contact' => (int)$request->getInTouch,
                'clean_fee' => (int)$request->clean_fee ?? 0,
                'service_fee' => (int)$request->service_fee ?? 0,
//                'taxes_fees' => (int)$request->taxes_fees ?? 0,
                'limit_people' => (int)$request->limit_people ?? 0,
                'extra_price' => (int)$request->extra_price ?? 0,
//                'country' => $location ? (string)$location['country'] : '',
//                'state' => $location ? (string)$location['administrative_area_level_1'] : '',
//                'city' => $location ? (string)$location['locality'] : '',
                'enquiry_allow' => $request->enquiry_allow,
                'enquiry_response' => (int)$request->enquiry_response ?? null,
                'pre_arrival_notice' => (string)$request->noticeBeforeType,
                'notice_before_in_days' => (int)$request->noticeBeforeDays,
                'notice_before_in_hours' => (int)$request->noticeBeforeHours,
                'location' => $request->location,
                'shared_bath' => (int)$request->sharedBath,
                'flexibility_hours' => $request->allow_flex_hour && (int)$request->flexibility_hours ? (int)$request->flexibility_hours : null,
                'occupancy_limit_percentage' => (int)$request->occupancy_limit_percentage,
                'occupancy_rate_percentage' => (int)$request->occupancy_rate_percentage,
                'advance_pay' => (int)$request->advance_pay,
                'video_url' => $request->video_url ? json_encode($request->video_url) : null,
                'apartment_type' => (int)$request->sub_type_id == 1 ? $request->apartment_type : null,
                'flats' => (int)$request->sub_type_id == 2 ? $request->flats : null,
                'stars' => (int)$request->sub_type_id == 10 ? $request->stars : null,
                'rooms' => (int)$request->type_id == 1 || (int)$request->type_id == 2 ? $request->rooms : null,
                'important_points' => $request->aboutAccommodationDesc ? json_encode($request->aboutAccommodationDesc) : null,
                'belongings' => (int)$request->personalSetup == 1 && $request->belongings ? json_encode($request->belongings) : null,
            ]);
            $status = 200;
            $message = 'Accommodation Created Successfully.';
        }

        // Beds Details and total
        $arrangementCounters = $request->arrangementCounters;
        BedsTypesLink::deleteByAccommodationId(Auth::id(), $accommodation->id);
        if ($request->selectedArrangements && $arrangementCounters) {
            foreach ($request->selectedArrangements as $selectedArrangement) {
                $id = $selectedArrangement['id'];
                $counter = collect($arrangementCounters)->where('id', $id)->first()['counter'];
                if ($counter > 0) {
                    BedsTypesLink::create([
                        'user_id' => Auth::id(),
                        'accommodation_id' => $accommodation->id,
                        'bed_type_id' => $id,
                        'bed_name' => $selectedArrangement['name'],
                        'total' => $counter,
                    ]);
                }
            }
        }

        // About Accommodation with description
//        $aboutAccommodationDesc = $request->aboutAccommodationDesc;
//        AboutAccommodationLink::deleteByAccommodationId(Auth::id(), $accommodation->id);
//        if ($request->aboutAccommodationId && $aboutAccommodationDesc) {
//            foreach ($request->aboutAccommodationId as $id => $val) {
//                $aboutAcc = AboutAccommodation::find($id);
//                if ($val && $aboutAcc) {
//                    AboutAccommodationLink::create([
//                        'user_id' => Auth::id(),
//                        'accommodation_id' => $accommodation->id,
//                        'question_id' => $aboutAcc->id,
//                        'question' => $aboutAcc->question,
//                        'description' => $aboutAccommodationDesc[$id],
//                    ]);
//                }
//            }
//        }

        // Store Share things
        ShareAccommodationLink::deleteByAccommodationId(Auth::id(), $accommodation->id);
        if ($request->selectedShareAccommodation) {
            foreach ($request->selectedShareAccommodation as $share) {
                ShareAccommodationLink::create([
                    'user_id' => Auth::id(),
                    'accommodation_id' => $accommodation->id,
                    'share_id' => $share['id'],
                    'share_name' => $share['name']
                ]);
            }
        }

        // Safety Amenities store
        SafetyAmenityLink::deleteByAccommodationId(Auth::id(), $accommodation->id);
        if ($request->selectedSafetyAmenitiy) {
            foreach ($request->selectedSafetyAmenitiy as $amenity) {
                SafetyAmenityLink::create([
                    'user_id' => Auth::id(),
                    'accommodation_id' => $accommodation->id,
                    'safety_amenity_id' => $amenity['id'],
                    'safety_amenity_title' => $amenity['title']
                ]);
            }
        }

        // Facilities
        FacilityLink::deleteByRef(Auth::id(), $accommodation->id, 'host:accommodation');
        $facilities = $request['selectedFacilities'];
        if ($facilities) {
            foreach ($facilities as $facility) {
                $facilityData = Facility::getByName($facility['name']);
                if ($facility) {
                    FacilityLink::create([
                        'user_id' => Auth::id(),
                        'ref_id' => $accommodation->id,
                        'ref_type' => 'host:accommodation',
                        'facility_id' => $facilityData->id
                    ]);
                }
            }
        }

        // Near by Place
        NearByPlacesLink::deleteByRef(Auth::id(), $accommodation->id, 'host:accommodation');
        if ($request->selectedNearByPlacesDetail) {
            foreach ($request->selectedNearByPlacesDetail as $place) {
                NearByPlacesLink::create([
                    'user_id' => Auth::id(),
                    'ref_id' => $accommodation->id,
                    'ref_type' => 'host:accommodation',
                    'place_id' => $place['id'],
                    'place_name' => $place['name'],
                    'location' => $place['location'],
                    'latitude' => $place['lat'],
                    'longitude' => $place['lng'],
                ]);
            }
        }

        // Images uploading
        $allImages = [];
        $files = $request['files'];
        if ($accommodation) {
            if ($accommodation->images) {
                $images = json_decode($accommodation->images);
                if ($images) {
                    foreach ($images as $image) {
                        array_push($allImages, $image);
                    }
                }
            }
        }

        if ($files) {
            $dirPath = 'basic/images/accommodations/';
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
        if ($allImages && $allImages != []) {
            $accommodation->update([
                'images' => json_encode($allImages)
            ]);
        }

        return response(['message' => $message, 'accommodation' => $accommodation], $status);
    }

    /**
     * @inheritDoc
     */
    public function uploadImage(Request $request)
    {
        $allImages = [];
        $id = $request->id;
        $file = $request['file'];
        $accommodation = UserAccommodation::find($id);
        if ($accommodation) {
            if ($accommodation->images) {
                $images = json_decode($accommodation->images);
                if ($images) {
                    foreach ($images as $image) {
                        array_push($allImages, $image);
                    }
                }
            }
        }

        if ($file) {
            $dirPath = 'basic/images/accommodations/';
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
            $accommodation->update([
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
        $allAccommodation = UserAccommodation::getByUserId(Auth::id());
        return response(['allAccommodations' => $allAccommodation], 200);
    }

    /**
     * @inheritDoc
     */
    public function getAllImages($id)
    {
        $allImages = [];
        $accommodation = UserAccommodation::find($id);
        if ($accommodation) {
            if ($accommodation->images) {
                $images = json_decode($accommodation->images);
                if ($images) {
                    foreach ($images as $image) {
                        array_push($allImages, $image);
                    }
                }
            }
        }

        return response([
            'images' => $allImages,
            'facilities' => Facility::getFacilitiesByRef(Auth::id(), $id, 'host:accommodation')
        ], 200);
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
        $accommodation = UserAccommodation::find($id);
        if ($accommodation) {
            if ($accommodation->images) {
                $images = json_decode($accommodation->images);
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
            $accommodation->update([
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
        $accommodation = UserAccommodation::find($id);
        if ($accommodation) {
            if ($accommodation->images) {
                $images = json_decode($accommodation->images);
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
        $accommodation->update([
            'images' => json_encode($allImages)
        ]);
        return response()->json(['message' => 'Image Delete Successfully.'], 200);
    }

    /**
     * @inheritDoc
     */
    public function delete($id)
    {
        UserAccommodation::find($id)->delete();
        return response()->json(['message' => 'Accommodation Deleted Successfully.'], 200);
    }
}
