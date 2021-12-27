<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.special_trips.name')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="client_id" required {{$special_trip!=null ? 'disabled' : ''}}>
        @foreach($clients as $client)
        <option value="{{$client->id}}" {{$special_trip && $special_trip->client_id==$client->id ? 'selected' : '' }}>{{$client->name}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.trips.countries')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="country_id" required {{$special_trip!=null ? 'disabled' : ''}}>
        @foreach($countries as $country)
        <option value="{{$country->id}}" {{$special_trip && $special_trip->country_id==$country->id ? 'selected' : '' }}>{{$country->title}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.appointments.date') <span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        {!! Form::text('start_date', null, ['placeholder'=>'To', 'class'=>'form-control js-datepicker', 'value' => '$special_trip->start_date', 'autocomplete' => 'off' ]) !!}
    </div>
</div> 

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.special_trips.days_count') <span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="text" class="form-control" name="days_count" value="@if ($special_trip) {{ $special_trip->days_count }} @endif" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.trips.persons_count') <span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="text" class="form-control" name="persons_count" value="@if ($special_trip) {{ $special_trip->persons_count }} @endif" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.description') <span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <textarea class="form-control" name="description" rows=6>{{$special_trip ? $special_trip->description : ''}}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.status.status')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="status" required>
        <option value="0" {{$special_trip && $special_trip->status==0 ? 'selected' : '' }}>قيد المراجعه</option>
        <option value="1" {{$special_trip && $special_trip->status==1 ? 'selected' : '' }}>مقبول</option>
        <option value="2" {{$special_trip && $special_trip->status==2 ? 'selected' : '' }}>مرفوض</option>
      </select>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        {!! Form::submit($buttonAction,['class'=>'btn btn-primary']) !!}
    </div>
</div>
