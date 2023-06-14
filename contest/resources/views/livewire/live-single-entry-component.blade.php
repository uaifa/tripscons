@section('header')
    <title>{{$entry->title}}</title>
    <meta property="og:title" content="Tripscon Photography Contest | {{$entry->title}}" />
    <meta property="og:description" content="Vote for me and help me win" />
    <meta property="og:image" content="{{route('stream', ['filePath' => str_replace('media/', '', $entry->media_path)])}}" />
@endsection
<div class="single-entry-detail">
    <div class="my-1">
        <div class="image-wrapper">
            <img src="{{route('stream', ['filePath' => str_replace('media/', '', $entry->media_path)])}}" alt="" srcset="">
        </div>
        <div class="content-detail">
            <h1 class="title">
                {{$entry->title}}
            </h1>
            <h3 class="author">
                <i class='fa fa-map-pin'></i> <span>{{$entry->location}}</span>
            </h3>
            <h3 class="author">
                Author: <span>{{$entry->user->name}}</span>
            </h3>
            <div class="icon-share my-4 icon-share-large">
                <ul>
                    <li>
                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{route('entry', ['entry' => $entry->id, 'title' => str_replace(' ', '-', $entry->title)])}}">

                            <img src="/facebook.png" alt="facebook" srcset="">
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="https://twitter.com/intent/tweet?url={{route('entry', ['entry' => $entry->id, 'title' => str_replace(' ', '-', $entry->title)])}}">

                            <img src="/twitter.png" alt="twitter" srcset="">
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="mailto:?subject=Vote for my photograph&body=Vote for my photograph and help me win - Vote Here: {{route('entry', ['entry' => $entry->id, 'title' => str_replace(' ', '-', $entry->title)])}}">

                            <img src="/google.png" alt="google" srcset="">
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="http://pinterest.com/pin/create/link/?image_url={{route('stream', ['filePath' => $entry->media_path])}}&url={{route('entry', ['entry' => $entry->id, 'title' => str_replace(' ', '-', $entry->title)])}}">

                            <img  src="/pinterest.png" alt="pinterest" srcset="">
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
            <div class="share-section">
                <div class="votes">
                    <i class="fa-regular fa-heart"></i> <span> {{$entry->votes}} Votes</span>

                </div>
                
            </div>
        </div>

    </div>
    @livewire('live-vote-confirmation-widget', ['entry' => $entry])

    @livewire('live-login-modal')
    <script>
    function detectTripsconApp() {
      // The URI scheme used by the Tripscon app
      var appScheme = "tripsconapp://contest/view/{{$entry->id}}";
    
      // Create an iframe with the Tripscon app URI scheme
      var iframe = document.createElement("iframe");
      iframe.style.display = "none";
      iframe.src = appScheme;
      document.body.appendChild(iframe);
    
      // Set a timeout to check if the app was opened
      var timeout = setTimeout(function() {
        // Timeout occurred, app is not installed
        clearTimeout(timeout);
        window.location.href = "{{$this->isMobile == 'apple' ? 'https://apps.apple.com/sa/app/tripscon/id1603074345?type=entry&deep_link_id=32' : 'https://play.google.com/store/apps/details?id=com.tripscon.app&type=entry&deep_link_id=3345'}}"; // Redirect to App Store
      }, 500);
    
      // Listen for the page visibility change event
      document.addEventListener("visibilitychange", function() {
        clearTimeout(timeout);
      });
    }
    @if($isMobile)
    detectTripsconApp();
    @endif
    </script>
</div>
