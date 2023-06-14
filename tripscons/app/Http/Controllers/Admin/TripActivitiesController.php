<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TripActivity\BulkDestroyTripActivity;
use App\Http\Requests\Admin\TripActivity\DestroyTripActivity;
use App\Http\Requests\Admin\TripActivity\IndexTripActivity;
use App\Http\Requests\Admin\TripActivity\StoreTripActivity;
use App\Http\Requests\Admin\TripActivity\UpdateTripActivity;
use App\Models\TripActivity;
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

class TripActivitiesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTripActivity $request
     * @return array|Factory|View
     */
    public function index(IndexTripActivity $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TripActivity::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'image', 'trip_id'],

            // set columns to searchIn
            ['id', 'name', 'image']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.trip-activity.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.trip-activity.create');

        return view('admin.trip-activity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTripActivity $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTripActivity $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TripActivity
        $tripActivity = TripActivity::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/trip-activities'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/trip-activities');
    }

    /**
     * Display the specified resource.
     *
     * @param TripActivity $tripActivity
     * @throws AuthorizationException
     * @return void
     */
    public function show(TripActivity $tripActivity)
    {
        $this->authorize('admin.trip-activity.show', $tripActivity);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TripActivity $tripActivity
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TripActivity $tripActivity)
    {
        $this->authorize('admin.trip-activity.edit', $tripActivity);


        return view('admin.trip-activity.edit', [
            'tripActivity' => $tripActivity,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTripActivity $request
     * @param TripActivity $tripActivity
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTripActivity $request, TripActivity $tripActivity)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TripActivity
        $tripActivity->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/trip-activities'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/trip-activities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTripActivity $request
     * @param TripActivity $tripActivity
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTripActivity $request, TripActivity $tripActivity)
    {
        $tripActivity->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTripActivity $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTripActivity $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    TripActivity::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
