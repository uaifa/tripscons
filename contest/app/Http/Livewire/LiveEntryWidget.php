<?php

namespace App\Http\Livewire;

use App\Lib\IntractionTrait;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveEntryWidget extends Component
{
    use IntractionTrait;

    public $entry;

    // protected $listeners = ['votesUpdated'];

    public function viewImage()
    {
        $this->modalOpen('imgmodal' . $this->entry->id);
    }

    public function votesUpdated($vote)
    {
        // if($vote['id'] == $this->entry->id){
            return redirect(url('/'));
        // }
    }

    public function vote($id)
    {
        if(!Auth::check()){
            $this->modalOpen('signup');
            return;
        }

        $twentyFourHoursAgo = Carbon::now()->subDay();

        $lastVote = Vote::where('created_at', '>', $twentyFourHoursAgo)
        ->where('contest_id', $this->entry->contest_id)
        ->where('user_id', Auth::id())
        ->count();

        if(!$lastVote){
            $this->modalOpen('vote-confirmation' . $id);
            return;
        }

        $this->alert('Sorry!', 'You can only vote once in 24 hours', 'error');

    }

    public function render()
    {
        return view('livewire.live-entry-widget');
    }
}
