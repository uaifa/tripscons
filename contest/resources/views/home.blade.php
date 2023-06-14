@extends('layouts.app')
@section('content')
<div class="vote-listing">
    <div class="container">
        <div class="row">
            @foreach ($contests as $contest)
                <div class="col-md-12">
                    <h2>{{$contest->title}}</h2>
                    <div wire:poll.750ms>
                        Current time: {{ now() }}
                    </div>
                </div>
                @foreach ($contest->entries()->popular()->get() as $entry)
                @livewire('live-entry-widget', ['entry' => $entry], key($entry->id))
                @endforeach
            @endforeach
        </div>
    </div>
</div>
@livewire('live-login-modal')

@endsection
