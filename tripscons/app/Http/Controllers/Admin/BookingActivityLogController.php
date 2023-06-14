<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookingActivityLog\BulkDestroyBookingActivityLog;
use App\Http\Requests\Admin\BookingActivityLog\DestroyBookingActivityLog;
use App\Http\Requests\Admin\BookingActivityLog\IndexBookingActivityLog;
use App\Http\Requests\Admin\BookingActivityLog\StoreBookingActivityLog;
use App\Http\Requests\Admin\BookingActivityLog\UpdateBookingActivityLog;
use App\Models\BookingActivityLog;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookingActivityLogController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexBookingActivityLog $request
     * @return array|Factory|View
     */
    public function index(IndexBookingActivityLog $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(BookingActivityLog::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'booking_id', 'admin_user_id', 'status'],

            // set columns to searchIn
            ['id', 'comments']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.booking-activity-log.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.booking-activity-log.create');

        return view('admin.booking-activity-log.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBookingActivityLog $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreBookingActivityLog $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the BookingActivityLog
        $bookingActivityLog = BookingActivityLog::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/booking-activity-logs'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/booking-activity-logs');
    }

    /**
     * Display the specified resource.
     *
     * @param BookingActivityLog $bookingActivityLog
     * @throws AuthorizationException
     * @return void
     */
    public function show(BookingActivityLog $bookingActivityLog)
    {
        $this->authorize('admin.booking-activity-log.show', $bookingActivityLog);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BookingActivityLog $bookingActivityLog
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(BookingActivityLog $bookingActivityLog)
    {
        $this->authorize('admin.booking-activity-log.edit', $bookingActivityLog);


        return view('admin.booking-activity-log.edit', [
            'bookingActivityLog' => $bookingActivityLog,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBookingActivityLog $request
     * @param BookingActivityLog $bookingActivityLog
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateBookingActivityLog $request, BookingActivityLog $bookingActivityLog)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values BookingActivityLog
        $bookingActivityLog->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/booking-activity-logs'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/booking-activity-logs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyBookingActivityLog $request
     * @param BookingActivityLog $bookingActivityLog
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyBookingActivityLog $request, BookingActivityLog $bookingActivityLog)
    {
        $bookingActivityLog->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyBookingActivityLog $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyBookingActivityLog $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    BookingActivityLog::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
