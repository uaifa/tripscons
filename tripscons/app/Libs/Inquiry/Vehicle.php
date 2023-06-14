<?php
namespace App\Libs\Inquiry;

use App\Libs\Inquiry\Inquiry as InquiryInquiry;
use App\Libs\Inquiry\Interfaces\Inquirable;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Validator;

class Vehicle extends InquiryInquiry implements Inquirable {

    public function __construct()
    {
        $this->type = self::class;
        $this->mapRequest();
    }

    public function toArray() : array
    {
        return (array) $this;
    }

    public function create() : array
    {
        return (array) Inquiry::forceCreate($this->toArray());
    }

    public function validate()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'budget' => 'required|integer',
            'dateFrom' => 'required|date',
            'dateTo' => 'required|date',
            'description' => 'required',
            'location' => 'required',
            'no_of_people' => 'required',
            'tripType' => 'required',
            'vehicleCategory' => 'required',
            'vehicleType' => 'required',
            'withDriver' => 'required|in:Yes,No',
        ]);

        if ($validator->fails()) {
            return $validator->messages()->first();
        }

        return false;
    }

}
