<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Gallery;

class UploadVideosController extends Controller
{
    
    protected $status = 200;
    protected $response = [];

    public function uploadVideo(Request $request){

        $validator = Validator::make($request->all(), [
            'video_file' => 'required|file|max:10240|mimetypes:video/mp4',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        if($request->hasFile('video_file')) {
            $img_ext = $request->file('video_file')->getClientOriginalExtension();
            $filename = 'testominals-video-' . time() . '.' . $img_ext;
            $path = $request->file('video_file')->move(public_path('assets/uploads/galleries'), $filename);//image save public folder
        
            $data = new Gallery;
            $data->name = $filename;
            $data->type = 'video';
            $data->user_module_type = auth()->user()->user_module_type;
            $data->user_id = auth()->user()->id;
            if ($data->save()) {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Video save successfully';
                $this->response['imagePath'] = $filename;
                $this->response['data'] = $data;
            } else {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'SomeThing Went Wrong!.';
            }
        }

        return response()->json($this->response, $this->status);

    }

    public function uploadVideoUrl(Request $request){

        $validator = Validator::make($request->all(), [
            'video_file' => 'required',
        ]);

        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $array_data = [];

        if(isset($request->video_file) && !empty($request->video_file) && json_decode($request->video_file, true)){
            $videos_url = json_decode($request->video_file, true);
            foreach ($videos_url as $key => $value) {
                array_push($array_data,['name' => $value['video_file'], 'type' => 'video', 'user_module_type' => auth()->user()->user_module_type, 'user_id' => auth()->user()->id]);
            }
            $result = Gallery::insert($array_data);
            
            if ($result) {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Video save successfully';
                $this->response['data'] = $array_data;
            } else {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'SomeThing Went Wrong!.';
            }

        }else{

            $data = new Gallery;
            $data->name = $request->video_file;
            $data->type = 'video';
            $data->user_module_type = auth()->user()->user_module_type;
            $data->user_id = auth()->user()->id;
            if ($data->save()) {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Video save successfully';
                $this->response['data'] = $data;
            } else {
                $this->status = 422;
                $this->response['success'] = false;
                $this->response['message'] = 'SomeThing Went Wrong!.';
            }
        }

        return response()->json($this->response, $this->status);
    }
  
}
