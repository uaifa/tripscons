<?php

namespace App\Http\Livewire;

use App\Models\Contest;
use Livewire\Component;

class LiveHomeComponent extends Component
{
    public $contests;
    public $filter;

    protected $listeners = [
        'filterResults'
    ];

    public function filterResults($value)
    {
        $this->filter = $value;
    }

    public function mount()
    {
        $this->contests = Contest::get();
    }

    public function render()
    {
        return view('livewire.live-home-component');
    }
}
