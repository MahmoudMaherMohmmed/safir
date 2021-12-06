@extends('template')
@section('page_title')
    @lang('messages.kannel.kannel_status')
@stop
@section('content')
    @if (isset($kannels_title) && count($kannels_title) > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="box box-black">
                    <div class="box-title">
                        <h3><i class="fa fa-table"></i> @lang('messages.kannel.kannels')</h3>
                    </div>
                    <div class="box-content">
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>@lang('messages.kannel.kannel_title')</th>
                                        <th>@lang('messages.kannel.connection_name')</th>
                                        <th>@lang('messages.kannel.ip')</th>
                                        <th>@lang('messages.kannel.port')</th>
                                        <th>@lang('messages.kannel.status')</th>
                                        <th>@lang('messages.kannel.sent')</th>
                                        <th>@lang('messages.kannel.queued')</th>
                                        <th>@lang('messages.kannel.failed')</th>
                                        <th>@lang('messages.kannel.throughput')</th>
                                    </tr>
                                </thead>
                                <tbody id="tablecontents">
                                    @foreach ($kannels_title as $kannel_title)
                                        <tr class="table-flag-blue">
                                            <td>{{ $kannel_title }}</td>
                                            <td>{{ $kannels_connection[$kannel_title]['connection_name'] }}</td>
                                            <td>{{ $kannels_connection[$kannel_title]['ip'] }}</td>
                                            <td>{{ $kannels_connection[$kannel_title]['port'] }}</td>
                                            <td>{{ $kannels_connection[$kannel_title]['status'] }}</td>
                                            <td>{{ $kannels_connection[$kannel_title]['sent'] }}</td>
                                            <td>{{ $kannels_connection[$kannel_title]['queued'] }}</td>
                                            <td>{{ $kannels_connection[$kannel_title]['failed'] }}</td>
                                            <td>{{ $kannels_connection[$kannel_title]['throughput'] }}</td>
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
        $('#kannel_status').addClass('active');
    </script>
@stop
