<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MealType\BulkDestroyMealType;
use App\Http\Requests\Admin\MealType\DestroyMealType;
use App\Http\Requests\Admin\MealType\IndexMealType;
use App\Http\Requests\Admin\MealType\StoreMealType;
use App\Http\Requests\Admin\MealType\UpdateMealType;
use App\Models\MealType;
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

class MealTypesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexMealType $request
     * @return array|Factory|View
     */
    public function index(IndexMealType $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(MealType::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'status', 'active'],

            // set columns to searchIn
            ['id', 'name', 'status']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.meal-type.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.meal-type.create');

        return view('admin.meal-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMealType $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreMealType $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the MealType
        $mealType = MealType::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/meal-types'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/meal-types');
    }

    /**
     * Display the specified resource.
     *
     * @param MealType $mealType
     * @throws AuthorizationException
     * @return void
     */
    public function show(MealType $mealType)
    {
        $this->authorize('admin.meal-type.show', $mealType);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param MealType $mealType
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(MealType $mealType)
    {
        $this->authorize('admin.meal-type.edit', $mealType);


        return view('admin.meal-type.edit', [
            'mealType' => $mealType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMealType $request
     * @param MealType $mealType
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateMealType $request, MealType $mealType)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values MealType
        $mealType->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/meal-types'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/meal-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyMealType $request
     * @param MealType $mealType
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyMealType $request, MealType $mealType)
    {
        $mealType->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyMealType $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyMealType $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    MealType::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
