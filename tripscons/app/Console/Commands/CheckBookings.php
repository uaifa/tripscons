<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Illuminate\Support\Facades\Config;
use App\Mail\CheckBookingMail;


class CheckBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkbooking:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("Cron is working fine!");
        return 0;
    }

    public function checkBooking(){

        $ldate = date('Y-m-d');
        $reservations = Reservation::where('is_send_email', 0)->whereDate('date_to', '<',$ldate)->take(2)->get();
        $vendors = [];
        $users = [];
        
        foreach ($reservations as $key => $value) {
            
            $vendors = [];
            $users = [];

            $booking_link = '';
            if(isset($value) && !empty($value->provider) && isset($value->provider->user_module_type) && !empty($value->provider->user_module_type) && in_array($value->provider->user_module_type,['guides','movie_makers','trips','visa_consultants','photographers','trip_mates','trip_operators','travel_agency','user_profile'])){

                $booking_link = Config::get('global.website_base_url').'/service/bookings';
            }else{
                $booking_link = Config::get('global.website_base_url').'/host/bookings';
            }

            array_push($vendors, ['reservation_id' => $value->id,'email' => $value->provider->email, 'name' => $value->provider->name, 'phone' => $value->provider->phone, 'booking_link' => $booking_link]);

            $u_booking_link = Config::get('global.website_base_url').'/user/bookings';

            array_push($users, ['reservation_id' => $value->id,'email' => $value->user->email, 'name' => $value->user->name, 'phone' => $value->user->phone, 'booking_link' => $u_booking_link]);
            
            if($vendors || $users){
                if(isset($vendors[0]) && !empty($vendors[0])){
                    $vendors = collect($vendors[0]);    
                }
                if(isset($users[0]) && !empty($users[0])){
                    $users = collect($users[0]);  
                }
                if(!empty($vendors) || !empty($users)){
                    \Mail::to($vendors['email'])->send(new CheckBookingMail($vendors));
                    \Mail::to($users['email'])->send(new CheckBookingMail($users));
                    $reservation = Reservation::find($value->id);
                    $reservation->is_send_email = 1;
                    $reservation->save();
                }
            }
        }
        return response()->json(['guides' => $vendors, 'user' => $users]);
    }
}
