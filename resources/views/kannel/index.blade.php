@extends('template')
@section('page_title')
    @lang('messages.kannel.kannels')
@stop
@section('content')
    @include('errors')
    <!-- BEGIN Content -->
    <div id="main-content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-black">
                    <div class="box-title">
                        <h3><i class="fa fa-table"></i> @lang('messages.kannel.kannels')</h3>
                    </div>
                    <div class="box-content">
                        <div class="btn-toolbar pull-right">
                            <div class="btn-group">
                                {{-- @if (get_action_icons('kannel/create', 'get')) --}}
                                <a class="btn btn-circle show-tooltip" title="" href="{{ url('kannel/create') }}"
                                    data-original-title="Add New Kannel"><i class="fa fa-plus"></i></a>
                                {{-- @endif --}}
                            </div>
                        </div>
                        <br><br>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>@lang('messages.kannel.id')</th>
                                        <th>@lang('messages.kannel.title')</th>
                                        <th>@lang('messages.kannel.url')</th>
                                        <th>@lang('messages.kannel.status')</th>
                                        <th class="visible-md visible-lg" style="width:130px">@lang('messages.action')</th>
                                    </tr>
                                </thead>
                                <tbody id="tablecontents">
                                    @foreach ($kannels as $key => $kannel)
                                        @php $kannel_url = substr($kannel->url, 0, strpos($kannel->url, '.xml')) @endphp
                                        <tr class="table-flag-blue">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $kannel->title }}</td>
                                            <td><a href="{{ $kannel_url }}" target="_blank">{{ $kannel_url }}</a></td>
                                            <td>{{ $kannel->status == 1 ? 'Active' : 'Not Active' }}</td>
                                            <td class="visible-md visible-xs visible-sm visible-lg">
                                                <div class="btn-group">
                                                    <a class="btn btn-sm btn-success show-tooltip" title=""
                                                        href="{{ route('kannel.logs', ['kannel_id' => $kannel->id]) }}"
                                                        data-original-title="Logs"><i class="fa fa-list"></i></a>
                                                    {{-- @if (get_action_icons('kannel/{id}/edit', 'get')) --}}
                                                    <a class="btn btn-sm btn-primary show-tooltip" title=""
                                                        href="{{ url('kannel/' . $kannel->id . '/edit') }}"
                                                        data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                    {{-- @endif --}}
                                                    {{-- @if (get_action_icons('kannel/{id}/delete', 'get')) --}}
                                                    <a class="btn btn-sm btn-danger show-tooltip" title=""
                                                        onclick='return ConfirmDelete()'
                                                        href="{{ url('kannel/' . $kannel->id . '/delete') }}"
                                                        data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                                                    {{-- @endif --}}
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
    </div>

@stop
@section('script')
    <script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $("#example").DataTable();
        });
    </script>
    <script>
        $('#kannel').addClass('active');
        $('#kannel_index').addClass('active');
    </script>
@stop
