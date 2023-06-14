<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected $response = [];
    protected $status = 200;
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            //$this->status = 422;
           // echo 'Authentication Fail';exit;
            
            //return route('auth.login');
            http_response_code(401);
            $this->response['success'] = false;
            $this->response['message'] = 'Authentication Fail';
            header('Content-Type: application/json');
		    echo json_encode($this->response); exit;
            //return response()->json($this->response, $this->status);
        }
    }
}
