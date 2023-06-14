<?php

namespace App\Http\Livewire;

use App\Lib\IntractionTrait;
use App\Models\Entry;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveSingleEntryComponent extends Component
{
    use IntractionTrait;

    protected $listeners = ['votesUpdated'];

    public $entry;
    public $title;
    public $isMobile = false;
    public function vote($id)
    {
        if (!Auth::check()) {
            $this->modalOpen('signup');
            return;
        }

        $twentyFourHoursAgo = Carbon::now()->subDay();

        $lastVote = Vote::where('created_at', '>', $twentyFourHoursAgo)
            ->where('contest_id', $this->entry->contest_id)
            ->where('user_id', Auth::id())
            ->count();

        if (!$lastVote) {
            $this->modalOpen('vote-confirmation' . $this->entry->id);
            return;
        }

        $this->alert('Sorry!', 'You can only vote once in 24 hours', 'error');
    }

    public function votesUpdated($vote)
    {
        if ($vote['id'] == $this->entry->id) {
            $this->entry->votes = $vote['votes'];
        }
    }

    private function checkAgent()
    {
        $aMobileUA = array(
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        //Return true if Mobile User Agent is detected
        foreach ($aMobileUA as $sMobileKey => $sMobileOS) {
            if (preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])) {
                return true;
            }
        }
        //Otherwise return false..
        return false;
    }

    public function mount($entry)
    {
        $this->entry = Entry::findOrFail($this->entry);
        if ($this->checkAgent()) {
            if (preg_match("/(iphone)/i", $_SERVER["HTTP_USER_AGENT"]) || preg_match("/(iPad)/i", $_SERVER["HTTP_USER_AGENT"])) {
                $this->isMobile = 'apple';
            } else {
                $this->isMobile = 'android';
            }
        }
        if (str_replace(' ', '-', $this->entry->title) != $this->title) {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.live-single-entry-component');
    }
}
