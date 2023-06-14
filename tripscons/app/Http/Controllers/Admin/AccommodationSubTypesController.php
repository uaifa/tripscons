<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AccommodationSubType\BulkDestroyAccommodationSubType;
use App\Http\Requests\Admin\AccommodationSubType\DestroyAccommodationSubType;
use App\Http\Requests\Admin\AccommodationSubType\IndexAccommodationSubType;
use App\Http\Requests\Admin\AccommodationSubType\StoreAccommodationSubType;
use App\Http\Requests\Admin\AccommodationSubType\UpdateAccommodationSubType;
use App\Models\AccommodationSubType;
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

class AccommodationSubTypesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexAccommodationSubType $request
     * @return array|Factory|View
     */
    public function index(IndexAccommodationSubType $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(AccommodationSubType::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'type_id', 'name'],

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

        return view('admin.accommodation-sub-type.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.accommodation-sub-type.create');

        return view('admin.accommodation-sub-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAccommodationSubType $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAccommodationSubType $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the AccommodationSubType
        $accommodationSubType = AccommodationSubType::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/accommodation-sub-types'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/accommodation-sub-types');
    }

    /**
     * Display the specified resource.
     *
     * @param AccommodationSubType $accommodationSubType
     * @throws AuthorizationException
     * @return void
     */
    public function show(AccommodationSubType $accommodationSubType)
    {
        $this->authorize('admin.accommodation-sub-type.show', $accommodationSubType);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AccommodationSubType $accommodationSubType
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(AccommodationSubType $accommodationSubType)
    {
        $this->authorize('admin.accommodation-sub-type.edit', $accommodationSubType);


        return view('admin.accommodation-sub-type.edit', [
            'accommodationSubType' => $accommodationSubType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAccommodationSubType $request
     * @param AccommodationSubType $accommodationSubType
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateAccommodationSubType $request, AccommodationSubType $accommodationSubType)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values AccommodationSubType
        $accommodationSubType->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/accommodation-sub-types'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/accommodation-sub-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAccommodationSubType $request
     * @param AccommodationSubType $accommodationSubType
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyAccommodationSubType $request, AccommodationSubType $accommodationSubType)
    {
        $accommodationSubType->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyAccommodationSubType $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyAccommodationSubType $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    AccommodationSubType::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
