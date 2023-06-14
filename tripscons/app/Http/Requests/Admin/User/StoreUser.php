<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.user.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'type' => ['nullable', 'integer'],
            'email' => ['nullable', 'email', 'string'],
            'password' => ['nullable', 'confirmed', 'min:7', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/', 'string'],
            'phone' => ['nullable', 'string'],
            'pin_code' => ['nullable', 'string'],
            'country_code' => ['nullable', 'string'],
            'postal_code' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'service_provider_type' => ['nullable', 'string'],
            'gender' => ['nullable', 'string'],
            'country' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'currency' => ['nullable', 'string'],
            'lng' => ['nullable', 'numeric'],
            'lat' => ['nullable', 'numeric'],
            'social_platform' => ['nullable', 'string'],
            'social_platform_id' => ['nullable', 'string'],
            'device_type' => ['nullable', 'string'],
            'device_token' => ['nullable', 'string'],
            'about' => ['nullable', 'string'],
            'role_id' => ['nullable', 'integer'],
            'verified' => ['nullable', 'integer'],
            'date_of_birth' => ['nullable', 'date'],
            'is_mate' => ['nullable', 'boolean'],
            'is_host' => ['nullable', 'integer'],
            'is_traveler' => ['nullable', 'integer'],
            'api_token' => ['nullable', 'string'],
            'is_profile_complete' => ['nullable', 'boolean'],
            'role_profile_id' => ['nullable', 'integer'],
            'rating' => ['nullable', 'numeric'],
            'no_of_reviews' => ['nullable', 'integer'],
            'is_phone_verified' => ['nullable', 'integer'],
            'email_verified_at' => ['nullable', 'date'],
            'phone_verified_at' => ['nullable', 'date'],
            'languages' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'status' => ['nullable', 'integer'],
            'user_module_type' => ['nullable', 'string'],
            'stripe_id' => ['nullable', 'string'],
            'pm_type' => ['nullable', 'string'],
            'pm_last_four' => ['nullable', 'string'],
            'trial_ends_at' => ['nullable', 'date'],
            
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
