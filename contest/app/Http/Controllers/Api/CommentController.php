<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entry;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    
    protected $status = 200;
    protected $response = [];

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), 
            [
                'comment_body' => 'required',
                'entry_id' => 'numeric'
            ]
        );
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $entries = Entry::find($request->get('entry_id'));
        if(!empty($entries)){
            
            $comment = new Comment;
            $comment->comment_body = $request->get('comment_body');
            $comment->user()->associate($request->user());
            $entries->comments()->save($comment);


            $comments = Comment::where('id', $comment->id)->with(['user' => function($query){
                return $query->select('id', 'name', 'email', 'image', 'type');
            }])->where('commentable_id', $entries->id)->whereNull('parent_id')->first();
            
            if(!empty($comments)){
                foreach ($comments as $key => $value) {
                    if(isset($value->replies) && !empty($value->replies)){
                        foreach ($value->replies as $index => $val) {
                            if(!empty($val->reply)){
                                foreach ($val->reply as $k => $v) {
                                    $value->replies[] = $v;
                                }
                                unset($val->reply);
                            }
                        }

                    }
                }
            }

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $comments;

        }else{
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Entry id not correct, Please enter valid id.';
        }
        return response()->json($this->response, $this->status);
    }

    public function replyStore(Request $request)
    {

        $validator = Validator::make($request->all(), 
            [
                'comment_body' => 'required',
                'entry_id' => 'numeric',
                'comment_id' => 'numeric',
                'parent_comment_id' => 'required',
            ]
        );
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $entries = Entry::find($request->get('entry_id'));
        
        if(!empty($entries)){
            $comment = Comment::find($request->get('comment_id'));
            $reply = new Comment();
            $reply->comment_body = $request->get('comment_body');
            $reply->user()->associate($request->user());
            $reply->parent_id = $request->get('comment_id');
            $reply->parent_comment_id = $request->get('parent_comment_id');
            $reply->parent_user_id = $comment->user_id;
            $entries->comments()->save($reply);

            $comments = Comment::where('id', $reply->id)->with(['user' => function($query){
                return $query->select('id', 'name', 'email', 'image', 'type');
            },'user' => function($query){
                return $query->select('id', 'name', 'email', 'image', 'type');
            },'parentUser'])->where('commentable_id', $entries->id)->first();
            
            if(!empty($comments)){
                foreach ($comments as $key => $value) {
                    if(isset($value->replies) && !empty($value->replies)){
                        foreach ($value->replies as $index => $val) {
                            if(!empty($val->reply)){
                                foreach ($val->reply as $k => $v) {
                                    $value->replies[] = $v;
                                }
                                unset($val->reply);
                            }
                        }

                    }
                }
            }


            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $comments;

        }else{

            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Entry id not correct, Please enter valid id.';
        
        }
        return response()->json($this->response, $this->status);

    }


    public function getComments(Request $request){

        $validator = Validator::make($request->all(), 
            [
                'entry_id' => 'numeric'
            ]
        );
        if ($validator->fails()) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $validator->messages()->first();
            return response()->json($this->response, $this->status);
        }

        $entries = Entry::find($request->get('entry_id'));
        
        if(!empty($entries)){

            $comments = Comment::with(['user' => function($query){
                return $query->select('id', 'name', 'email', 'image', 'type');
            },'replies', 'replies.user' => function($query){
                return $query->select('id', 'name', 'email', 'image', 'type');
            },'replies.parentUser'])->where('commentable_id', $entries->id)->whereNull('parent_id')->orderBy('id','DESC')->paginate(config()->get('global.pagination_records'))->toArray();
            
            // dd($comments);

            // if(!empty($comments)){
            //     foreach ($comments as $key => $value) {
            //         if(isset($value->replies) && !empty($value->replies)){
            //             foreach ($value->replies as $index => $val) {
            //                 if(!empty($val->reply)){
            //                     foreach ($val->reply as $k => $v) {
            //                         $value->replies[] = $v;
            //                     }
            //                     unset($val->reply);
            //                 }
            //             }

            //         }
            //     }
            // }

            // if (!empty($comments)) {
            //     foreach ($comments as $comment) {
            //         $replies = $comment->replies ?? [];
            //         $comment->replies = $replies->map(function ($reply) {
            //             if (!empty($reply->comments) && !empty($reply->comments->parentUser)) {
            //                 $reply->parent_user = $reply->comments->parentUser;
            //             }
            //             unset($reply->comments);
            //             return $reply;
            //         });
            //     }
            // }
            
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['data'] = $comments;

        }else{

            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Entry id not correct, Please enter valid id.';
        
        }
        return response()->json($this->response, $this->status);

    }

}
