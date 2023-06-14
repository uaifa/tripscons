<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Reservation\BulkDestroyReservation;
use App\Http\Requests\Admin\Reservation\DestroyReservation;
use App\Http\Requests\Admin\Reservation\IndexReservation;
use App\Http\Requests\Admin\Reservation\StoreReservation;
use App\Http\Requests\Admin\Reservation\UpdateReservation;
use App\Models\Reservation;
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

class ReservationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexReservation $request
     * @return array|Factory|View
     */
    public function index(IndexReservation $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Reservation::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'reference_no', 'bookable', 'bookable_id', 'room_id', 'provider_user_id', 'user_id', 'date_from', 'date_to', 'subtotal', 'discounttotal', 'grandtotal', 'minimum_payable_amount', 'status', 'reservation_type', 'remaining_amount'],

            // set columns to searchIn
            ['id', 'reference_no', 'bookable', 'booking_detail', 'status', 'reservation_type']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.reservation.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.reservation.create');

        return view('admin.reservation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReservation $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreReservation $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Reservation
        $reservation = Reservation::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/reservations'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/reservations');
    }

    /**
     * Display the specified resource.
     *
     * @param Reservation $reservation
     * @throws AuthorizationException
     * @return void
     */
    public function show(Reservation $reservation)
    {
        $this->authorize('admin.reservation.show', $reservation);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reservation $reservation
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Reservation $reservation)
    {
        $this->authorize('admin.reservation.edit', $reservation);


        return view('admin.reservation.edit', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReservation $request
     * @param Reservation $reservation
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateReservation $request, Reservation $reservation)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Reservation
        $reservation->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/reservations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/reservations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyReservation $request
     * @param Reservation $reservation
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyReservation $request, Reservation $reservation)
    {
        $reservation->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyReservation $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyReservation $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Reservation::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
