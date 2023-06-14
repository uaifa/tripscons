<?php
namespace App\Libs\Inquiry;

class Inquiry {
    public $location;
    public $date_from;
    public $date_to;
    public $persons;
    public $user_id;
    public $type;
    public $trip_type;
    public $budget;
    public $notes;
    public $vehicle_category;
    public $vehicle_type;
    public $with_driver;
    public $name;
    public $email;
    public $phone;
    
    public function mapRequest()
    {
       
        $this->location = request()->location;
        $this->date_from = request()->dateFrom;
        $this->date_to = request()->dateTo;
        $this->persons = request()->no_of_people;
        $this->user_id = request()->user()->id;
        $this->trip_type = request()->tripType;
        $this->budget = request()->budget;
        $this->notes = request()->description;
        $this->vehicle_category = request()->vehicleCategory;
        $this->vehicle_type = request()->vehicleType;
        $this->with_driver = request()->withDriver;
        $this->name = request()->name;
        $this->email = request()->email;
        $this->phone = request()->phone;
    }
}
