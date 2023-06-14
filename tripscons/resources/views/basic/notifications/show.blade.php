@extends('basic.layout.master')

@section('main')
    <div id="app">
        <show-notification
            :notification_detail="{{json_encode($notification)}}"
        ></show-notification>
    </div>
@endsection
