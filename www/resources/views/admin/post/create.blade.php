@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card col-12">
            <div class="card-header row">
                Create Post
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="create-post-form" action="{{route('posts.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <textarea id="posts-intro" name="intro" class="hidden">{!!old('intro')!!}</textarea>
                    <textarea id="posts-content" name="content" class="hidden">{!!old('content')!!}</textarea>
                    <div class="form-group">
                        <label for="posts-title">Title</label>
                        <input value="{{old('title')}}" type="text" name="title" class="form-control" id="posts-title" placeholder="Enter title">
                    </div>
                    <div class="form-group">
                        <label for="posts-category">Category</label>
                        <select id="posts-category" class="form-control" name="category_id">
                            @foreach($categories as $cate)
                                <option 
                                    @if($cate->name == config('constants.CATEGORY_DEFAULT')) selected  @endif 
                                    value="{{$cate->id}}">
                                    {{$cate->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="posts-image">Image</label>
                        <input type="file" name="image" class="form-control" id="posts-image" placeholder="Enter title">
                    </div>
                    <div class="form-group">
                        <label for="posts-public">Is Public ?</label>
                        @if(old('type') == 1)
                            <input checked type="checkbox" name="type" id="posts-public" value="1">
                        @else
                            <input type="checkbox" name="type" id="posts-public" value="1">
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Intro</label>
                        <div class="intro">{!!old('intro')!!}</div>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <div class="content">{!!old('content')!!}</div>
                    </div>
                    
                    <button type="submit" id="posts-create-submit" class="btn btn-primary">{{__('Save')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- @section('style')
    <!-- include summernote css/js -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
@endsection --}}

@section('script')

    <script type="text/javascript">
        $(document).ready(function() {
            $.getScript('https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js', function() {
                $('.intro').summernote({
                    height: 150,
                    callbacks: {
                        onChange: function(contents, $editable) {
                            $("#posts-intro").html(contents);
                        }
                    }
                });

                $('.content').summernote({
                    height: 300,
                    callbacks: {
                        onChange: function(contents, $editable) {
                            $("#posts-content").html(contents);
                        }
                    }
                });
            });
            
            // $("#create-post-form").on('submit', function(e) {
            //     e.preventDefault();
            //     let intro = $('textarea')
            //         .prop('name', 'intro')
            //         .prop('value', $('.intro').summernote('code'));
            //     intro.addClass('hidden');
            //     let content = $('textarea')
            //         .prop('name', 'content')
            //         .prop('value', $('.content').summernote('code'));
            //     $("#create-post-form").append(intro);  
            //     $("#create-post-form").append(content);  
            // })
        });
    </script>
@endsection