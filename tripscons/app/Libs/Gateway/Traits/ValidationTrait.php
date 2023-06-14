<?php
namespace App\Libs\Gateway\Traits;

use Exception;
use PDO;

trait ValidationTrait {

    function validateBooking($booking){
        if($booking->status != 7) {
            throw new Exception("Booking not confirmed by vendor");
        }

        if($booking->remaining_amount <= 0) {
            throw new Exception("No pending payment against this booking");
        }

        if(!$booking) {
            throw new Exception("Invalid booking identifier");
        }
    }

}
