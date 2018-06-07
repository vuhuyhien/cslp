@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card col-12">
            <div class="card-header row">
                Posts
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-info">{{session('status')}}</div>
                @endif
                <div class="row">
                    <form  class="form-inline" id="posts-search" action="" method="GET">
                        <input name="title" value="{{ isset($title['title']) ? $title['title'] : '' }}" class="form-control" placeholder="Search by title" type="text" />
                        <select id="posts-category" class="form-control" name="category_id">
                            <option 
                                value="">
                                -- Select category --
                            </option>
                            @foreach($categories as $cate)
                                <option 
                                    value="{{$cate->id}}">
                                    {{$cate->name}}
                                </option>
                            @endforeach
                        </select>
                        <input class="btn btn-primary" type="submit" value="Search" />
                    </form>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Title</th>
                        <th scope="col">Type</th>
                        <th scope="col">Category</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Updated at</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $key => $post)
                        <tr>
                            <th scope="row">{{$key + ($posts->currentPage() - 1) * $posts->perPage() + 1}}</th>
                            <td><img src="{{Utils::imageUrl($post->image)}}" width="30" /></td>
                            <td>{{$post->title}}</td>
                            <td>{{$post->type ? 'public' : 'draft'}}</td>
                            <td>{{$post->category->name}}</td>
                            <td>{{$post->created_at}}</td>
                            <td>{{$post->updated_at}}</td>
                            <td>
                                <input onclick="document.getElementById('posts-edit-{{$post->id}}').submit()" type="button" class="btn btn-primary" value="Edit"/>
                                <form id="posts-edit-{{$post->id}}" action="{{route('posts.edit', $post->id)}}" method="GET" class="hidden">
                                    @csrf
                                </form>
                                <input onclick="document.getElementById('posts-delete-{{$post->id}}').submit()" type="button" class="btn btn-danger" value="Delete"/>
                                <form id="posts-delete-{{$post->id}}" action="{{route('posts.destroy', $post->id)}}" method="POST" class="hidden">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row justify-content-center">
                    {{$posts->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection