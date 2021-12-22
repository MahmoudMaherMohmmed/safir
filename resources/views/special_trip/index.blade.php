@extends('template')
@section('page_title')
    @lang('messages.special_trips.special_trips')
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-black">
                        <div class="box-title">
                            <h3><i class="fa fa-table"></i> @lang('messages.special_trips.special_trips')</h3>
                        </div>
                        <div class="box-content">
                            <div class="btn-toolbar pull-right">
                                <div class="btn-group">
                                    @if (get_action_icons('special_trip/create', 'get'))
                                        <a class="btn btn-circle show-tooltip" title=""
                                            href="{{ url('special_trip/create') }}" data-original-title="Add new record"><i
                                                class="fa fa-plus"></i></a>
                                    @endif
                                    <?php $table_name = 'special_trips';
                                    // pass table name to delete all function
                                    // if the current route exists in delete all table flags it will appear in view
                                    // else it'll not appear
                                    ?>
                                </div>
                            </div>
                            <br><br>
                            <div class="table-responsive">
                                <table id="example" class="table table-striped dt-responsive" cellspacing="0" width="100%">

                                    <thead>
                                        <tr>
                                            <th style="width:18px"><input type="checkbox" id="check_all" data-table="{{ $table_name }}"></th>
                                            <th>id</th>
                                            <th>@lang('messages.special_trips.name')</th>
                                            <th>@lang('messages.special_trips.start_date')</th>
                                            <th>@lang('messages.special_trips.days_count')</th>
                                            <th>@lang('messages.special_trips.persons_count')</th>
                                            <th>@lang('messages.status.status')</th>
                                            <th>@lang('messages.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($special_trips as $value)
                                            <tr>
                                                <td><input type="checkbox" name="selected_rows[]" value="{{ $value->id }}" class="roles select_all_template">
                                                </td>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->client->name }}</td>
                                                <td>{{ $value->start_date }}</td>
                                                <td>{{ $value->days_count }}</td>
                                                <td>{{ $value->persons_count }}</td>
                                                <td>
                                                    @if($value->status==0)
                                                        قيد المراجعه
                                                    @elseif($value->status==1)
                                                        مقبول
                                                    @else
                                                        مرفوض      
                                                    @endif
                                                </td>

                                                <td class="visible-md visible-xs visible-sm visible-lg">
                                                    <div class="btn-group">
                                                        @if (get_action_icons('special_trip/{id}/edit', 'get'))
                                                            <a class="btn btn-sm show-tooltip"
                                                                href='{{ url("special_trip/$value->id/edit") }}'
                                                                title="Edit"><i class="fa fa-edit"></i></a>
                                                        @endif
                                                        @if (get_action_icons('special_trip/{id}/delete', 'get'))
                                                            <form action="{{ route('special_trip.destroy', $value->id) }}"
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
        </div>

    </div>

@stop

@section('script')
    <script>
        $('#special_trip').addClass('active');
        $('#special_trip_index').addClass('active');
    </script>
@stop
