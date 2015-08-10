@extends('layouts.master')
 
@section('title') Update Lunch @stop
 
@section('content')
 
<div class='col-lg-4 col-lg-offset-4'>
 
    @if ($errors->has())
        @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }}</div>
        @endforeach
    @endif
 
    <h1><i class='fa fa-user'></i> Update Lunch</h1>
 
    {{ Form::model($lunch, ['role' => 'form', 'url' => '/lunch/' . $lunch->id, 'method' => 'PUT']) }}
 
    <div class='form-group'>
        {{ Form::label('deadline', 'Deadline') }}
        {{ Form::text('deadline', null, ['placeholder' => 'Deadline', 'class' => 'form-control']) }}
    </div>
 
    {{ Form::label('restaurants', 'Restaurants') }}

    @foreach ($restaurants as $restaurant)
        <div class='form-group'>
            @if (isset($restaurant->checkbox) && $restaurant->checkbox === true)
            {{ Form::checkbox('restaurant_' . $restaurant->id, $restaurant->id, $restaurant->selected) }}
            @endif
            {{ $restaurant->name }}

            @if (isset($restaurant->rank) && $restaurant->rank == 1)
            {{ Form::radio('restaurant_rank_1', $restaurant->id, true) }}
            @else
            {{ Form::radio('restaurant_rank_1', $restaurant->id) }}
            @endif
            1

            @if (isset($restaurant->rank) && $restaurant->rank == 2)
            {{ Form::radio('restaurant_rank_2', $restaurant->id, true) }}
            @else
            {{ Form::radio('restaurant_rank_2', $restaurant->id) }}
            @endif
            2
            
            @if (isset($restaurant->rank) && $restaurant->rank == 3)
            {{ Form::radio('restaurant_rank_3', $restaurant->id, true) }}
            @else
            {{ Form::radio('restaurant_rank_3', $restaurant->id) }}
            @endif
            3
    @endforeach
    <br>
    {{ Form::label('friends', 'Friends') }}

    @foreach ($friends as $friend)
        <div class='form-group'>
            {{ Form::checkbox('friend_' . $friend->id, $friend->id, $friend->selected) }}
            {{ $friend->first_name }} {{ $friend->last_name }}
        </div>
    @endforeach
 
    <div class='form-group'>
        {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
    </div>
 
    {{ Form::close() }}
 
</div>
 
@stop