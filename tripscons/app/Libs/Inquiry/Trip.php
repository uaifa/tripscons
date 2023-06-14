<?php
namespace App\Libs\Inquiry;

use App\Libs\Inquiry\Inquiry as InquiryInquiry;
use App\Libs\Inquiry\Interfaces\Inquirable;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Validator;

class Trip extends InquiryInquiry implements Inquirable {

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
        if(!empty(auth()->user())){

            $validator = Validator::make(request()->all(), [
                'budget' => 'required|integer',
                'dateFrom' => 'required|date',
                'dateTo' => 'required|date',
                'description' => 'required',
                'location' => 'required',
                'no_of_people' => 'required',
                'phone' => 'required',
                
                // 'tripType' => 'required'
            ]);

        }else{

            $validator = Validator::make(request()->all(), [
                'budget' => 'required|integer',
                'dateFrom' => 'required|date',
                'dateTo' => 'required|date',
                'description' => 'required',
                'location' => 'required',
                'no_of_people' => 'required',
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                
                // 'tripType' => 'required'
            ]);

        }
        // $validator = Validator::make(request()->all(), [
        //     'budget' => 'required|integer',
        //     'dateFrom' => 'required|date',
        //     'dateTo' => 'required|date',
        //     'description' => 'required',
        //     'location' => 'required',
        //     'no_of_people' => 'required',
        //     'name' => 'required',
        //     'email' => 'required',
        //     'phone' => 'required',
            
        //     // 'tripType' => 'required'
        // ]);

        if ($validator->fails()) {
            return $validator->messages()->first();
        }

        return false;
    }

}
