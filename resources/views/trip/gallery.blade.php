@extends('template')
@section('page_title')
@lang('messages.trips.gallery')
@stop
@section('content')
    @include('errors')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.trips.gallery') </h3>
                </div>
                <div class="box-content">
                    @if($trip)
                        @if(isset($trip->images) && $trip->images->count()>0)
                            <div class="row" style="margin-bottom: 30px;">
                                @foreach($trip->images as $image)
                                    <div class="col-sm-6 col-lg-3" style="margin-bottom:15px;">
                                        <image src="{{url($image->image)}}" width=100% height=250px style="border: 1px solid #eee; border-radius: 7px;" />
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        {!! Form::model($trip,["url"=>"upload_to_gallery","class"=>"form-horizontal","method"=>"post","files"=>"True"]) !!}
                            <input type="hidden" name="trip_id" value="{{$trip->id}}" />
                            <div class="form-group">
                                <label class="col-sm-3 col-lg-2 control-label">@lang('messages.trips.gallery') <span class="text-danger">*</span></label>
                                <div class="col-sm-9 col-lg-10 controls">
                                    <div class="col-sm-9 col-lg-9">
                                        <input type="file" class="form-control" name="image" />
                                    </div>
                                    <div class="col-sm-3 col-lg-3">
                                        <button class="btn btn-success upload-to-gallery">@lang('messages.trips.upload_to_gallery')</button>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    @endif
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