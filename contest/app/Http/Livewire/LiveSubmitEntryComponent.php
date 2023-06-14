<?php

namespace App\Http\Livewire;

use App\Lib\IntractionTrait;
use App\Models\Entry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Image;

class LiveSubmitEntryComponent extends Component
{
    use WithFileUploads, IntractionTrait;

    public $contest;
    public $title;
    public $description;
    public $photo;
    public $acceptTerms;
    public $user;
    public $phone;
    public $isUploading = false;
    public $location;

    public function mount($contest)
    {
        $this->contest = $contest;
        if(Auth::check()){
            $this->user = Auth::user();
            $this->phone = $this->user->phone;
        }
    }

    protected $rules = [
        'title' => 'required|min:10|max:50',
        'acceptTerms' => 'accepted',
        'description' => 'max:200',
        'photo' => 'required|mimes:png,jpg,jpeg,gif',
        'phone' => 'required|min:11|numeric',
        'location' => 'required',
    ];

    protected $messages = [
        'title.required' => 'Please enter photo title/caption',
        'title.min' => 'Your title must be atleast 10 characters long',
        'title.max' => 'Your title must be lesser 200 characters long',
        'acceptTerms.*' => 'You must accept contest rules to take part in contest'
    ];

    public function submitEntry()
    {
        $myEntry = Entry::where('user_id', \Auth::id())->where('contest_id', $this->contest)->get()->count();
        
        if($myEntry != 0){
            $this->alert('Sorry', 'You can submit one image per contest', 'error');
            return;
        }
        
        $this->validate();
        $imageName = $this->photo->store('media');
        $entry = Entry::forceCreate([
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => Auth::id(),
            'contest_id' => $this->contest,
            'media_path' => $imageName,
            'phone' => $this->phone,
            'location' => $this->location,
        ]);

        if($this->user->phone == '' || $this->user->phone == null){
            $this->user->phone = $this->phone;
            $this->user->update();
        }


        $image = Storage::disk('media')->get(str_replace('media/', '', $imageName));
        $image = Image::make($image)->resize(400, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');
        Storage::put('media/thumb_'.str_replace('media/', '', $imageName), $image);

        $this->alert('Thank you!', 'You have successfully participated in the contest', 'success');

        return redirect(url('/view/' . $entry->id . '/' . str_replace(' ', '-', $entry->title)));

    }

    public function render()
    {
        return view('livewire.live-submit-entry-component');
    }
}
