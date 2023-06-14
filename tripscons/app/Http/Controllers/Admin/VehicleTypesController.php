<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VehicleType\BulkDestroyVehicleType;
use App\Http\Requests\Admin\VehicleType\DestroyVehicleType;
use App\Http\Requests\Admin\VehicleType\IndexVehicleType;
use App\Http\Requests\Admin\VehicleType\StoreVehicleType;
use App\Http\Requests\Admin\VehicleType\UpdateVehicleType;
use App\Models\VehicleType;
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

class VehicleTypesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexVehicleType $request
     * @return array|Factory|View
     */
    public function index(IndexVehicleType $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(VehicleType::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'type'],

            // set columns to searchIn
            ['id', 'name', 'type']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.vehicle-type.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.vehicle-type.create');

        return view('admin.vehicle-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVehicleType $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreVehicleType $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the VehicleType
        $vehicleType = VehicleType::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/vehicle-types'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/vehicle-types');
    }

    /**
     * Display the specified resource.
     *
     * @param VehicleType $vehicleType
     * @throws AuthorizationException
     * @return void
     */
    public function show(VehicleType $vehicleType)
    {
        $this->authorize('admin.vehicle-type.show', $vehicleType);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param VehicleType $vehicleType
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(VehicleType $vehicleType)
    {
        $this->authorize('admin.vehicle-type.edit', $vehicleType);


        return view('admin.vehicle-type.edit', [
            'vehicleType' => $vehicleType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVehicleType $request
     * @param VehicleType $vehicleType
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateVehicleType $request, VehicleType $vehicleType)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values VehicleType
        $vehicleType->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vehicle-types'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/vehicle-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyVehicleType $request
     * @param VehicleType $vehicleType
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyVehicleType $request, VehicleType $vehicleType)
    {
        $vehicleType->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyVehicleType $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyVehicleType $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    VehicleType::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
