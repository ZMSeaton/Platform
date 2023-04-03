@extends('layouts.app')

@section('content')

@foreach ($users as $user)

    <a href="{{route('users.show', ['user' => $user])}}"><button style="width: 100%" class="btn btn-secondary white-btn">{{ $user->name }}</button></a>

    <br>
    <br>

@endforeach

@endsection