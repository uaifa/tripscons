<?php

namespace App\Http\Livewire;

use App\Lib\IntractionTrait;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveImageModalWidget extends Component
{
    use IntractionTrait;

    public $entry;

    public function vote()
    {
        if(!Auth::check()){
            $this->modalOpen('signup');
        }

        $twentyFourHoursAgo = Carbon::now()->subDay();

        $lastVote = Vote::where('created_at', '>', $twentyFourHoursAgo)
        ->where('contest_id', $this->entry->contest_id)
        ->count();

        if(!$lastVote){
            $this->modalClose('imgmodal'.$this->entry->id);
            $this->modalOpen('vote-confirmation' . $this->entry->id);
            return;
        }

        $this->modalClose('imgmodal'.$this->entry->id);
        $this->alert('Sorry!', 'You can only vote once in 24 hours', 'error');
    }

    public function render()
    {
        return view('livewire.live-image-modal-widget');
    }
}
