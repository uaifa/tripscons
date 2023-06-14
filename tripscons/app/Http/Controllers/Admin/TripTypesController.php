<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TripType\BulkDestroyTripType;
use App\Http\Requests\Admin\TripType\DestroyTripType;
use App\Http\Requests\Admin\TripType\IndexTripType;
use App\Http\Requests\Admin\TripType\StoreTripType;
use App\Http\Requests\Admin\TripType\UpdateTripType;
use App\Models\TripType;
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

class TripTypesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTripType $request
     * @return array|Factory|View
     */
    public function index(IndexTripType $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TripType::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'category_id'],

            // set columns to searchIn
            ['id', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.trip-type.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.trip-type.create');

        return view('admin.trip-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTripType $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTripType $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TripType
        $tripType = TripType::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/trip-types'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/trip-types');
    }

    /**
     * Display the specified resource.
     *
     * @param TripType $tripType
     * @throws AuthorizationException
     * @return void
     */
    public function show(TripType $tripType)
    {
        $this->authorize('admin.trip-type.show', $tripType);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TripType $tripType
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TripType $tripType)
    {
        $this->authorize('admin.trip-type.edit', $tripType);


        return view('admin.trip-type.edit', [
            'tripType' => $tripType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTripType $request
     * @param TripType $tripType
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTripType $request, TripType $tripType)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TripType
        $tripType->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/trip-types'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/trip-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTripType $request
     * @param TripType $tripType
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTripType $request, TripType $tripType)
    {
        $tripType->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTripType $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTripType $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    TripType::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
