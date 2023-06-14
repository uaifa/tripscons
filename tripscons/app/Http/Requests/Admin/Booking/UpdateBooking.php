<?php

namespace App\Http\Requests\Admin\Booking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateBooking extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.booking.edit', $this->booking);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'integer'],
            'provider_id' => ['nullable', 'integer'],
            'module_name' => ['nullable', 'string'],
            'module_id' => ['nullable', 'integer'],
            'price' => ['nullable', 'integer'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'no_of_nights' => ['nullable', 'string'],
            'total' => ['nullable', 'numeric'],
            'discount' => ['nullable', 'numeric'],
            'grand_total' => ['nullable', 'numeric'],
            'status' => ['nullable', 'integer'],
            'payment_status' => ['sometimes', 'integer'],
            'sub_total' => ['sometimes', 'integer'],
            'booking_number' => ['sometimes', 'string'],
            'partial_amt' => ['nullable', 'numeric'],
            'partial_amt_in_percentage' => ['nullable', 'integer'],
            'provider_name' => ['nullable', 'string'],
            'booking_type' => ['nullable', 'string'],
            'bookable' => ['nullable', 'string'],
            
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
