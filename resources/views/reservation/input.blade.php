<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.doctors.doctors') </label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="specialty_id" required disabled>
        @foreach($doctors as $doctor)
        <option value="{{$doctor->id}}" {{$reservation && $reservation->appointment->doctor->id==$doctor->id ? 'selected' : '' }}>{{$doctor->name}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.appointments.date') </label>
    <div class="col-sm-4 col-lg-5 controls">
        <input type="text" class="form-control" name="date" value="@if ($reservation) {!! $reservation->appointment->date !!} @endif" disabled/>
    </div>
    <div class="col-sm-5 col-lg-5 controls">
        <input type="text" class="form-control" name="time" value="@if ($reservation) {!! $reservation->appointment->from !!} @endif" disabled/>
    </div>
</div> 

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.reservations.patient_name') </label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="text" class="form-control" name="patient_name" value="@if ($reservation) {!! $reservation->patient_name !!} @endif" />
    </div>
</div> 

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.reservations.phone_number') </label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="text" class="form-control" name="phone_number" value="@if ($reservation) {!! $reservation->phone_number !!} @endif" />
    </div>
</div> 

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.reservations.age') </label>
    <div class="col-sm-9 col-lg-10 controls">
        <input type="text" class="form-control" name="age" value="@if ($reservation) {!! $reservation->age !!} @endif" />
    </div>
</div> 

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.reservations.gender') </label>
    <div class="col-sm-9 col-lg-10 controls">
        <select class="form-control chosen-rtl" name="gender" required>
            <option value="0" {{$reservation && $reservation->gender==0 ? 'selected' : '' }}>Male</option>
            <option value="1" {{$reservation && $reservation->gender==1 ? 'selected' : '' }}>Female</option>
        </select>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        {!! Form::submit($buttonAction,['class'=>'btn btn-primary']) !!}
    </div>
</div>
