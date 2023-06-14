@section('header')
    <title>Tripscon Contests | Win big</title>
    <meta property="og:title" content="Tripscon Contests | Win big" />
    <meta property="og:description" content="Capture life's beautiful moments and win big!" />
    <meta property="og:image" content="/banner.png" />
@endsection

<div class="vote-listing">
    <div class="container">
        <div class="row">
            @foreach ($contests as $contest)
                <div class="col-md-12">

                    @livewire('live-count-down-component', [
                        'endTime' => $contest->end_time
                    ])
                    <!-- <h2 class='main-title'>{{$contest->title}}</h2> -->
                    <!-- <div class="small-banner" style="font-size: 14px;">
                        Don't forget to vote your photo daily after 24 hours. Contest voting will continue till April 20,2023.
Fake votes entry will be disqualified from contest immediately. 
                    </div> -->
                </div>
               

                @php
                    $entries = $contest->entries();
                    if($filter == 'most-voted' || $filter == null){
                        $entries = $entries->popular();
                    }

                    if($filter == 'most-recent'){
                        $entries = $entries->recent();
                    }

                    if($filter == 'oldest'){
                        $entries = $entries->oldest();
                    }
                    $entries = $entries->get();
                @endphp

                @foreach ($entries as $key => $entry)
                @livewire('live-entry-widget', ['entry' => $entry])
                @endforeach
            @endforeach
        </div>
    </div>
</div>
@livewire('live-login-modal')
