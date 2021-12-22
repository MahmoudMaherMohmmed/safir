<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.reservations.client_name') </label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="client_id" required {{$reservation!=null ? 'disabled' : ''}}>
        @foreach($clients as $client)
        <option value="{{$client->id}}" {{$reservation && $reservation->client_id==$client->id ? 'selected' : '' }}>{{$client->name}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.reservations.trip_name') </label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="trip_id" required {{$reservation!=null ? 'disabled' : ''}}>
        @foreach($trips as $trip)
        <option value="{{$trip->id}}" {{$reservation && $reservation->trip_id==$trip->id ? 'selected' : '' }}>{{$trip->name}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.status.status')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="status" required>
        <option value="1" {{$reservation && $reservation->status==1 ? 'selected' : '' }}>قيد المراجعه</option>
        <option value="2" {{$reservation && $reservation->status==2 ? 'selected' : '' }}>مقبول</option>
        <option value="0" {{$reservation && $reservation->status==0 ? 'selected' : '' }}>مرفوض</option>
      </select>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        {!! Form::submit($buttonAction,['class'=>'btn btn-primary']) !!}
    </div>
</div>
