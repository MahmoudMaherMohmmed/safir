@extends('template')
@section('page_title')
@lang('messages.appointments.appointments')
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-black">
            <div class="box-title">
                <h3><i class="fa fa-table"></i> @lang('messages.appointments.appointments')</h3>
            </div>
            <div class="box-content">
                <div class="btn-toolbar pull-right">
                    <div class="btn-group">
                        @if (get_action_icons('appointment/create', 'get'))
                        <a class="btn btn-circle show-tooltip" title="" href="{{ url('appointment/create') }}"
                            data-original-title="Add new record"><i class="fa fa-plus"></i></a>
                        @endif
                        <?php $table_name = 'appointments'; ?>
                    </div>
                </div>
                <br><br>
                <div class="table-responsive">
                    <table id="example" class="table table-striped dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width:18px"><input type="checkbox" id="check_all" data-table="{{ $table_name }}"></th>
                                <th>@lang('messages.appointments.doctor')</th>
                                <th>@lang('messages.appointments.date')</th>
                                <th>@lang('messages.appointments.start_from')</th>
                                <th>@lang('messages.appointments.end_at')</th>
                                <th>@lang('messages.status.status')</th>
                                <th class="visible-md visible-lg" style="width:130px">@lang('messages.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                            <tr class="table-flag-blue">
                                <th><input type="checkbox" name="selected_rows[]" class="select_all_template" value="{{ $appointment->id }}"></th>
                                <td>{{ $appointment->doctor->name }}</td>
                                <td>{{ $appointment->date }}</td>
                                <td>{{ $appointment->from }}</td>
                                <td>{{ $appointment->to }}</td>
                                <td>{{ $appointment->status==0 ? 'Available' : 'Reserved'}}</td>
                                <td class="visible-xs visible-sm visible-md visible-lg">
                                    <div class="btn-group">
                                        @if (get_action_icons('appointment/{id}/delete', 'get'))
                                        <form action="{{ route('appointment.destroy', $appointment->id) }}"
                                            method="POST" style="display: initial;">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                style="height: 28px;"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<script>
    $('#appointment').addClass('active');
	$('#appointment_index').addClass('active');
</script>
@stop
