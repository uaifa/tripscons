<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class IndexUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.user.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'orderBy' => 'in:id,name,type,email,phone,pin_code,country_code,postal_code,address,service_provider_type,gender,country,state,city,currency,lng,lat,social_platform,social_platform_id,device_type,device_token,role_id,verified,date_of_birth,is_mate,is_host,is_traveler,is_profile_complete,role_profile_id,rating,no_of_reviews,is_phone_verified,email_verified_at,phone_verified_at,languages,image,status,stripe_id,pm_type,pm_last_four,trial_ends_at|nullable',
            'orderDirection' => 'in:asc,desc|nullable',
            'search' => 'string|nullable',
            'page' => 'integer|nullable',
            'per_page' => 'integer|nullable',

        ];
    }
}
