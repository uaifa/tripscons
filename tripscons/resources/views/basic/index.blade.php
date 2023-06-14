@extends('basic.layout.master')
@section('main')
    <div id="app">
        <topmenu></topmenu>
        <loginpop></loginpop>
        <signup></signup> 
        <router-view></router-view>
    </div>
@endsection
