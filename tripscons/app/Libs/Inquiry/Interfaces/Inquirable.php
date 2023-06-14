<?php
namespace App\Libs\Inquiry\Interfaces;

interface Inquirable {
    public function toArray() : array;
    public function create() : array;
    public function validate();
}
