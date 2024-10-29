@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>User info:</h1>
        <img src="{{$user->photo}}" style="width: 70px;">
        <p>Name: {{$user->name}}</p>
        <p>Phone: {{$user->phone}}</p>
        <p>Email: {{$user->email}}</p>
        <p>Position: {{$user->position}}</p>
        <a class="btn btn-danger" href="{{ route('main.page') }}">Back</a>
    </div>
@endsection
