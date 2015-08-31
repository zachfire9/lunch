@extends('layouts.master')
 
@section('title') Update Lunch @stop
 
@section('content')
 
<div class='col-lg-4 col-lg-offset-4'>
 
    @if ($errors->has())
        @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }}</div>
        @endforeach
    @endif
 
    <h1><i class='fa fa-user'></i> Lunch Results</h1>
 
    <h2>Deadline</h2>
    
    <h2>Restaurants</h2>

    @foreach ($restaurants as $restaurant)
        <div class='form-group'>
            {{ $restaurant->name }}
    @endforeach
    <br>
    <h2>Friends</h2>

    @foreach ($friends as $friend)
        <div class='form-group'>
            {{ $friend->first_name }} {{ $friend->last_name }}
        </div>
    @endforeach
 
</div>
 
@stop