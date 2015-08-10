@extends('layouts.master')
 
@section('title') Users @stop
 
@section('content')
 
<div class="col-lg-10 col-lg-offset-1">
 
    <h1><i class="fa fa-users"></i> Dashboard <a href="/logout" class="btn btn-default pull-right">Logout</a></h1>
 
    <h2>Lunches</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
 
            <thead>
                <tr>
                    <th>Deadline</th>
                    <th>Date/Time Added</th>
                    <th></th>
                </tr>
            </thead>
 
            <tbody>
                @foreach ($lunches as $lunch)
                <tr>
                    <td>{{ $lunch->deadline }}</td>
                    <td>{{ $lunch->created_at }}</td>
                    <td>
                        <a href="/lunch/{{ $lunch->id }}/edit" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>
                        {{ Form::open(['url' => '/lunch/' . $lunch->id, 'method' => 'DELETE']) }}
                        {{ Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
 
        </table>
    </div>
 
    <a href="/lunch/create" class="btn btn-success">Create Lunch</a>

    <h2>Restaurants</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
 
            <thead>
                <tr>
                    <th>Name</th>
                    <th></th>
                </tr>
            </thead>
 
            <tbody>
                @foreach ($restaurants as $restaurant)
                <tr>
                    <td>{{ $restaurant->name }}</td>
                    <td>
                        <a href="/restaurant/{{ $restaurant->id }}/edit" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>
                        {{ Form::open(['url' => '/restaurant/' . $restaurant->id, 'method' => 'DELETE']) }}
                        {{ Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
 
        </table>
    </div>
 
    <a href="/restaurant/create" class="btn btn-success">Add Restaurant</a>

    <div>
     
        <h2>Friends</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
     
                <thead>
                    <tr>
                        <th>Name</th>
                        <th></th>
                    </tr>
                </thead>
     
                <tbody>
                    @foreach ($friends as $friend)
                    <tr>
                        <td>{{ $friend->first_name }} {{ $friend->last_name }}</td>
                        <td>
                            {{ Form::open(['url' => '/user/remove_friend/' . $friend->id, 'method' => 'DELETE']) }}
                            {{ Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                            {{ Form::close() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
     
            </table>
        </div>

    </div>

    <div>
     
        <h2>Search for Friend</h2>
     
        {{ Form::open(['role' => 'form', 'url' => '/user/search']) }}
     
        <div class='form-group'>
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) }}
        </div>
     
        <div class='form-group'>
            {{ Form::submit('Search', ['class' => 'btn btn-primary']) }}
        </div>
     
        {{ Form::close() }}
     
    </div>
 
</div>
 
@stop