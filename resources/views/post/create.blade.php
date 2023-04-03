@extends('layouts.app')

@section('content')

<h1>Make post</h1>

@if($errors->any())
<div class="alert alert-danger" role="alert">
    {{ implode('', $errors->all(':message ')) }}
</div>
@endif

<hr />

<form id="postmakeform" action="{{ route('posts.store') }}" method="POST">
    @csrf

    <label for="text" class="form-label">Text</label>
    <textarea type="text" class="form-control" id="text" name="text" maxlength="255" rows="6">{{ old('text') }}</textarea>

    <br/>

    <input type="submit" class="btn btn-primary" value="Submit">

</form>

@endsection