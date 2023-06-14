<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Requests\Admin\DeviceDetail\BulkDestroyDeviceDetail;
use App\Http\Requests\Admin\DeviceDetail\DestroyDeviceDetail;
use App\Http\Requests\Admin\DeviceDetail\IndexDeviceDetail;
use App\Http\Requests\Admin\DeviceDetail\StoreDeviceDetail;
use App\Http\Requests\Admin\DeviceDetail\UpdateDeviceDetail;
use App\Models\DeviceBadge;
use App\Models\DeviceDetail;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DeviceDetailsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexDeviceDetail $request
     * @return array|Factory|View
     */
    public function index(IndexDeviceDetail $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(DeviceDetail::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'user_id', 'device_id', 'device_token', 'device_type', 'status'],

            // set columns to searchIn
            ['id', 'device_id', 'device_token', 'device_type', 'status']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.device-detail.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.device-detail.create');

        return view('admin.device-detail.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDeviceDetail $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreDeviceDetail $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the DeviceDetail
        $deviceDetail = DeviceDetail::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/device-details'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/device-details');
    }

    /**
     * Display the specified resource.
     *
     * @param DeviceDetail $deviceDetail
     * @throws AuthorizationException
     * @return void
     */
    public function show(DeviceDetail $deviceDetail)
    {
        $this->authorize('admin.device-detail.show', $deviceDetail);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DeviceDetail $deviceDetail
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(DeviceDetail $deviceDetail)
    {
        $this->authorize('admin.device-detail.edit', $deviceDetail);


        return view('admin.device-detail.edit', [
            'deviceDetail' => $deviceDetail,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDeviceDetail $request
     * @param DeviceDetail $deviceDetail
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateDeviceDetail $request, DeviceDetail $deviceDetail)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values DeviceDetail
        $deviceDetail->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/device-details'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/device-details');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyDeviceDetail $request
     * @param DeviceDetail $deviceDetail
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyDeviceDetail $request, DeviceDetail $deviceDetail)
    {
        $deviceDetail->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyDeviceDetail $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyDeviceDetail $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DeviceDetail::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function deviceDetailCreate(Request $request){
        $user = $request->user();
        $device_id = $request->device_id;
        $device_token =$request->device_token;
        $user_id =$request->user_id;
        try {
            $device_details = DeviceDetail::where('device_id',$device_id)->where('device_token',$device_token)->get();
            if (count($device_details) > 0) {
                DeviceDetail::where('device_id',$device_id)->where('device_token',$device_token)->delete();
                $DeviceDetail = DeviceDetail::create([
                    'device_id' => $device_id,
                    'device_token' => $device_token,
                    'user_id' => $user_id,
                    'status'=>'ACTIVE'
                ]);
            } else {
                $DeviceDetail = DeviceDetail::create([
                    'device_id' => $device_id,
                    'device_token' => $device_token,
                    'user_id' => $user_id,
                    'status'=>'ACTIVE'
                ]);
            }
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Device Details Created Successfully.';
            $this->response['data'] = $DeviceDetail;
            return response()->json($this->response, $this->status);
        }
        catch (Exception $e){
            $this->status = 200;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function removeDeviceDetails(Request $request)
    {
        try {
            $user = $request->user();
            $deviceTokens = DeviceDetail::where('user_id',$user->id)->where('device_id',$request->device_id)->delete();
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Device details delete successfully.';
            return response()->json($this->response, $this->status);
        }
        catch (\Exception $e)
        {
            $this->status = 401;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

}
