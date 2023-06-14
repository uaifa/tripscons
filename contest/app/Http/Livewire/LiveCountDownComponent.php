<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use DateTime;
use Livewire\Component;

class LiveCountDownComponent extends Component
{
    public $endTime;
    public $left;

    public function mount()
    {
        $this->endTime = Carbon::create($this->endTime);
    }

    public function getNowProperty()
    {
        return $now  = new DateTime();
    }

    public function getDaysProperty()
    {
        $now = $this->getNowProperty();
        $ends = new DateTime(date('M d, Y h:i:s', strtotime($this->endTime)));
        $left = $now->diff($ends);

        return $left->format('%a');
    }

    public function getHoursProperty()
    {
        $now = $this->getNowProperty();
        $ends = new DateTime(date('M d, Y h:i:s', strtotime($this->endTime)));
        $left = $now->diff($ends);

        return $left->format('%h');
    }

    public function getMinuitesProperty()
    {
        $now = $this->getNowProperty();
        $ends = new DateTime(date('M d, Y h:i:s', strtotime($this->endTime)));
        $left = $now->diff($ends);

        return $left->format('%i');
    }

    public function getSecondsProperty()
    {
        $now = $this->getNowProperty();
        $ends = new DateTime(date('M d, Y h:i:s', strtotime($this->endTime)));
        $left = $now->diff($ends);

        return $left->format('%s');
    }

    public function render()
    {
        return view('livewire.live-count-down-component');
    }
}
