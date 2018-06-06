@extends('layouts.app')

@section('content')
<div class="container" id="home">
    <div class="row header">
        <h1>{{$author}}</h1>
        <small>Just do it!</small>
        <div class="form-search">
            <form class="form-inline" method="GET" action="{{route('home')}}">
                @csrf
                <input class="form-control" name="title" placeholder="Search title"/>
                <input type="submit" class="btn btn-primary" value="search" />
            </form>
        </div>
    </div>
    <div class="row article">
        <article>
            <h3>{{$post->title}}</h3>
            <div>{{$post->created_at}}</div>
            <div>{!!$post->intro!!}</div>
            <div>
                <img src="{{asset('storage')}}/{{$post->image}}" width="100%"/>
            </div>
            <div>{!!$post->content!!}</div>
            <div class="read-more">
                {{$author}}
            </div>
        </article>
    </div>
</div>
@endsection
