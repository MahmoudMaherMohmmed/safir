@extends('template')
@section('page_title')
@lang('messages.appointments.create_appointment')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.appointments.create_appointment') </h3>
                </div>
                <div class="box-content">
                    @if($appointment)
                    {!! Form::model($appointment,["url"=>"appointment/$appointment->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('appointment.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"appointment","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('appointment.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#appointment').addClass('active');
        $('#appointment_create').addClass('active');
    </script>
@stop
