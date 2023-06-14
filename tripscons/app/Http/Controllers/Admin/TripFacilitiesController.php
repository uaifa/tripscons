<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TripFacility\BulkDestroyTripFacility;
use App\Http\Requests\Admin\TripFacility\DestroyTripFacility;
use App\Http\Requests\Admin\TripFacility\IndexTripFacility;
use App\Http\Requests\Admin\TripFacility\StoreTripFacility;
use App\Http\Requests\Admin\TripFacility\UpdateTripFacility;
use App\Models\TripFacility;
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

class TripFacilitiesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTripFacility $request
     * @return array|Factory|View
     */
    public function index(IndexTripFacility $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TripFacility::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'title', 'image', 'trip_id', 'is_included'],

            // set columns to searchIn
            ['id', 'title', 'description', 'image']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.trip-facility.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.trip-facility.create');

        return view('admin.trip-facility.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTripFacility $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTripFacility $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TripFacility
        $tripFacility = TripFacility::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/trip-facilities'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/trip-facilities');
    }

    /**
     * Display the specified resource.
     *
     * @param TripFacility $tripFacility
     * @throws AuthorizationException
     * @return void
     */
    public function show(TripFacility $tripFacility)
    {
        $this->authorize('admin.trip-facility.show', $tripFacility);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TripFacility $tripFacility
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TripFacility $tripFacility)
    {
        $this->authorize('admin.trip-facility.edit', $tripFacility);


        return view('admin.trip-facility.edit', [
            'tripFacility' => $tripFacility,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTripFacility $request
     * @param TripFacility $tripFacility
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTripFacility $request, TripFacility $tripFacility)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TripFacility
        $tripFacility->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/trip-facilities'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/trip-facilities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTripFacility $request
     * @param TripFacility $tripFacility
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTripFacility $request, TripFacility $tripFacility)
    {
        $tripFacility->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTripFacility $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTripFacility $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    TripFacility::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
