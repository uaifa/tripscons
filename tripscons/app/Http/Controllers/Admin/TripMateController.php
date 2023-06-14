<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TripMate\BulkDestroyTripMate;
use App\Http\Requests\Admin\TripMate\DestroyTripMate;
use App\Http\Requests\Admin\TripMate\IndexTripMate;
use App\Http\Requests\Admin\TripMate\StoreTripMate;
use App\Http\Requests\Admin\TripMate\UpdateTripMate;
use App\Models\TripMate;
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

class TripMateController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTripMate $request
     * @return array|Factory|View
     */
    public function index(IndexTripMate $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TripMate::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'user_id', 'trip_id', 'image_ids', 'lat', 'lng', 'city', 'country', 'date_from', 'date_to'],

            // set columns to searchIn
            ['id', 'user_id', 'image_ids', 'pick_up', 'destination', 'lat', 'lng', 'city', 'country', 'date_from', 'date_to', 'activities', 'description']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.trip-mate.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.trip-mate.create');

        return view('admin.trip-mate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTripMate $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTripMate $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TripMate
        $tripMate = TripMate::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/trip-mates'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/trip-mates');
    }

    /**
     * Display the specified resource.
     *
     * @param TripMate $tripMate
     * @throws AuthorizationException
     * @return void
     */
    public function show(TripMate $tripMate)
    {
        $this->authorize('admin.trip-mate.show', $tripMate);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TripMate $tripMate
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TripMate $tripMate)
    {
        $this->authorize('admin.trip-mate.edit', $tripMate);


        return view('admin.trip-mate.edit', [
            'tripMate' => $tripMate,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTripMate $request
     * @param TripMate $tripMate
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTripMate $request, TripMate $tripMate)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TripMate
        $tripMate->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/trip-mates'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/trip-mates');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTripMate $request
     * @param TripMate $tripMate
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTripMate $request, TripMate $tripMate)
    {
        $tripMate->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTripMate $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTripMate $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('tripMates')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
