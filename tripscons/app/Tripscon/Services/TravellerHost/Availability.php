<?php


namespace App\Tripscon\Services\TravellerHost;


use App\Models\AmenityLink;
use App\Tripscon\Interfaces\iHostService;
use App\Models\UserHostAvailability;
use App\Models\UserLanguage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Availability implements iHostService
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
            'we_will_do' => 'required',
            'no_of_people' => 'required',
            'availability_id' => 'required',
            'per_person_price' => 'required',
            'selectedLanguages' => 'required',
            'amenity_list' => 'required',
            'duration' => 'required',
            'available_dates' => 'required',
        ]);

        if ($request->profile_location) {
            $request->validate([
                'location' => 'required',
            ]);
        }
        $availability = \App\Availability::find($request->availability_id);
        $availableDates = $request->available_dates;

        if ((int)$request->id) {
            UserHostAvailability::find((int)$request->id)->update([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'we_will_do' => $request->we_will_do,
                'no_of_people' => (int)$request->no_of_people,
                'per_person_price' => (int)$request->per_person_price,
                'location' => !$request->profile_location && $request->location ? $request->location : null,
                'latitude' => !$request->profile_location && $request->latitude ? round($request->latitude, 8) : null,
                'longitude' => !$request->profile_location && $request->longitude ? round($request->longitude, 8) : null,
                'use_profile_location' => $request->profile_location,
                'duration' => (float)$request->duration,
                'availability_id' => $availability->id,
                'availability_name' => $availability->name,
                'rules' => $request->rules ? json_encode($request->rules) : '',
                'video_url' => $request->video_url ? json_encode($request->video_url) : null,
                'available_dates' => $availableDates ? json_encode($availableDates) : null,
                'active' => true
            ]);
            $record = UserHostAvailability::find($request->id);
            $status = 200;
            $message = 'Record Updated Successfully';
        } else {
            $record = UserHostAvailability::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'we_will_do' => $request->we_will_do,
                'no_of_people' => (int)$request->no_of_people,
                'per_person_price' => (int)$request->per_person_price,
                'location' => !$request->profile_location && $request->location ? $request->location : null,
                'latitude' => !$request->profile_location && $request->latitude ? round($request->latitude, 8) : null,
                'longitude' => !$request->profile_location && $request->longitude ? round($request->longitude, 8) : null,
                'use_profile_location' => $request->profile_location,
                'duration' => (float)$request->duration,
                'availability_id' => $availability->id,
                'availability_name' => $availability->name,
                'rules' => $request->rules ? json_encode($request->rules) : '',
                'video_url' => $request->video_url ? json_encode($request->video_url) : null,
                'available_dates' => $availableDates ? json_encode($availableDates) : null,
                'active' => true
            ]);
            $status = 200;
            $message = 'Record Created Successfully.';
        }

        $amenities = $request->amenity_list;
        AmenityLink::deleteByRef(Auth::id(), $record->id, 'host:availability');
        if ($amenities) {
            foreach ($amenities as $i => $amenity) {
                AmenityLink::updateOrCreate([
                    'description' => $amenity['description'],
                    'position' => $amenity['position'],
                    'active' => 1
                ], [
                    'user_id' => Auth::id(),
                    'ref_id' => $record->id,
                    'ref_type' => 'host:availability',
                    'amenity_id' => $amenity['amenity_id'],
                ]);
            }
        }

        $selectedLanguages = $request->selectedLanguages;
        if ($selectedLanguages) {
            UserLanguage::deleteByUserIdRefIdRefType(Auth::id(), $record->id, 'host:availability');
            foreach ($selectedLanguages as $i => $selectedLanguage) {
                UserLanguage::create([
                    'active' => 1,
                    'user_id' => Auth::id(),
                    'language_id' => $selectedLanguage['id'],
                    'ref_id' => $record->id,
                    'ref_type' => 'host:availability',
                ]);
            }
        }

        // Images uploading
        $allImages = [];
        $files = $request['files'];
        if ($record) {
            if ($record->images) {
                $images = json_decode($record->images);
                if ($images) {
                    foreach ($images as $image) {
                        array_push($allImages, $image);
                    }
                }
            }
        }

        if ($files) {
            $dirPath = 'basic/images/availabilities/';
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
            $record->update([
                'images' => json_encode($allImages)
            ]);
        }
        return response(['message' => $message, 'availability' => $record], $status);
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
        $allAvailability = UserHostAvailability::getByUserId(Auth::id());
        return response(['availability' => $allAvailability], 200);
    }

    /**
     * @inheritDoc
     */
    public function getAllImages($id)
    {
        $allImages = [];
        $hostAvailabiltiy = UserHostAvailability::find($id);
        if ($hostAvailabiltiy) {
            if ($hostAvailabiltiy->images) {
                $images = json_decode($hostAvailabiltiy->images);
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
        $userHostAvailability = UserHostAvailability::find($id);
        if ($userHostAvailability) {
            if ($userHostAvailability->images) {
                $images = json_decode($userHostAvailability->images);
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
        $userHostAvailability->update([
            'images' => json_encode($allImages)
        ]);
        return response()->json(['message' => 'Image Delete Successfully.'], 200);
    }

    /**
     * @inheritDoc
     */
    public function delete($id)
    {
        UserHostAvailability::deleteById($id);
        return response()->json(['message' => 'Record Deleted Successfully.'], 200);
    }

}
