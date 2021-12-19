@extends('template')
@section('page_title')
@lang('messages.media.create_media')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.media.create_media') </h3>
                </div>
                <div class="box-content">
                    @if($media)
                    {!! Form::model($media,["url"=>"media/$media->id","class"=>"form-horizontal","method"=>"patch","files"=>"True"]) !!}
                    @include('media.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'  (optional)'])
                    @else
                    {!! Form::open(["url"=>"media","class"=>"form-horizontal","method"=>"POST","files"=>"True"]) !!}
                    @include('media.input',['buttonAction'=>''.\Lang::get("messages.save").'','required'=>'  *'])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

@stop
@section('script')
    <script>
        $('#media').addClass('active');
        $('#media_create').addClass('active');
    </script>
@stop
