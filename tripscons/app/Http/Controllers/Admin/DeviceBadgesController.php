<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeviceBadge\BulkDestroyDeviceBadge;
use App\Http\Requests\Admin\DeviceBadge\DestroyDeviceBadge;
use App\Http\Requests\Admin\DeviceBadge\IndexDeviceBadge;
use App\Http\Requests\Admin\DeviceBadge\StoreDeviceBadge;
use App\Http\Requests\Admin\DeviceBadge\UpdateDeviceBadge;
use App\Models\DeviceBadge;
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

class DeviceBadgesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexDeviceBadge $request
     * @return array|Factory|View
     */
    public function index(IndexDeviceBadge $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(DeviceBadge::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'user_id', 'type', 'count', 'status'],

            // set columns to searchIn
            ['id', 'type', 'status']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.device-badge.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.device-badge.create');

        return view('admin.device-badge.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDeviceBadge $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreDeviceBadge $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the DeviceBadge
        $deviceBadge = DeviceBadge::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/device-badges'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/device-badges');
    }

    /**
     * Display the specified resource.
     *
     * @param DeviceBadge $deviceBadge
     * @throws AuthorizationException
     * @return void
     */
    public function show(DeviceBadge $deviceBadge)
    {
        $this->authorize('admin.device-badge.show', $deviceBadge);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DeviceBadge $deviceBadge
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(DeviceBadge $deviceBadge)
    {
        $this->authorize('admin.device-badge.edit', $deviceBadge);


        return view('admin.device-badge.edit', [
            'deviceBadge' => $deviceBadge,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDeviceBadge $request
     * @param DeviceBadge $deviceBadge
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateDeviceBadge $request, DeviceBadge $deviceBadge)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values DeviceBadge
        $deviceBadge->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/device-badges'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/device-badges');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyDeviceBadge $request
     * @param DeviceBadge $deviceBadge
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyDeviceBadge $request, DeviceBadge $deviceBadge)
    {
        $deviceBadge->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyDeviceBadge $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyDeviceBadge $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DeviceBadge::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function deviceBadgesUpdate(Request $request){
        $user = $request->user();
        $user_id =$request->user_id;
        $device_badges = DeviceBadge::where('user_id',$user_id)->get();

        $types = json_decode($request->types);

        try {
            foreach ($device_badges as $device_badge){
                foreach ($types as $type) {
                    if ($device_badge == $type->name) {
                        $device_badge->count = $type->count;
                    }
                }
                $device_badge->update();
            }
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Device badge updated successfully.';
            $this->response['data'] = $device_badges;
            return response()->json($this->response, $this->status);
        }
        catch (Exception $e){
            $this->status = 200;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function deviceBadgesCreate(Request $request){
        $user = $request->user();
        $user_id =$request->user_id;
        $device_badges = DeviceBadge::where('user_id',$user_id)->first();
        $types = [
            'CHAT_MESSAGE',
            'TRIPMATE_REQUEST',
            'BOOKING',
            'USER_REGISTER',
            'USER_BLOCKED',
            'BOOKING',
            'BOOKING_CONFIRM',
            'BOOKING_CANCEL',
            'BOOKING_ACCEPT',
            'PROFILE',
            'ACCOMMODATION',
            'VEHICLE',
            'VISA',
            'MEDIA',
            'TRIP_OPERATOR',
            'PACKAGE',
            'COMPANY',
            'TEAM',
            'PLACE',
            'TRIP_MATE',
            'TRIP_MATE_INVITATION',
            'TRIP_MATE_INVITATION_ACCEPT',
            'TRIP_MATE_INVITATION_REJECT',
            'TRIP',
            'ACTIVITY',
            'EXPERTISE',
            'RESTAURANT',
            'GUIDE',
            'SERVICE_PROVIDER',
            'RATING_REVIEW',
            'VENDOR_RATING_REVIEW',
            'MEAL',
            'EXPERIENCE',
            'VERIFIED',
            'DOCUMENT',
        ];
        try {
            if (empty($device_badges))
            {
                foreach ($types as $key => $type) {
                    $device_badges = new DeviceBadge();
                    $device_badges->user_id = $user_id;
                    $device_badges->type = $type;
                    $device_badges->status = 'CREATE';
                    $device_badges->count = 0;
                    $device_badges->save();
                }
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Device Badges Created Successfully.';
                $this->response['data'] = $device_badges;
                return response()->json($this->response, $this->status);
            }
            else
            {
                $this->status = 200;
                $this->response['success'] = true;
                $this->response['message'] = 'Device Badges Already Existed.';
                return response()->json($this->response, $this->status);

            }
        }
        catch (Exception $e) {
            $this->status = 200;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function deviceBadgesList(Request $request){
        $user = $request->user();
        try {
            $device_badges = DeviceBadge::select('type','count')->where('user_id',$user->id)->get();
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Device Badges List.';
            $this->response['data'] = $device_badges;
            return response()->json($this->response, $this->status);
        }
        catch (Exception $e) {
            $this->status = 200;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function deviceBadgesReset(Request $request){
        $user = $request->user();
        $type =$request->type;
        $count =$request->count;
        try {
            $device_badge = DeviceBadge::where('user_id',$user->id)->where('type',$type)->first();
            if ($device_badge){
                $device_badge->count = $count;
                $device_badge->status = 'RESET';
                $device_badge->update();
            }

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Device Badges Updated Successfully.';
            $this->response['data'] = $device_badge;
            return response()->json($this->response, $this->status);
        }
        catch (Exception $e){
            $this->status = 200;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

}
