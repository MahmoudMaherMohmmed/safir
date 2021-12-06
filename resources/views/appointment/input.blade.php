{{ csrf_field() }}
<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.appointments.doctor')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="doctor_id" required>
        @foreach($doctors as $doctor)
            <option value="{{$doctor->id}}" {{$appointment && $appointment->doctor_id==$doctor->id ? 'selected' : '' }}>{{$doctor->name}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.appointments.date') <span class="text-danger">*</span></label>
    <div class="col-sm-4 col-lg-5 controls">
        {!! Form::text('date_from',null,['placeholder'=>'From','class'=>'form-control js-datepicker' ,'value' => 'date("Y-m-d")' , 'autocomplete' => 'off' ]) !!}
    </div>
    <div class="col-sm-4 col-lg-5 controls">
        {!! Form::text('date_to',null,['placeholder'=>'To','class'=>'form-control js-datepicker' ,'value' => 'date("Y-m-d")' , 'autocomplete' => 'off' ]) !!}
    </div>
</div> 

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.appointments.time')<span class="text-danger">*</span></label>
    <div class="col-sm-4 col-lg-5 controls">
      <select class="form-control chosen-rtl" name="from" required>
          @include('partial.hours')
      </select>
    </div>
    <div class="col-sm-5 col-lg-5 controls">
      <select class="form-control chosen-rtl" name="to" required>
            @include('partial.hours')
      </select>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        <input type="submit" class="btn btn-primary" value="@lang('messages.save')">
    </div>
</div>
