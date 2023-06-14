<?php
  
namespace App\Traits;
  
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
trait HostServiceBookingTrait {
  
    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function caluclateDaysorNights($start_date,$end_date){
        $start = new DateTime($start_date);
        $end =   new DateTime($end_date);
       // return  $start->diff($end)->d + 1;
       $days = floor(($end->format('U') - $start->format('U')) / (60*60*24));
       //return  $days + 1;
       return  $days ;
      
    }
    public function caluclateTime($start_date,$end_date){
        $startTime = Carbon::parse($start_date);
        $endTime = Carbon::parse($end_date);
        
        $totalDuration = $endTime->diff($startTime);
        if($totalDuration->h > 0 && $totalDuration->i >= 0){
           return  str_pad($totalDuration->h, 2, '0', STR_PAD_LEFT).':'.str_pad($totalDuration->i, 2, '0', STR_PAD_LEFT);
        }
        else{
            return 1;
        }
       
    }
    public function vehiclePriceCalculate($transport, $nights, $booking_type,$pick_up,$drop_off,$in_city_or_not){

        $pick_up  = json_decode($pick_up);
        $drop_off = json_decode($drop_off);
        $distance  =   (int)$this->location_distance($pick_up->pick_up_latitude, $pick_up->pick_up_longitude,$drop_off->drop_off_latitude,$drop_off->drop_off_longitude); 
        
        if($booking_type == 'Per Day'){
            
            if($in_city_or_not == true){
               
                if($distance <= $transport->intercity_per_day_milage){
                    
                    $price = $transport->intercity_per_day_price;
                    $total =  $price ;
                    $discount = 0; //may be implement later
                    $grand_total = $total-$discount;
                    $price_detail = array(
                        'nights'=>$nights,
                        'distance'=>$distance,
                        'price'=>number_format((float)$transport->intercity_per_day_price, 2, '.', ''),
                        'milage_allow'=>0,
                        'per_milage_price'=>0,  
                        'extra_milage'=>0, 
                        'extra_milage_price'=>0, 
                        'sub_total'=>number_format((float)$price, 2, '.', ''),
                        'total'=>number_format((float)$total, 2, '.', ''),
                        'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
                    );
                }else{    
                    
                    $distance_difference = $distance -  $transport->intercity_per_day_milage;
                    $per_milage_price  = $transport->intercity_per_day_extra_milage / $transport->intercity_per_day_extra_milage_price;
                    $extra_milage_price =  $distance_difference * $per_milage_price;
                    $price = ($extra_milage_price + $transport->intercity_per_day_price);
                    
                    $total =  $price ;
                    $discount = 0; //may be implement later
                    $grand_total = $total-$discount;
                    $price_detail = array(
                        'nights'=>$nights,
                        'distance'=>$distance,
                        'price'=>number_format((float)$transport->intercity_per_day_price, 2, '.', ''),
                        'milage_allow'=>$transport->intercity_per_day_milage,  
                       
                        'per_milage_price'=>number_format((float)$per_milage_price, 2, '.', ''),  
                        'extra_milage'=>$distance_difference, 
                        'extra_milage_price'=>number_format((float)$extra_milage_price, 2, '.', ''), 
                        'sub_total'=>number_format((float)$price, 2, '.', ''),
                        'total'=>number_format((float)$total, 2, '.', ''),
                        'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
                    );
                }    
           }else{
                if($distance <= $transport->outofcity_per_day_milage){
                $price = $transport->outofcity_per_day_price ;
                $total =  $price ;
                $discount = 0; //may be implement later
                $grand_total = $total-$discount;
                $price_detail = array(
                    'nights'=>$nights,
                    'distance'=>$distance,
                    'price'=>number_format((float)$transport->outofcity_per_day_price, 2, '.', ''),
                    'milage_allow'=>0,
                    'per_milage_price'=>0,  
                    'extra_milage'=>0, 
                    'extra_milage_price'=>0, 
                    'sub_total'=>number_format((float)$price, 2, '.', ''),
                    'total'=>number_format((float)$total, 2, '.', ''),
                    'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
                );
                }else{    
                $distance_difference = $distance -  $transport->outofcity_per_day_milage;
                $per_milage_price  = $transport->outofcity_per_day_extra_milage / $transport->outofcity_per_day_extra_milage_price;
                $extra_milage_price =  $distance_difference * $per_milage_price;
                $price = ($extra_milage_price + $transport->outofcity_per_day_price);
                $total =  $price ;
                    $discount = 0; //may be implement later
                    $grand_total = $total-$discount;
                    $price_detail = array(
                        'nights'=>$nights,
                        'distance'=>$distance,
                        'price'=>number_format((float)$transport->outofcity_per_day_extra_milage_price, 2, '.', ''),
                        'milage_allow'=>$transport->outofcity_per_day_milage,  
                        'per_milage_price'=>number_format((float)$per_milage_price, 2, '.', ''),  
                        'extra_milage'=>$distance_difference, 
                        'extra_milage_price'=>number_format((float)$extra_milage_price, 2, '.', ''), 
                        'sub_total'=>number_format((float)$price, 2, '.', ''),
                        'total'=>number_format((float)$total, 2, '.', ''),
                        'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
                    );
            } 
           }
        
        //$nights now basically complete time so please calclate properly here 
        //if false means incity

        }
        else if($booking_type == 'Multiple Day')
        {
            if($in_city_or_not == true){
                
                if($distance <= $transport->intercity_multiple_day_milage){
                    $price = $transport->intercity_multiple_day_price * $nights;
                    $total =  $price ;
                    $discount = 0; //may be implement later
                    $grand_total = $total-$discount;
                    $price_detail = array(
                        'nights'=>$nights,
                        'distance'=>$distance,
                        'price'=>number_format((float)$transport->intercity_multiple_day_price, 2, '.', ''),
                        'milage_allow'=>0,
                        'per_milage_price'=>0,  
                        'extra_milage'=>0, 
                        'extra_milage_price'=>0, 
                        'sub_total'=>number_format((float)$price, 2, '.', ''),
                        'total'=>number_format((float)$total, 2, '.', ''),
                        'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
                    );
                }else{    
                    $distance_difference = $distance -  $transport->intercity_multiple_day_milage;
                    $per_milage_price  = $transport->intercity_multiple_day_extra_milage / $transport->intercity_multiple_day_extra_milage_price;
                    $extra_milage_price =  $distance_difference * $per_milage_price;
                    $price = ($transport->intercity_multiple_day_price * $nights) + $extra_milage_price ;   

                    $total =  $price ;
                    $discount = 0; //may be implement later
                    $grand_total = $total-$discount;
                    $price_detail = array(
                        'nights'=>$nights,
                        'distance'=>$distance,
                        'price'=>number_format((float)$transport->intercity_multiple_day_price, 2, '.', ''),
                        'milage_allow'=>$transport->intercity_multiple_day_milage,  
                       
                        'per_milage_price'=>number_format((float)$per_milage_price, 2, '.', ''),  
                        'extra_milage'=>$distance_difference, 
                        'extra_milage_price'=>number_format((float)$extra_milage_price, 2, '.', ''), 
                        'sub_total'=>number_format((float)$price, 2, '.', ''),
                        'total'=>number_format((float)$total, 2, '.', ''),
                        'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
                    );
                }    
           }else{
            if($distance <= $transport->outofcity_multiple_day_milage){
                $price = $transport->outofcity_multiple_day_price * $nights;
                $total =  $price ;
                $discount = 0; //may be implement later
                $grand_total = $total-$discount;
                $price_detail = array(
                    'nights'=>$nights,
                    'distance'=>$distance,
                    'price'=>number_format((float)$transport->outofcity_multiple_day_price, 2, '.', ''),
                    'milage_allow'=>0,
                    'per_milage_price'=>0,  
                    'extra_milage'=>0, 
                    'extra_milage_price'=>0, 
                    'sub_total'=>number_format((float)$price, 2, '.', ''),
                    'total'=>number_format((float)$total, 2, '.', ''),
                    'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
                );
            }else{    
                $distance_difference = $distance -  $transport->outofcity_multiple_day_milage;
                $per_milage_price  = $transport->outofcity_multiple_day_extra_milage / $transport->outofcity_multiple_day_extra_milage_price;
                $extra_milage_price =  $distance_difference * $per_milage_price;
                $price = ($transport->outofcity_multiple_day_price * $nights) + $extra_milage_price;

                $total =  $price ;
                $discount = 0; //may be implement later
                $grand_total = $total-$discount;

                $price_detail = array(
                    'nights'=>$nights,
                    'distance'=>$distance,
                    'price'=>number_format((float)$transport->outofcity_multiple_day_price, 2, '.', ''),
                    'milage_allow'=>$transport->outofcity_multiple_day_milage,  'per_milage_price'=>number_format((float)$per_milage_price, 2, '.', ''),  
                    'extra_milage'=>$distance_difference, 
                    'extra_milage_price'=>number_format((float)$extra_milage_price, 2, '.', ''), 
                    'sub_total'=>number_format((float)$price, 2, '.', ''),
                    'total'=>number_format((float)$total, 2, '.', ''),
                    'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
                );
            }  
           }

        }else{
        
        //$nights now basically complete time so please calclate properly here 
        $timeExplode = explode(':',$nights);
        $totalMinutes = ($timeExplode[0] * 60) + $timeExplode[1];
        $perMinutePrice = $transport->hourly_price/60;
        $price = $totalMinutes * $perMinutePrice ;//$transport->per_day_price * $nights;   
       
        
        $total =  $price ;
        $discount = 0; //may be implement later
        $grand_total = $total-$discount;
       
            $price_detail = array(
                'Hours'=>$nights,
                'distance'=>$distance,
                'hourly_price'=>number_format((float)$transport->hourly_price, 2, '.', ''),
                'sub_total'=>number_format((float)$price, 2, '.', ''),
                
                'total'=>number_format((float)$total, 2, '.', ''),
                'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
            ); 
        }
            return $price_detail;
        
    }
    public function roomPriceCaluclate($request, $nights,$room,$room_price){
       
        $no_of_rooms = $request->qty;
        $per_head =   $room_price ;
        $total_room_price = $no_of_rooms * $per_head;
        $price = $total_room_price * $nights;
        
        $total =  $price ;
        $discount = 0;
        $grand_total = $total-$discount;
        if(isset($request->no_of_extra_guest)){    
            $extra_guest_price = $room->extra_guest_price * $request->no_of_extra_guest; 
            $grand_total = ($total + ($extra_guest_price * $nights)) - $discount;
            $price_detail = array(
                'room_id' =>$room->id,
                'room_type'=>$room->room_type,
                'per_room'=>$per_head,
                'no_of_rooms'=>$no_of_rooms,
                'no_of_nights'=>$nights,
                'no_of_extra_guest' =>$request->no_of_extra_guest,
                'one_day_extra_guest_price'=>number_format((float)$extra_guest_price, 2, '.', ''),
                'one_day_rooms_price'=>number_format((float)$total_room_price, 2, '.', ''),
                'sub_total'=>number_format((float)$grand_total, 2, '.', ''),
                
            );
            return $price_detail;
         }

        $price_detail = array(
            'room_id' =>$room->id,
            'room_type'=>$room->room_type,
            'per_room'=>$per_head,
            'no_of_rooms'=>$no_of_rooms,
            'no_of_nights'=>$nights,
            'no_of_extra_guest' =>$request->no_of_extra_guest,
            'one_day_rooms_price'=>number_format((float)$total_room_price, 2, '.', ''),
            'sub_total'=>number_format((float)$grand_total, 2, '.', ''),
           
        );
        return $price_detail;
    }
    public function caluclateRoomPrice($room,$roomObj,$nights,$room_price){

    if(isset($roomObj->no_of_extra_guest) && $roomObj->no_of_extra_guest > 0){

        $extra_guest_price = $roomObj->no_of_extra_guest *  $room->extra_guest_price; 
        $total_room_price = $roomObj->no_of_rooms   * $room_price ;
        $subtotal= $total_room_price * $nights;
        return $subtotal + ($extra_guest_price * $nights);
    } 
        $total_room_price = $roomObj->no_of_rooms   * $room_price ;
        return $total_room_price * $nights;
       
    }
    
    public function priceCalculate($accommodation, $nights, $breakfast_included, $lunch_included, $dinner_included,$totalroomsPrice,$per_night,$no_of_childs){
        
        $accommodation->payment_partial_value;
        $price = $per_night*$nights;
        $cleaning_fee = $accommodation->cleaning_fee;
        $service_fee = $accommodation->service_fee;
        //if breakfast price add
        $breakfast_price = 0;
        $breakfast_description ='';
        if($accommodation->isProvideBreakfast == "true"){

            if($accommodation->breakfast_included == 'No' && $breakfast_included=='true'){
                $breakfast_price = $accommodation->breakfast_price ;
                $breakfast_description = $accommodation->breakfast_description;
            }
        }
        
        //if breakfast price add
        $lunch_price = 0;
        $lunch_description ='';
        //echo $lunch_included; exit;
        if($accommodation->isProvideLunch == "true"){
        if($accommodation->lunch_included == 'No' && $lunch_included=='true'){
            $lunch_price = $accommodation->lunch_price;
            $lunch_description = $accommodation->lunch_description;
        }
    }
        //if breakfast price add
        $dinner_price = 0;
        $dinner_description ='';
        if($accommodation->isProvideDinner == "true"){
        if($accommodation->dinner_included == 'No' && $dinner_included=='true'){
            $dinner_price = $accommodation->dinner_price ;
            $dinner_description = $accommodation->dinner_description;
        }
    }
        $total =  $price + $cleaning_fee + $service_fee + $breakfast_price + $lunch_price + $dinner_price;
        if($accommodation->type_id == 2){
            $price = $totalroomsPrice;
            $total = $totalroomsPrice +  $cleaning_fee + $service_fee + $breakfast_price + $lunch_price + $dinner_price; 
        }
        $discount = 0;
        $child_discount = 0;
        $discount_in_percentage = 0;
        //for one week discount
        if($nights >= 7 && $nights <=13){
            $discount = $total*$accommodation->discount_for_one_week/100 ;
            $discount_in_percentage = $accommodation->discount_for_one_week;
        }
        //for two week discount
        if($nights >= 14 && $nights <=30){
            $discount = $total*$accommodation->discount_for_two_week/100 ;
            $discount_in_percentage = $accommodation->discount_for_two_week;
        }
        //for one month discount
        if($nights >= 30){
            $discount = $total*$accommodation->discount_for_monthly/100 ;
            $discount_in_percentage = $accommodation->discount_for_monthly;
        }
       if(isset($no_of_childs) && $accommodation->child_discount > 0 ){
       $child_discount =  ($accommodation->child_discount/100 * $total) * $no_of_childs;
       }
        $grand_total = $total-($discount +  $child_discount );
        
        if($accommodation->payment_partial_value >0){

            $partial_amount  = ($accommodation->payment_partial_value/100) *  $grand_total;
            $remaining_amt = $grand_total  - $partial_amount ;
         }else{
            $partial_amount = '0.00' ;
            $remaining_amt = '0.00';
         }
         if($accommodation->type_id == 2){
            $price_detail = array(
                'nights'=>$nights,
                
                'sub_total'=>number_format((float)$price, 2, '.', ''),
                'cleaning_fee'=>number_format((float)$cleaning_fee, 2, '.', ''),
                'service_fee'=>number_format((float)$service_fee, 2, '.', ''),
                'isProvideBreakfast'=>$accommodation->isProvideBreakfast,
                'breakfast_included'=>$accommodation->breakfast_included,
                
                'breakfast_price'=>number_format((float)$breakfast_price, 2, '.', ''),
                'breakfast_description'=>$breakfast_description,
                'isProvideLunch'=>$accommodation->isProvideLunch,
                'lunch_included'=>$accommodation->lunch_included,
                'lunch_price'=>number_format((float)$lunch_price, 2, '.', ''),
                'lunch_description'=>$lunch_description,
                'isProvideDinner'=>$accommodation->isProvideDinner,
                'dinner_included'=>$accommodation->dinner_included,
                
                'dinner_price'=>number_format((float)$dinner_price, 2, '.', ''),
                'dinner_description'=>$dinner_description,
                'total'=>number_format((float)$total, 2, '.', ''),
                'discount'=>number_format((float)$discount, 2, '.', ''),
                'discount_percentage'=>$discount_in_percentage,
                'child_discount'=>number_format((float)$child_discount, 2, '.', ''),
                'child_discount_percentage'=>$accommodation->child_discount,
               
                'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
                'partial_amount'=>number_format((float)$partial_amount, 2, '.', ''),
                'remaining_amount'=>number_format((float)$remaining_amt, 2, '.', ''),
                'partial_amount_percentage'=>$accommodation->payment_partial_value,
    
            );
            return $price_detail;
        }
        $price_detail = array( 
            'nights'=>$nights,
            'per_night'=>$per_night, 
            'sub_total'=>number_format((float)$price, 2, '.', ''),
            'cleaning_fee'=>number_format((float)$cleaning_fee, 2, '.', ''),
            'service_fee'=>number_format((float)$service_fee, 2, '.', ''),
            'isProvideBreakfast'=>$accommodation->isProvideBreakfast,
            'breakfast_included'=>$accommodation->breakfast_included,
            'breakfast_price'=>number_format((float)$breakfast_price, 2, '.', ''),
            'breakfast_description'=>$breakfast_description,
            'isProvideLunch'=>$accommodation->isProvideLunch,
            'lunch_included'=>$accommodation->lunch_included,
            'lunch_price'=>number_format((float)$lunch_price, 2, '.', ''),
            'lunch_description'=>$lunch_description,
            'isProvideDinner'=>$accommodation->isProvideDinner,
            'dinner_included'=>$accommodation->dinner_included,
            'dinner_price'=>number_format((float)$dinner_price, 2, '.', ''),
            'dinner_description'=>$dinner_description,
            'total'=>number_format((float)$total, 2, '.', ''),
            'discount'=>number_format((float)$discount, 2, '.', ''),
            'discount_percentage'=>$discount_in_percentage,
            
            'child_discount'=>number_format((float)$child_discount, 2, '.', ''),
            'child_discount_percentage'=>$accommodation->child_discount,
               
            'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
            'partial_amount'=>number_format((float)$partial_amount, 2, '.', ''),
            'remaining_amount'=>number_format((float)$remaining_amt, 2, '.', ''),
            'partial_amount_percentage'=>$accommodation->payment_partial_value,
            
        );
                
        return $price_detail;
    }
    
    public function mealPriceCalculate($meal,$qty){
   
        $price = $meal->price * $qty;
        $perItem =   $meal->price ;
        $subtotal=  $price ;
        $delivery_charges = $meal->delivery_charges;
        $total = $price + $delivery_charges ;
        $discount = $total*$meal->discount/100 ;
      
      
        $grand_total = $total -$discount;
        $price_detail = array(
            'qty'=>$qty,
            'per_item'=>number_format((float)$meal->price, 2, '.', ''),
            'delivery_charges'=>number_format((float)$delivery_charges, 2, '.', ''),
            'sub_total'=>number_format((float)$subtotal, 2, '.', ''),
            'total'=>number_format((float)$total, 2, '.', ''),
            'discount'=>number_format((float)$discount, 2, '.', ''),
            'discount_percentage'=>$meal->discount,   
            'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
        );
        return $price_detail;
    }
    public function slotPriceCalculate($slot,$no_of_guest){
       
        $price = $slot->price * $no_of_guest;
        $per_head =   $slot->price ;
        $total =  $price ;
        $discount = 0;
        $grand_total = $total-$discount;
        $price_detail = array(
            'no_of_guest'=>$no_of_guest,
            'per_head'=>number_format((float)$slot->price, 2, '.', ''),
            'sub_total'=>number_format((float)$price, 2, '.', ''),
            'total'=>number_format((float)$total, 2, '.', ''),
            'discount'=>number_format((float)$discount, 2, '.', ''),
            'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
        );
        return $price_detail;
    }
    public function servicePrice($service_provider_rate,$nights,$booking_type){
        if($booking_type == 'Per Day'){
            $price = $service_provider_rate->price_per_day_rate * $nights;
            }else{
                
                $timeExplode = explode(':',$nights);
                $totalMinutes = 0;

                if(isset($timeExplode[0])){
                    $totalMinutes = ($timeExplode[0] * 60);
                }
                if(isset($timeExplode[1])){
                    $totalMinutes = $totalMinutes + $timeExplode[1];
                }
                
                $perMinutePrice = $service_provider_rate->price_per_hour_rate/60;
                $price = $totalMinutes * $perMinutePrice ;
   }
            
            $total =  $price ;
         
            $grand_total = $total;
          
            if($booking_type == 'Per Day'){
                $price_detail = array(
                    'nights'=>$nights,
                    'per_day_price'=>number_format((float)$service_provider_rate->price_per_day_rate, 2, '.', ''),
                    'sub_total'=>number_format((float)$price, 2, '.', ''),
                    'total'=>number_format((float)$total, 2, '.', ''),
                    'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
                );
            }else{
                $price_detail = array(
                    'Hours'=>$nights,
                    'hourly_price'=>number_format((float)$service_provider_rate->price_per_hour_rate, 2, '.', ''),
                    'sub_total'=>number_format((float)$price, 2, '.', ''),
                    'total'=>number_format((float)$total, 2, '.', ''),
                    'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
                ); 
            }
            
            return $price_detail;
    }
    public function packagePrice($guide,$booing_type,$travellers){
        
        if($booing_type == 'Package'){
            $price = $guide->price;
            $subtotal = $price;
            $total =  $price ;
            $discount = 0;
            $grand_total = $total-$discount;
        if($guide->user_module_type == 'trip_operators'){
            $subtotal = $price * $travellers;
            $total =  $subtotal ;
            $discount = 0;
            $grand_total = $total-$discount;
        }   
        
        
        }
        
        $price_detail = array(
            
            'price'=>number_format((float)$price, 2, '.', ''),
            'sub_total'=>number_format((float)$subtotal, 2, '.', ''),
            'total'=>number_format((float)$total, 2, '.', ''),
            'discount'=>number_format((float)$discount, 2, '.', ''),
            'grand_total'=>number_format((float)$grand_total, 2, '.', ''),
        );
        return $price_detail;
    }
   public function location_distance($lat1, $lon1, $lat2, $lon2, $unit='K') 
    { 
        $theta = $lon1 - $lon2; 
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
        $dist = acos($dist); 
        $dist = rad2deg($dist); 
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") 
        {
            return ($miles * 1.609344); 
        } 
        else if ($unit == "N") 
        {
        return ($miles * 0.8684);
        } 
        else 
        {
        return $miles;
      }
    } 

}