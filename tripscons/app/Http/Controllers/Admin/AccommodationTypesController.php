<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AccommodationType\BulkDestroyAccommodationType;
use App\Http\Requests\Admin\AccommodationType\DestroyAccommodationType;
use App\Http\Requests\Admin\AccommodationType\IndexAccommodationType;
use App\Http\Requests\Admin\AccommodationType\StoreAccommodationType;
use App\Http\Requests\Admin\AccommodationType\UpdateAccommodationType;
use App\Models\AccommodationType;
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

class AccommodationTypesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexAccommodationType $request
     * @return array|Factory|View
     */
    public function index(IndexAccommodationType $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(AccommodationType::class)->processRequestAndGet(
            // pass the request with params
            $request,
            // set columns to query
            ['id', 'name'],
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

        return view('admin.accommodation-type.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.accommodation-type.create');

        return view('admin.accommodation-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAccommodationType $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAccommodationType $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the AccommodationType
        $accommodationType = AccommodationType::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/accommodation-types'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/accommodation-types');
    }

    /**
     * Display the specified resource.
     *
     * @param AccommodationType $accommodationType
     * @throws AuthorizationException
     * @return void
     */
    public function show(AccommodationType $accommodationType)
    {
        $this->authorize('admin.accommodation-type.show', $accommodationType);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AccommodationType $accommodationType
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(AccommodationType $accommodationType)
    {
        $this->authorize('admin.accommodation-type.edit', $accommodationType);
        return view('admin.accommodation-type.edit', [
            'accommodationType' => $accommodationType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAccommodationType $request
     * @param AccommodationType $accommodationType
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateAccommodationType $request, AccommodationType $accommodationType)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values AccommodationType
        $accommodationType->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/accommodation-types'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/accommodation-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAccommodationType $request
     * @param AccommodationType $accommodationType
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyAccommodationType $request, AccommodationType $accommodationType)
    {
        $accommodationType->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyAccommodationType $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyAccommodationType $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    AccommodationType::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
