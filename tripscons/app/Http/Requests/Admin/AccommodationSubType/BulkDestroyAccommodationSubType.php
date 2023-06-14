<?php

namespace App\Http\Requests\Admin\AccommodationSubType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class BulkDestroyAccommodationSubType extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.accommodation-sub-type.bulk-delete');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'ids.*' => 'integer'
        ];
    }
}
