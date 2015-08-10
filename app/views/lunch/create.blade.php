@extends('layouts.master')
 
@section('title') Create Lunch @stop
 
@section('content')
 
<div class='col-lg-4 col-lg-offset-4'>
 
    @if ($errors->has())
        @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }}</div>
        @endforeach
    @endif
 
    <h1><i class='fa fa-user'></i> Create Lunch</h1>
 
    {{ Form::open(['role' => 'form', 'url' => '/lunch']) }}
 
    <div class='form-group'>
        {{ Form::label('deadline', 'Deadline') }}
        {{ Form::text('deadline', null, ['placeholder' => 'Deadline', 'class' => 'form-control']) }}
    </div>
 
    {{ Form::label('restaurants', 'Restaurants') }}

    @foreach ($restaurants as $restaurant)
        <div class='form-group'>
            {{ Form::checkbox('restaurant_' . $restaurant->id, $restaurant->id) }}
            {{ $restaurant->name }}
        </div>
    @endforeach

    {{ Form::label('friends', 'Friends') }}

    @foreach ($friends as $friend)
        <div class='form-group'>
            {{ Form::checkbox('friend_' . $friend->id, $friend->id) }}
            {{ $friend->first_name }} {{ $friend->last_name }}
        </div>
    @endforeach

    <div class='form-group'>
        {{ Form::submit('Create', ['class' => 'btn btn-primary']) }}
    </div>
 
    {{ Form::close() }}
 
</div>
 
@stop