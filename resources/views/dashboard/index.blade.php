@extends('template')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <a class="tile tile-light-blue" data-stop="500" href="{{url('users')}}">
                <div class="img img-center">
                    <i class="fa fa-users"></i>
                    <p class="title text-center">{{$users}}</p>
                    <p class="title text-center">@lang('messages.users.users')</p>
                </div>
            </a>
        </div>
    </div>
@stop
