<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.clients.clients') </label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="client_id" required disabled>
        @foreach($clients as $client)
        <option value="{{$client->id}}" {{$reservation && $reservation->client_id==$client->id ? 'selected' : '' }}>{{$client->name}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        {!! Form::submit($buttonAction,['class'=>'btn btn-primary']) !!}
    </div>
</div>
