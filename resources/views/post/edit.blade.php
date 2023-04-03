@extends('layouts.app')

@section('content')

<h1>Edit game</h1>

@if($errors->any())
<div class="alert alert-danger" role="alert">
    {{ implode('', $errors->all(':message ')) }}
</div>
@endif

<hr />

<form id="posteditform" action="{{ route('posts.update', ['post' => $post]) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="text" class="form-label">Text</label>
    <textarea type="text" class="form-control" id="text" name="text" maxlength="255" rows="6">{{ old('text') ?: $post->text }}</textarea>

    <br />

    <input type="submit" class="btn btn-primary" value="Submit">

</form>

@endsection