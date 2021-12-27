@extends('template')
@section('page_title')
@lang('messages.special_trips.create_special_trip')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.special_trips.create_special_trip') </h3>
                </div>
                <div class="box-content">
                    @if($special_trip)
                    {!! Form::model($special_trip,["url"=>"special_trip/$special_trip->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('special_trip.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"special_trip","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('special_trip.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#special_trip').addClass('active');
        $('#special_trip_create').addClass('active');
    </script>
@stop
