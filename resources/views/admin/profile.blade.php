@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                    <div class="card-header">{{__('Profile')}}</div>
                    <div class="card-body row">
                        <div class="col-2">
                            <div id="avatar">
                                <img src="{{ Utils::get_gravatar(Auth::user()->email, 160) }}" />
                                <div class="change-avatar">
                                    <a href="https://gravatar.com/gravatars/new/">{{__('Change avatar')}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-10">
                            @if (session('status'))
                                <div class="alert alert-info">{{session('status')}}</div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="form-group col-12">
                                <form action="{{route('change-name')}}" method="POST">
                                    @csrf
                                    <div><label for="profile-name">{{__('Name:')}}</label></div>
                                    <div class="row">
                                        <div class="col-6">
                                            <input id="profile-name" name="name" class="form-control" value="{{Auth::user()->name}}" />
                                            <br />
                                            <input class="btn btn-primary" type="submit" name="change-name" value="{{__('Change Name')}}" />
                                        </div>
                                    </div>
                                </form> 
                            </div>
                            <div class="form-group col-12">
                                <form action="{{route('change-email')}}" method="POST">
                                    @csrf
                                    <label for="profile-email">Email address</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type='text' id="profile-email" name="email" class="form-control" value="{{old('email') ? old('email') : Auth::user()->email}}" />
                                            <br />
                                            <input class="btn btn-primary" type="submit" name="change-email" value="{{__('Change Email')}}" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="form-group col-12">
                                <label>Password</label>
                                <div class="row">
                                    <div class="col-6">
                                        <a href="{{route('password.request')}}" id="profile-reset-password" class="btn btn-primary">{{__('Change Password')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
