@extends('admin.layouts.admin')

@section('content')
<div class="container">
        <form action="{{route('create-category-add')}}" method="POST">
        {{ csrf_field() }}
            <h5>Tạo Category</h5>
            @if (session('status'))
                <div class="alert alert-info">{{session('status')}}</div>
             @endif
            <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name: </label>
                    <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="inputEmail3" value="{{ old('name') }}" placeholder="Name">
                        @if($errors->has('name'))
                                <div class="invalid-feedback-name-category">
                                {{$errors->first('name')}}
                                </div>
                        @endif

            </div>

            <div class="form-group row">
                    <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
</div>

@endsection
