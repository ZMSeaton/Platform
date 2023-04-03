@extends('layouts.app')

@section('content')

<div class="card-body">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
</div>

<table>
    <tr>
        <td style="width: 15%;">
            @if ($user->image != null)
            <img class="img-fluid rounded-circle" src="http://platform.test/img\profile\{{ $user->image }}">
            @endif
            @if ($user->image == null)
            <img class="img-fluid rounded-circle" src="{{asset('img\profile\star.png')}}">
            @endif
        </td>
        <td class="align-bottom">
            <h1>{{ $user->name }}'s page</h1>
        </td>
        <td style="width: 15%;" class="align-bottom">
            <form id="followaction" action="{{ route('follow', ['user' => $user]) }}" method="POST">
                @csrf
                @if (Auth::user()->isFollowing($user))
                <button style="width: 100%;" type="submit" class="btn btn-secondary">Following</button>
                @else
                <button style="width: 100%;" type="submit" class="btn btn-primary">Follow</button>
                @endif
            </form>

        </td>
        <td style="width: 15%;" class="align-bottom">
            <h3>{{ $user->followers->count() }} followers</h3>
        </td>
    </tr>
</table>

<br>
<br>
<br>

<hr>

<h1>Posts:</h1>

@foreach ($posts as $post)

<a href="{{route('posts.show', ['post' => $post])}}"><button style="width: 100%" class="btn btn-secondary white-btn">{{ $post->text }}</button></a>

<br>
<br>

@endforeach

@endsection