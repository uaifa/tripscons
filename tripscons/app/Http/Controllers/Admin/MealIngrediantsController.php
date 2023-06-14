<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MealIngrediant\BulkDestroyMealIngrediant;
use App\Http\Requests\Admin\MealIngrediant\DestroyMealIngrediant;
use App\Http\Requests\Admin\MealIngrediant\IndexMealIngrediant;
use App\Http\Requests\Admin\MealIngrediant\StoreMealIngrediant;
use App\Http\Requests\Admin\MealIngrediant\UpdateMealIngrediant;
use App\Models\MealIngrediant;
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

class MealIngrediantsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexMealIngrediant $request
     * @return array|Factory|View
     */
    public function index(IndexMealIngrediant $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(MealIngrediant::class)->processRequestAndGet(
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

        return view('admin.meal-ingrediant.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.meal-ingrediant.create');

        return view('admin.meal-ingrediant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMealIngrediant $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreMealIngrediant $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the MealIngrediant
        $mealIngrediant = MealIngrediant::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/meal-ingrediants'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/meal-ingrediants');
    }

    /**
     * Display the specified resource.
     *
     * @param MealIngrediant $mealIngrediant
     * @throws AuthorizationException
     * @return void
     */
    public function show(MealIngrediant $mealIngrediant)
    {
        $this->authorize('admin.meal-ingrediant.show', $mealIngrediant);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param MealIngrediant $mealIngrediant
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(MealIngrediant $mealIngrediant)
    {
        $this->authorize('admin.meal-ingrediant.edit', $mealIngrediant);


        return view('admin.meal-ingrediant.edit', [
            'mealIngrediant' => $mealIngrediant,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMealIngrediant $request
     * @param MealIngrediant $mealIngrediant
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateMealIngrediant $request, MealIngrediant $mealIngrediant)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values MealIngrediant
        $mealIngrediant->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/meal-ingrediants'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/meal-ingrediants');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyMealIngrediant $request
     * @param MealIngrediant $mealIngrediant
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyMealIngrediant $request, MealIngrediant $mealIngrediant)
    {
        $mealIngrediant->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyMealIngrediant $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyMealIngrediant $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    MealIngrediant::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
