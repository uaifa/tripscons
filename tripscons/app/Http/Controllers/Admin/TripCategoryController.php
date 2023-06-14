<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TripCategory\BulkDestroyTripCategory;
use App\Http\Requests\Admin\TripCategory\DestroyTripCategory;
use App\Http\Requests\Admin\TripCategory\IndexTripCategory;
use App\Http\Requests\Admin\TripCategory\StoreTripCategory;
use App\Http\Requests\Admin\TripCategory\UpdateTripCategory;
use App\Models\TripCategory;
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

class TripCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTripCategory $request
     * @return array|Factory|View
     */
    public function index(IndexTripCategory $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TripCategory::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            [''],

            // set columns to searchIn
            ['']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.trip-category.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.trip-category.create');

        return view('admin.trip-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTripCategory $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTripCategory $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TripCategory
        $tripCategory = TripCategory::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/trip-categories'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/trip-categories');
    }

    /**
     * Display the specified resource.
     *
     * @param TripCategory $tripCategory
     * @throws AuthorizationException
     * @return void
     */
    public function show(TripCategory $tripCategory)
    {
        $this->authorize('admin.trip-category.show', $tripCategory);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TripCategory $tripCategory
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TripCategory $tripCategory)
    {
        $this->authorize('admin.trip-category.edit', $tripCategory);


        return view('admin.trip-category.edit', [
            'tripCategory' => $tripCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTripCategory $request
     * @param TripCategory $tripCategory
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTripCategory $request, TripCategory $tripCategory)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TripCategory
        $tripCategory->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/trip-categories'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/trip-categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTripCategory $request
     * @param TripCategory $tripCategory
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTripCategory $request, TripCategory $tripCategory)
    {
        $tripCategory->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTripCategory $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTripCategory $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    TripCategory::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
