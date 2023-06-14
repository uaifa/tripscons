<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Validator;

class GalleriesController extends Controller
{
    
    protected $status = 200;
    protected $response = [];
    
    public function uploadGallryImages(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,NEF,nef,svg|max:5120',
        ]);
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }
        try {
            if ($files = $request->file('image')) {
                $image_full_name = pathinfo($files->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('assets/uploads/galleries'); //Creating Sub directory in Public 
                $img = \Image::make($files->getRealPath());
                $width = getimagesize($files)[0];
                $height = getimagesize($files)[1];
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
                
                $data = new Gallery;
                $data->name = $image_full_name;
                $data->user_module_type = auth()->user()->user_module_type;
                $data->user_id = auth()->user()->id;
                
                if ($data->save()) {
                    $this->status = 200;
                    $this->response['success'] = true;
                    $this->response['message'] = 'Updated Successfully';
                    $this->response['imagePath'] = $image_full_name;
                    $this->response['data'] = $data;
                } else {
                    $this->status = 422;
                    $this->response['success'] = false;
                    $this->response['message'] = 'SomeThing Went Wrong!.';
                }
                return response()->json($this->response, $this->status);

            }
        } catch (Exception $e) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = "Image Size is greater than 2 MB";
            return response()->json($this->response, $this->status);
        }
    }

    public function deleteGalleryImage($image_id)
    {
        $modelImage = Gallery::where('id', $image_id)->first();
        if($modelImage){
            $image_path = public_path() . '/assets/uploads/galleries/' . $modelImage->name;
            if (file_exists($image_path)) {
                unlink($image_path);
                $modelImage->delete();
            }else{
                $modelImage->delete();
            }
            $this->status = 200;
            $this->response['data'] = $image_path;
            $this->response['success'] = true;
            $this->response['message'] = 'Image Deleted Successfully';
            return response()->json($this->response, $this->status);
        }

        $this->status = 200;
        $this->response['data'] = [];
        $this->response['success'] = true;
        $this->response['message'] = 'Record not found';
        return response()->json($this->response, $this->status);
    }
    public function getGalleryImages(){
        $galleries = Gallery::where('user_id', auth()->user()->id)->get();
        $this->status = 200;
        $this->response['data'] = $galleries;
        $this->response['success'] = true;
        return response()->json($this->response, $this->status);
    }

    public function uploadGalleryImageBase64(Request $request){

        $folderPath = '/assets/uploads/' . request()->module.'/';
        // $image_parts = [];
        $image_parts = explode(";base64,", request()->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $image_full_name = uniqid().strtotime("now"). '.'.$image_type;
        $file = $folderPath.$image_full_name;

        //return public_path().$folderPath;

        if (!file_exists(public_path().$folderPath)) {
            mkdir(public_path().$folderPath, 0777, true);
        }

        $success = file_put_contents(public_path().'/'.$file, $image_base64);

        $data = new Gallery;
        $data->name = $image_full_name;
        $data->user_module_type = auth()->user()->user_module_type;
        $data->user_id = auth()->user()->id;

        if ($data->save()) {
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Updated Successfully';
            $this->response['imagePath'] = $image_full_name;
            $this->response['data'] = $data;
        } else {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'SomeThing Went Wrong!.';
        }
        return response()->json($this->response, $this->status);

    }
}
