@extends('layouts.app')

@section('content')

<div class="card-body">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
</div>

<h1>Feed: </h1>

@foreach ($posts as $post)
    

    <a href="{{route('posts.show', ['post' => $post])}}"><button style="width: 100%" class="btn btn-secondary white-btn">{{$post->user->name}} says: {{ $post->text }}</button></a>


@endforeach

@endsection