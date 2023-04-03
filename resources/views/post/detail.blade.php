@extends('layouts.app')

@section('content')

<div class="card-body">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
</div>

<p><a href="{{route('users.show', ['user' => $user])}}"><button class="btn btn-secondary white-btn">{{ $user->name }}</button></a> says:</p>

<br>
<br>

<h1>{{ $post->text }}</h1>

@if ($user->id == Auth::user()->id)
<p>
    <a href="{{route('posts.edit', ['post' => $post])}}"><button class="btn btn-secondary white-btn">Update post</button></a>

<form id="deletepost" action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" onClick="return confirm('Delete?')" class="btn btn-secondary white-btn">Delete post</button>
</form>
</p>
@endif

<br>
<br>
<br>
<hr>

<h2>Comments</h2>

@if($errors->any())
<div class="alert alert-danger" role="alert">
    {{ implode('', $errors->all(':message ')) }}
</div>
@endif

@foreach ($post->comments as $comment)

<p><a href="{{route('users.show', ['user' => $comment->user])}}">{{ $comment->user->name }}</a>: {{ $comment->text }}</p>

<br>

@endforeach

<form id="commentmakeform" action="{{ route('comments.store') }}" method="POST">
    @csrf

    <input type="hidden" id="post_id" name="post_id" value="{{ $post->id }}">

    <label for="text" class="form-label">Make comment:</label>
    <textarea type="text" class="form-control" id="text" name="text" maxlength="255" rows="6">{{ old('text') }}</textarea>

    <br />

    <input type="submit" class="btn btn-primary" value="Submit">

</form>

@endsection