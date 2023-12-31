<?php

namespace App\Http\Controllers\Admin;

use App\Events\Counters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notification\BulkDestroyNotification;
use App\Http\Requests\Admin\Notification\DestroyNotification;
use App\Http\Requests\Admin\Notification\IndexNotification;
use App\Http\Requests\Admin\Notification\StoreNotification;
use App\Http\Requests\Admin\Notification\UpdateNotification;
use App\Models\DeviceBadge;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Participant;
use App\Models\TripMateInvitation;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class NotificationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexNotification $request
     * @return array|Factory|View
     */
    public function index(IndexNotification $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Notification::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'user_id', 'seen', 'status', 'type', 'ref_id', 'user_role'],

            // set columns to searchIn
            ['id', 'message', 'uri', 'type']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.notification.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.notification.create');

        return view('admin.notification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreNotification $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreNotification $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Notification
        $notification = Notification::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/notifications'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/notifications');
    }

    /**
     * Display the specified resource.
     *
     * @param Notification $notification
     * @throws AuthorizationException
     * @return void
     */
    public function show(Notification $notification)
    {
        $this->authorize('admin.notification.show', $notification);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Notification $notification
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Notification $notification)
    {
        $this->authorize('admin.notification.edit', $notification);


        return view('admin.notification.edit', [
            'notification' => $notification,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateNotification $request
     * @param Notification $notification
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateNotification $request, Notification $notification)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Notification
        $notification->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/notifications'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/notifications');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyNotification $request
     * @param Notification $notification
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyNotification $request, Notification $notification)
    {
        $notification->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyNotification $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyNotification $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Notification::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }


    public function notificationCounter(Request $request)
    {
        $user_id = $request->user()->id;
        $msgCount = 0;
        $notifications = 0;
        try {
            $notifications = DeviceBadge::select('count')->where('user_id', $user_id)
                ->where('type', '!=', 'CHAT_MESSAGE')
                ->sum('count');
            $deviceBadges = DeviceBadge::where('user_id',$user_id)
                ->where('type','CHAT_MESSAGE')
                ->first();
            if ($deviceBadges){
                $msgCount  = $deviceBadges->count;
            }
            $counts = [
                'notifications'         => $notifications,
//                'msgs'                 => $messages,
                'chats'                 => $msgCount,
            ];
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Notifications Count';
            $this->response['data'] = $counts;
            return response()->json($this->response, $this->status);
        }
        catch (\Exception $e)
        {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = $e->getMessage();
            return response()->json($this->response, $this->status);
        }
    }

    public function notificationClear(Request $request, $type)
    {
        $user_id = $request->user()->id;
        try {

            if ($type == 'CHAT'){
                $messages = Message::whereHas('participants',function ($query) use ($user_id){
                    $query->where('user_id',$user_id);
                })
                    ->where('seen', 0)
                    ->update(['seen' => 1]);
                $deviceBadges = DeviceBadge::where('user_id',$user_id)
                    ->where('type','CHAT_MESSAGE')
                    ->update(['count'=>0]);
//                $participant = Participant::where('user_id',$user_id)
//                    ->where('seen',0)
//                    ->update(['seen' => 1]);
            }
            if ($type == 'NOTIFICATION'){
                $notifications = Notification::where('receiver_id',$user_id)
                    ->where('seen',0)
                    ->update(['seen' => 1]);
                $deviceNotifications = DeviceBadge::where('user_id', $user_id)
                    ->where('type', '!=', 'CHAT_MESSAGE')
                    ->update(['count'=> 0]);

            }
            if ($type == 'TRIP_MATE_INVITAION'){
                $tripMateInvitation = TripMateInvitation::whereHas('trip_mate',function ($query) use ($user_id){
                    $query->where('user_id',$user_id);
                });
//                ->update(['seen' => 1]);
            }
            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Seen All ' . $type;
            return response()->json($this->response, $this->status);
        }
        catch (\Exception $e)
        {
            $this->status = 422;
            $this->response['success'] = true;
            $this->response['message'] = 'Something went wrong please try again.';
            return response()->json($this->response, $this->status);
        }
    }

    public function notificationList(Request $request)
    {
        $user_id = $request->user()->id;
        try {
            $notifications = Notification::with('sender')->where('receiver_id',$user_id)
                ->orderBy('id','DESC')
                ->paginate(Config::get('global.pagination_records'));

            $this->status = 200;
            $this->response['success'] = true;
            $this->response['message'] = 'Notifications List';
            $this->response['data'] = $notifications;
            return response()->json($this->response, $this->status);
        }
        catch (\Exception $e)
        {
            $this->status = 422;
            $this->response['success'] = true;
            $this->response['message'] = 'Something went wrong please try again.';
            return response()->json($this->response, $this->status);
        }
    }

}
