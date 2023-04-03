@extends('layouts.app')

@section('content')

@if($errors->any())
<div class="alert alert-danger" role="alert">
    {{ implode('', $errors->all(':message ')) }}
</div>
@endif

<form action="{{ route('users.update', ['user' => $user]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label for="image">Image:</label>
    <input type="file" name="image" id="image" /><br />
    <input type="submit" name="submit" value="Submit" />
</form>

@endsection