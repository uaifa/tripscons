<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TripMateDestination\BulkDestroyTripMateDestination;
use App\Http\Requests\Admin\TripMateDestination\DestroyTripMateDestination;
use App\Http\Requests\Admin\TripMateDestination\IndexTripMateDestination;
use App\Http\Requests\Admin\TripMateDestination\StoreTripMateDestination;
use App\Http\Requests\Admin\TripMateDestination\UpdateTripMateDestination;
use App\Models\TripMateDestination;
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

class TripMateDestinationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTripMateDestination $request
     * @return array|Factory|View
     */
    public function index(IndexTripMateDestination $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TripMateDestination::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'trip_id', 'lat', 'lng', 'city', 'country', 'type'],

            // set columns to searchIn
            ['id', 'destination', 'lat', 'lng', 'city', 'country']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.trip-mate-destination.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.trip-mate-destination.create');

        return view('admin.trip-mate-destination.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTripMateDestination $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTripMateDestination $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TripMateDestination
        $tripMateDestination = TripMateDestination::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/trip-mate-destinations'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/trip-mate-destinations');
    }

    /**
     * Display the specified resource.
     *
     * @param TripMateDestination $tripMateDestination
     * @throws AuthorizationException
     * @return void
     */
    public function show(TripMateDestination $tripMateDestination)
    {
        $this->authorize('admin.trip-mate-destination.show', $tripMateDestination);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TripMateDestination $tripMateDestination
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TripMateDestination $tripMateDestination)
    {
        $this->authorize('admin.trip-mate-destination.edit', $tripMateDestination);


        return view('admin.trip-mate-destination.edit', [
            'tripMateDestination' => $tripMateDestination,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTripMateDestination $request
     * @param TripMateDestination $tripMateDestination
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTripMateDestination $request, TripMateDestination $tripMateDestination)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TripMateDestination
        $tripMateDestination->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/trip-mate-destinations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/trip-mate-destinations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTripMateDestination $request
     * @param TripMateDestination $tripMateDestination
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTripMateDestination $request, TripMateDestination $tripMateDestination)
    {
        $tripMateDestination->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTripMateDestination $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTripMateDestination $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('tripMateDestinations')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
