@extends('layouts.master')
 
@section('title') Create User @stop
 
@section('content')
 
<div class='col-lg-4 col-lg-offset-4'>
 
    @if ($errors->has())
        @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }}</div>
        @endforeach
    @endif
 
    <h1><i class='fa fa-user'></i> Search Results</h1>
 
    @foreach ($users as $user)
        [ <a href="/user/add_friend/{{ $user->id }}">Add</a> ] <?php echo $user->first_name; ?>
    @endforeach
 
</div>
 
@stop