@extends('layouts.app')

@section('content')
<div class="container" id="home">
    <div class="row header">
        <h1><a href="{{route('home')}}">{{$author->name}}</a></h1>
        <small>Just do it!</small>
        <div class="form-search">
            <form class="form-inline" method="GET" action="{{route('home')}}">
                @csrf
                <input class="form-control" name="title" placeholder="Search title"/>
                <input type="submit" class="btn btn-primary" value="search" />
            </form>
        </div>
    </div>
    <div class="row article view">
        
        <div class="col-10">
            <article>
                <h3>{{$post->title}}</h3>
                <div>{{$post->created_at}}</div>
                <div><b>{!!$post->intro!!}</b></div>
                <div>
                    <img src="{{Utils::imageUrl($post->image)}}" width="100%"/>
                </div>
                <div>{!!$post->content!!}</div>
                <div class="read-more">
                    <small>Author</small>
                    <div class="author">
                        <div class="info">
                            <p>{{$author->name}}</p>
                            <p><a href="mailto:{{$author->email}}">{{$author->email}}</a></p>
                        </div>
                        <div class="avt">
                            <img src="{{Utils::get_gravatar($author->email, 90, 'retro')}}" />
                        </div>
                    </div>
                </div>
            </article>
            
        </div>
        <div class="col-2">
            @include('sections.menu')
        </div>
    </div>

    
</div>
@endsection
