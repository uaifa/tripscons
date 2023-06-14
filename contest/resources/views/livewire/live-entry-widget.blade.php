<div class="col-12 col-md-6 col-lg-4 col-xl-3 vote__box">
    <div class="vote-box">
       
        <a href="{{url('/view/' . $entry->id . '/' . str_replace(' ', '-', $entry->title))}}">
            <div class="img-wrapper">
                <img src="{{route('stream', ['filePath' => 'thumb_' .str_replace('media/', '', $entry->media_path)])}}" alt="" />
            </div>
        </a>
        <div class="content-wrapper">
            <div class="icon-share">
                <ul>
                    <li>
                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{route('entry', ['entry' => $entry->id, 'title' => str_replace(' ', '-', $entry->title)])}}">
                           <img src="/facebook.png" alt="facebook">
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="https://twitter.com/intent/tweet?url={{route('entry', ['entry' => $entry->id, 'title' => str_replace(' ', '-', $entry->title)])}}">
                        <img src="/twitter.png" alt="twitter">
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="mailto:?subject=Vote for my photograph&body=Vote for my photograph and help me win - Vote Here: {{route('entry', ['entry' => $entry->id, 'title' => str_replace(' ', '-', $entry->title)])}}">
                        <img src="/google.png" alt="google">
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://pinterest.com/pin/create/link/?image_url={{route('stream', ['filePath' => $entry->media_path])}}&url={{route('entry', ['entry' => $entry->id, 'title' => str_replace(' ', '-', $entry->title)])}}">
                        <img src="/pinterest.png" alt="pinterest">
                        </a>
                    </li>
                    <li>
                        <span class="custom-url" title="Copy Link" onclick='copyLink("shareableLink" + {{$entry->id}})'>
                            <img class="upload" src="/copy.png" alt="copy">
                        </span>
                    </li>
                </ul>
            </div>
            <input type="text" style="display:none;" id="shareableLink{{$entry->id}}" value="{{route('entry', ['entry' => $entry->id, 'title' => str_replace(' ', '-', $entry->title)])}}">
            <div class="author-info">
                <h2 class="title">
                    {{$entry->title}}
                </h2>
                <h3 class="author">
                <i class='fa fa-map-pin'></i> <span>{{$entry->location}}</span>
            </h3>
                <h3 class="author">
                    Contestant: <span>{{$entry->user->name}}</span>
                </h3>

            </div>
            <div class="vote-buttons d-flex justify-content-center">
                <button class="custom-button w-100">
                    {{$entry->votes}} Votes
                </button>
                
            </div>
        </div>
    </div>
    @if($entry != null)
        @livewire('live-vote-confirmation-widget', ['entry' => $entry])
    @endif
</div>
