<?php
namespace App\Libs\Booking\Interfaces;

interface Bookable {
    public function getAvailability() : bool;
    public function book();
    public function results() : array;
    public function getCart() : array;
    public function setCart();
    public function getService($id);
}