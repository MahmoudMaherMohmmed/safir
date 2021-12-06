@extends('template')
@section('page_title')
    @lang('messages.kannel.kannel')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.kannel.kannel_form')</h3>
                    <div class="box-tool">
                        <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                        <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    @if ($kannel)
                        {!! Form::model($kannel, ['url' => "kannel/$kannel->id", 'class' => 'form-horizontal', 'method' => 'patch', 'files' => 'True']) !!}
                        @include('kannel.input',['buttonAction'=>''.\Lang::get("messages.Edit").'','required'=>'
                        (optional)'])
                    @else
                        {!! Form::open(['url' => 'kannel', 'class' => 'form-horizontal', 'method' => 'POST', 'files' => 'True']) !!}
                        @include('kannel.input',['buttonAction'=>''.\Lang::get("messages.save").''])
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        $('#kannel').addClass('active');
        $('#kannel_create').addClass('active');
    </script>
@stop
