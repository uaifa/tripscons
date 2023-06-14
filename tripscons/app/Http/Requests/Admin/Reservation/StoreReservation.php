<?php

namespace App\Http\Requests\Admin\Reservation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreReservation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.reservation.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'reference_no' => ['nullable', 'string'],
            'bookable' => ['nullable', 'string'],
            'bookable_id' => ['nullable', 'string'],
            'room_id' => ['nullable', 'string'],
            'provider_user_id' => ['nullable', 'integer'],
            'user_id' => ['nullable', 'string'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
            'booking_detail' => ['nullable', 'string'],
            'subtotal' => ['nullable', 'integer'],
            'discounttotal' => ['nullable', 'integer'],
            'grandtotal' => ['nullable', 'integer'],
            'minimum_payable_amount' => ['nullable', 'integer'],
            'status' => ['nullable', 'string'],
            'reservation_type' => ['required', 'string'],
            'remaining_amount' => ['nullable', 'integer'],
            
        ];
    }

    /**
    * Modify input data
    *
    * @return array
    */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
