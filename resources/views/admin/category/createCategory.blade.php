@extends('admin.layouts.admin')

@section('content')
<div class="container">
<div class="card">
  <div class="card-header">
  Create Category
  </div>
  <div class="card-body">
  <form action="{{route('category.store')}}" method="POST">
        {{ csrf_field() }}
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

            </div>

            <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Description: </label>
                    <div class="col-sm-10">
                    <textarea class="form-control" name="description" cols="50" rows="10" id="description"></textarea>
                </div>

            </div>

            <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
            </div>
        </form>
  </div>
</div>
</div>

@endsection
