@extends('template')
@section('page_title')
    @lang('messages.kannel.logs')
@stop
@section('content')
    @include('errors')
    @if (Session::has('send_kannel_logs'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! Session::get('send_kannel_logs') !!}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>@lang('messages.kannel.logs')</h3>
                    <div class="box-tool">
                        <a class="btn btn-sm btn-primary show-tooltip" title="" href="{{ route('send.kannel.log') }}">
                            Send Email With Kannel Details Now <i class="fa fa-envelope"></i>
                        </a>
                    </div>
                </div>
                <div class="box-content">
                    <form method='GET' class="width_m_auto form-horizontal" action='{!! route('kannel.logs') !!}'>

                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">@lang('messages.kannel.select')</label>
                            <div class="col-sm-9 col-lg-10 controls">
                                <select class="form-control chosen" data-placeholder="@lang('messages.kannel.select')"
                                    name="kannel_id" tabindex="1">
                                    <option value=""></option>
                                    @foreach ($kannels as $kannel_item)
                                        <option value="{{ $kannel_item->id }}"
                                            {{ isset($kannel) && $kannel != null && $kannel->id == $kannel_item->id ? 'selected' : '' }}>
                                            {{ $kannel_item->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">@lang('messages.kannel.date')<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9 col-lg-10 controls">
                                {!! Form::text('date', isset($date) && $date != null ? $date : date('Y-m-d'), ['placeholder' => \Lang::get('messages.kannel.date'), 'class' => 'form-control js-datepicker', 'value' => date('Y-m-d'), 'autocomplete' => 'off']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6 col-lg-6" style="text-align: right;">
                                {!! Form::submit(\Lang::get('messages.kannel.submit'), ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (isset($logs) && count($logs) > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="box box-black">
                    <div class="box-title">
                        <h3><i class="fa fa-table"></i> @lang('messages.kannel.kannels')</h3>
                    </div>
                    <div class="box-content">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>@lang('messages.kannel.id')</th>
                                        <th>@lang('messages.kannel.kannel_title')</th>
                                        <th>@lang('messages.kannel.connection_name')</th>
                                        <th>@lang('messages.kannel.ip')</th>
                                        <th>@lang('messages.kannel.port')</th>
                                        <th>@lang('messages.kannel.status')</th>
                                        <th>@lang('messages.kannel.sent')</th>
                                        <th>@lang('messages.kannel.queued')</th>
                                        <th>@lang('messages.kannel.failed')</th>
                                        <th>@lang('messages.kannel.throughput')</th>
                                        <th>@lang('messages.kannel.created_at')</th>
                                        <th>@lang('messages.action')</th>
                                    </tr>
                                </thead>
                                <tbody id="tablecontents">
                                    @foreach ($logs as $key => $log)
                                        <tr class="table-flag-blue">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $log->kannel->title }}</td>
                                            <td>{{ $log->connection_name }}</td>
                                            <td>{{ $log->ip }}</td>
                                            <td>{{ $log->port }}</td>
                                            <td>{{ $log->status }}</td>
                                            <td>{{ $log->sent }}</td>
                                            <td>{{ $log->queued }}</td>
                                            <td>{{ $log->failed }}</td>
                                            <td>{{ $log->throughput }}</td>
                                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-success show-tooltip" title=""
                                                    href="{{ route('kannel.log.send_email', [$log->id]) }}"
                                                    data-original-title="Send Email">Send Email <i
                                                        class="fa fa-envelope"></i></a>
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
    @endif
@stop
@section('script')
    <script>
        $('#kannel').addClass('active');
        $('#kannel_logs').addClass('active');
    </script>
@stop
