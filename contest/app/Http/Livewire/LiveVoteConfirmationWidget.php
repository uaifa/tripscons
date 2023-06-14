<?php

namespace App\Http\Livewire;

use App\Lib\IntractionTrait;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveVoteConfirmationWidget extends Component
{
    use IntractionTrait;

    public $entry;

    public function vote()
    {
        $twentyFourHoursAgo = Carbon::now()->subDay();

        $lastVote = Vote::where('created_at', '>', $twentyFourHoursAgo)
        ->where('contest_id', $this->entry->contest_id)
        ->where('user_id', Auth::id())
        ->count();

        if($lastVote){
            $this->alert('Sorry!', 'You can only vote once in 24 hours', 'error');
            return;
        }

        $this->entry->votes += 1;
        $this->entry->update();

        Vote::forceCreate([
            'entry_id' => $this->entry->id,
            'contest_id' => $this->entry->contest_id,
            'user_id' => Auth::id()
        ]);

        $this->emit('votesUpdated', [
            'id' => $this->entry->id,
            'votes' => $this->entry->votes
        ]);

        $this->modalClose('vote-confirmation' . $this->entry->id);
        $this->alert('Thank you for voting!', 'Your vote is counted and you can vote again after 24 hours.', 'success');

        // if (!request()->is('/')){
        //     return redirect('/');
        // }
    }

    public function close()
    {
        $this->modalClose('vote-confirmation' . $this->entry->id);
    }

    public function render()
    {
        return view('livewire.live-vote-confirmation-widget');
    }
}
