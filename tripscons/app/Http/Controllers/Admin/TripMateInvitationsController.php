<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TripMateInvitation\BulkDestroyTripMateInvitation;
use App\Http\Requests\Admin\TripMateInvitation\DestroyTripMateInvitation;
use App\Http\Requests\Admin\TripMateInvitation\IndexTripMateInvitation;
use App\Http\Requests\Admin\TripMateInvitation\StoreTripMateInvitation;
use App\Http\Requests\Admin\TripMateInvitation\UpdateTripMateInvitation;
use App\Models\TripMateInvitation;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TripMateInvitationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTripMateInvitation $request
     * @return array|Factory|View
     */
    public function index(IndexTripMateInvitation $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TripMateInvitation::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'trip_id', 'request_user_id', 'status'],

            // set columns to searchIn
            ['id', 'request_user_id', 'to_user_id', 'status']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.trip-mate-invitation.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.trip-mate-invitation.create');

        return view('admin.trip-mate-invitation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTripMateInvitation $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTripMateInvitation $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TripMateInvitation
        $tripMateInvitation = TripMateInvitation::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/trip-mate-invitations'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/trip-mate-invitations');
    }

    /**
     * Display the specified resource.
     *
     * @param TripMateInvitation $tripMateInvitation
     * @throws AuthorizationException
     * @return void
     */
    public function show(TripMateInvitation $tripMateInvitation)
    {
        $this->authorize('admin.trip-mate-invitation.show', $tripMateInvitation);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TripMateInvitation $tripMateInvitation
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TripMateInvitation $tripMateInvitation)
    {
        $this->authorize('admin.trip-mate-invitation.edit', $tripMateInvitation);


        return view('admin.trip-mate-invitation.edit', [
            'tripMateInvitation' => $tripMateInvitation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTripMateInvitation $request
     * @param TripMateInvitation $tripMateInvitation
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTripMateInvitation $request, TripMateInvitation $tripMateInvitation)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TripMateInvitation
        $tripMateInvitation->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/trip-mate-invitations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/trip-mate-invitations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTripMateInvitation $request
     * @param TripMateInvitation $tripMateInvitation
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTripMateInvitation $request, TripMateInvitation $tripMateInvitation)
    {
        $tripMateInvitation->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTripMateInvitation $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTripMateInvitation $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('tripMateInvitations')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
