@section('header')
    <title>Submit Entry | Tripscon Contests</title>
    <meta property="og:title" content="Tripscon Contests | Win big" />
    <meta property="og:description" content="Capture life's beautiful moments and win big!" />
    <meta property="og:image" content="/banner.png" />
@endsection
<div>
    @if (\Auth::check())
        @php
            $myEntry = \App\Models\Entry::where('user_id', \Auth::id())->where('contest_id', $contest)->first();
        @endphp
        @if(\App\Models\Entry::where('user_id', \Auth::id())->where('contest_id', $contest)->get()->count())
        <div class="single-entry-wrapper login-wrapper ">
            <div class="mt-1">
                <h3 class="single-title text-center">
                    Sorry
                </h3>
                <div class=" my-4" style="max-width:450px;margin:auto">
                    Your have already submitted image for this contest. To view your image <a href="{{url('/view/' . $myEntry->id . '/' . str_replace(' ', '-', $myEntry->title))}}"><button class="custom-button" style="display: inline;">click here</button></a>
                </div>
            </div>
        </div>
        @else
        <div class="single-entry-wrapper ">
            <div class="mt-1">

                <h3 class="single-title">
                    <i class="fa-solid fa-upload"></i> Upload a photo to the contest
                </h3>
                <div class="autor-details">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <input readonly type="text" value="{{\Auth::user()->name}}" id="author"
                                    class="form-control">
                                <label for="author">Full Name</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <input wire:model='phone' type="text" id="email" class="form-control">
                                <label for="email">Phone <span class="text-danger">*</span></label>
                                @error('phone')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <input wire:model='title' type="text" id="title" class="form-control">
                                <label for="title">Caption <span class="text-danger">*</span></label>
                                @error('title')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <input wire:model='location' type="text" id="location" class="form-control">
                                <label for="title">Photo location where it was captured <span class="text-danger">*</span></label>
                                @error('location')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">

                                <button class="custom-button"><i class="fa-solid fa-camera"></i>Upload photo
                                    <input type="file" wire:model='photo'></button>

                                <div class="mt-2" x-show="isUploading">
                                    <progress max="100" x-bind:value="progress"></progress>
                                </div>
                            </div>

                        </div>

                        @error('photo')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        @if ($photo)
                        <div class="col-12 mt-4">
                            <div class="upload-img">
                                <img src="{{ $photo->temporaryUrl() }}">
                            </div>
                        </div>
                        @endif
                        <div class="col-12 mt-4">
                            <div class="form-group checkbox-group">
                                <input wire:model='acceptTerms' type="checkbox" id="rules">
                                <label for="rules">I agree with <a href="/rules">contest rules</a></label>
                                @error('acceptTerms')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                                </button>
                            </div>
                        </div>
                        <div class="col-12 align-right">
                            <button wire:loading.attr='disabled' class="custom-button" wire:click='submitEntry'>Submit <i
                                    class="fa fa-spinner fa-spin" wire:loading></i></button>
                        </div>
                    </div>



                </div>
            </div>
        </div>
        @endif
    @else
    <div class="single-entry-wrapper login-wrapper ">
        <div class="mt-1">
            <h3 class="single-title text-center">
                <i class="fa-solid fa-lock"></i> Login to submit your entry
            </h3>
            <div class="d-flex justify-content-around my-4" style="max-width:450px;margin:auto">
                <a href="{{ url('auth/facebook') }}" style="width: 100% !imp">
                    
                        <img src="/facebook.png" width="40px"  alt="facebook">
                       
                </a>
                <a href="{{ url('auth/google') }}" style="width: 100% !imp">
                    
                        <img src="/google.png" width="40px" alt="google">
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
