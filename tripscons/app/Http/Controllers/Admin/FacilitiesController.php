<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Facility\BulkDestroyFacility;
use App\Http\Requests\Admin\Facility\DestroyFacility;
use App\Http\Requests\Admin\Facility\IndexFacility;
use App\Http\Requests\Admin\Facility\StoreFacility;
use App\Http\Requests\Admin\Facility\UpdateFacility;
use App\Models\Facility;
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

class FacilitiesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexFacility $request
     * @return array|Factory|View
     */
    public function index(IndexFacility $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Facility::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'module_type', 'status', 'image'],

            // set columns to searchIn
            ['id', 'name', 'module_type', 'status', 'image']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.facility.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.facility.create');

        return view('admin.facility.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFacility $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreFacility $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Facility
        $facility = Facility::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/facilities'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/facilities');
    }

    /**
     * Display the specified resource.
     *
     * @param Facility $facility
     * @throws AuthorizationException
     * @return void
     */
    public function show(Facility $facility)
    {
        $this->authorize('admin.facility.show', $facility);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Facility $facility
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Facility $facility)
    {
        $this->authorize('admin.facility.edit', $facility);


        return view('admin.facility.edit', [
            'facility' => $facility,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFacility $request
     * @param Facility $facility
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateFacility $request, Facility $facility)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Facility
        $facility->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/facilities'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/facilities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyFacility $request
     * @param Facility $facility
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyFacility $request, Facility $facility)
    {
        $facility->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyFacility $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyFacility $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Facility::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
