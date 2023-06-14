<?php


namespace App\Tripscon\Services\TravellerHost;


use App\Tripscon\Interfaces\iHostService;
use App\Models\UserTransport;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Transport implements iHostService
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
            'no_of_people' => 'required',
            'type_id' => 'required',
            'model' => 'required',
            'airport_pick_and_drop' => 'required',
            'per_day_price' => 'required',
            'hourly_price' => 'required',
            'free_km' => 'required',
            'transmission' => 'required',
            'assembly' => 'required',
            'engine' => 'required',
            'with_my_diver' => 'required',
            'provide_self_drive' => 'required',
            'insured' => 'required',
            'tracker' => 'required',
            'registration_no' => 'required',
            'full_day_price' => 'required',
            'vehicle_category' => 'required',
            'company' => 'required',
            // 'cc' => 'required',
        ], [
            'no_of_people.required' => 'The sitting capacity field is required.',
            'type_id.required' => 'The transport field field is required.',
            'with_my_diver.required' => 'The provide a driver field is required.',
        ]);

        if ($request->price_type == 'day') {
            $request->validate([
                'out_of_city' => 'required',
            ]);
        }

        if ((int)$request->airport_pick_and_drop_charge == 1) {
            $request->validate([
                'airport_pick_and_drop_charge_price' => 'required|gt:0',
            ]);
        }

        if ((int)$request->insured == 1) {
            if ($request->id) {
                $request->validate([
                    'expiration_date' => 'required',
                ]);
            }else{
                $request->validate([
                    'expiration_date' => 'required',
                    'doc' => 'required',
                ]);
            }
        }

        $doc = $request->doc;
        $dirPath = 'basic/images/documents/';
        $filename = Str::random(40) . '.png';
        $docFile = null;
        if ($doc && $doc !== '[object Object]') {
            if ($request->id) {
                $trans = UserTransport::find($request->id);
                if ($trans && $trans->insurance_document) {
                    deleteFile($trans->insurance_document);
                }
            }
            Image::make($doc)->save(public_path($dirPath . $filename));
            $docFile = json_encode([
                'fileName' => $filename,
                'path' => $dirPath,
                'url' => getDomainName() . '/' . $dirPath . $filename,
                'mimeType' => 'png'
            ]);
        }

        if ($request->id) {
            UserTransport::find($request->id)->update([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'vehicle_id' => (int)$request->type_id,
                'vehicle_name' => Vehicle::find((int)$request->type_id)['name'],
                'no_of_people' => $request->no_of_people,
                'description' => $request->description,
                'per_day_price' => (int)$request->per_day_price,
                'hourly_price' => (int)$request->hourly_price,
                'airport_pick_drop' => (int)$request->airport_pick_and_drop,
                'free_km' => $request->free_km ? (int)$request->free_km : null,
                'extra_km_rate' => $request->extra_km_rate ? (int)$request->extra_km_rate : null,
                'out_of_city' => (int)$request->out_of_city,
                'active' => true,
                'transmission' => $request->transmission,
                'assembly' => $request->assembly,
                'engine' => $request->engine,
                'with_my_diver' => (int)$request->with_my_diver,
                'provide_self_drive' => (int)$request->provide_self_drive,
                'insured' => (int)$request->insured,
                'tracker' => (int)$request->tracker,
                'registration_no' => $request->registration_no,
                'full_day_price' => (int)$request->full_day_price,
                'category' => $request->vehicle_category,
                'company' => $request->company,
                'model' => (int) $request->model,
                'cc' => (int)$request->cc ?? null,
                'accessories' => $request->selectedAccessories ?? null,
                'rules' => json_encode(json_decode($request->rules)) ?? null,
                'video_url' => json_encode(json_decode($request->video_url)) ?? null,
                'airport_pick_and_drop_charge' => (int)$request->airport_pick_and_drop_charge,
                'airport_pick_and_drop_price' => (int)$request->airport_pick_and_drop_charge == 1 ? (int)$request->airport_pick_and_drop_charge_price : null,
                'insurance_expire_date' => (int)$request->insured == 1 ? date("Y-m-d", strtotime($request->expiration_date)) : null,
                'insurance_document' => (int)$request->insured == 1 && $docFile ? $docFile : null,
            ]);
            $transport = UserTransport::find($request->id);
            $status = 200;
            $message = 'Transport Updated Successfully';
        } else {
            $transport = UserTransport::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'vehicle_id' => (int)$request->type_id,
                'vehicle_name' => Vehicle::find((int)$request->type_id)['name'],
                'no_of_people' => $request->no_of_people,
                'description' => $request->description,
                'per_day_price' => (int)$request->per_day_price,
                'hourly_price' => (int)$request->hourly_price,
                'airport_pick_drop' => (int)$request->airport_pick_and_drop,
                'free_km' => $request->free_km ? (int)$request->free_km : null,
                'extra_km_rate' => $request->extra_km_rate ? (int)$request->extra_km_rate : null,
                'out_of_city' => (int)$request->out_of_city,
                'active' => true,
                'transmission' => $request->transmission,
                'assembly' => $request->assembly,
                'engine' => $request->engine,
                'with_my_diver' => (int)$request->with_my_diver,
                'provide_self_drive' => (int)$request->provide_self_drive,
                'insured' => (int)$request->insured,
                'tracker' => (int)$request->tracker,
                'registration_no' => $request->registration_no,
                'full_day_price' => (int)$request->full_day_price,
                'category' => $request->vehicle_category,
                'company' => $request->company,
                'model' => (int) $request->model,
                'cc' => (int)$request->cc ?? null,
                'accessories' => $request->selectedAccessories ?? null,
                'rules' => json_encode(json_decode($request->rules)) ?? null,
                'video_url' => json_encode(json_decode($request->video_url)) ?? null,
                'airport_pick_and_drop_charge' => (int)$request->airport_pick_and_drop_charge,
                'airport_pick_and_drop_price' => (int)$request->airport_pick_and_drop_charge == 1 ? (int)$request->airport_pick_and_drop_charge_price : null,
                'insurance_expire_date' => (int)$request->insured == 1 ? date("Y-m-d", strtotime($request->expiration_date)) : null,
                'insurance_document' => (int)$request->insured == 1 && $docFile ? $docFile : null,
            ]);
            $status = 200;
            $message = 'Transport Created Successfully.';
        }

        // Uploading Images
        $allImages = [];
        $files = json_decode($request['files']);

        if ($transport) {
            if ($transport->images) {
                $images = json_decode($transport->images);
                if ($images) {
                    foreach ($images as $image) {
                        array_push($allImages, $image);
                    }
                }
            }
        }

        if ($files) {
            $dirPath = 'basic/images/transports/';
            foreach ($files as $file) {
                if (!is_array($file) && !isset($file->fileName)) {
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
            $transport->update([
                'images' => json_encode($allImages)
            ]);
        }
        return response(['message' => $message, 'transport' => $transport], $status);
    }

    /**
     * @inheritDoc
     */
    public function uploadImage(Request $request)
    {
        $allImages = [];
        $id = $request->id;
        $file = $request['file'];
        $transport = UserTransport::find($id);
        if ($transport) {
            if ($transport->images) {
                $images = json_decode($transport->images);
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
            $transport->update([
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
        $allTransport = UserTransport::getByUserId(Auth::id());
        return response(['allTransport' => $allTransport], 200);
    }

    /**
     * @inheritDoc
     */
    public function getAllImages($id)
    {
        $allImages = [];
        $transport = UserTransport::find($id);
        if ($transport) {
            if ($transport->images) {
                $images = json_decode($transport->images);
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
        $transport = UserTransport::find($id);
        if ($transport) {
            if ($transport->images) {
                $images = json_decode($transport->images);
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
            $transport->update([
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
        $transport = UserTransport::find($id);
        if ($transport) {
            if ($transport->images) {
                $images = json_decode($transport->images);
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
        $transport->update([
            'images' => json_encode($allImages)
        ]);
        return response()->json(['message' => 'Image Delete Successfully.'], 200);
    }

    /**
     * @inheritDoc
     */
    public function delete($id)
    {
        UserTransport::find($id)->delete();
        return response()->json(['message' => 'Transport Deleted Successfully.'], 200);
    }
}
