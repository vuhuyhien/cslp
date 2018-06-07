@extends('layouts.app')

@section('content')
<div class="container" id="home">
    <div class="row header">
        <h1>{{$author->name}}</h1>
        <small>Just do it!</small>
        <div class="form-search">
            <form class="form-inline" method="GET" action="{{route('home')}}">
                @csrf
                <input class="form-control" name="title" placeholder="Search title" value="{{$title}}"/>
                <input type="submit" class="btn btn-primary" value="search" />
            </form>
        </div>
    </div>
    <div class="row article">
        <div class="col-10">
            @foreach($posts as $post)
                <article>
                    <h3>{{$post->title}}</h3>
                    <div>{{$post->created_at}}</div>
                    <div>{!!$post->intro!!}</div>
                    <div class="read-more">
                        <a href="{{route('view-post', $post->id)}}">READ MORE</a>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="col-2">
            @include('sections.menu')
        </div>
    </div>
    <div class="row">
        {{$posts ? $posts->links() : ''}}
    </div>
</div>
@endsection
