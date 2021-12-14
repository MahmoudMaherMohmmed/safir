@extends('template')
@section('page_title')
@lang('messages.trips.create_trip')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.trips.create_trip') </h3>
                </div>
                <div class="box-content">
                    @if($trip)
                    {!! Form::model($trip,["url"=>"trip/$trip->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('trip.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"trip","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('trip.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#trip').addClass('active');
        $('#trip_create').addClass('active');
    </script>
@stop
