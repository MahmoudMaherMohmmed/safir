@extends('template')
@section('page_title')
    @lang('messages.reservations.reservations')
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-black">
                        <div class="box-title">
                            <h3><i class="fa fa-table"></i> @lang('messages.reservations.reservations')</h3>
                        </div>
                        <div class="box-content">
                            <div class="btn-toolbar pull-right">
                                <div class="btn-group">
                                    @if (get_action_icons('reservation/create', 'get'))
                                        <a class="btn btn-circle show-tooltip" title=""
                                            href="{{ url('reservation/create') }}" data-original-title="Add new record"><i
                                                class="fa fa-plus"></i></a>
                                    @endif
                                    <?php $table_name = 'reservations';
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
                                            <th>@lang('messages.name')</th>
                                            <th>@lang('messages.trips.name')</th>
                                            <th>@lang('messages.trips.payment_type')</th>
                                            <th>@lang('messages.trips.status')</th>
                                            <th>@lang('messages.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reservations as $value)
                                            <tr>
                                                <td><input type="checkbox" name="selected_rows[]" value="{{ $value->id }}" class="roles select_all_template">
                                                </td>
                                                <td>{{ $value->id }}</td>
                                                <td> {{ $value->client->name }} </td>
                                                <td> {{ $value->trip->getTranslation('name', Session::get('applocale')) }} </td>
                                                <td> {{ $value->bankTransfer!=null ? ($value->payment_type==0 ? 'تحويل بنكى' : 'دفع الالكترونى') : '---'}} </td>
                                                <td> {{ $value->status==1 ? 'قيد المراجعه' : 'تم الموافقه' }} </td>
                                                <td class="visible-md visible-xs visible-sm visible-lg">
                                                    <div class="btn-group">
                                                        @if (get_action_icons('reservation/{id}/edit', 'get'))
                                                            <a class="btn btn-sm show-tooltip"
                                                                href='{{ url("reservation/$value->id/edit") }}'
                                                                title="Edit"><i class="fa fa-edit"></i></a>
                                                        @endif
                                                        @if($value->payment_type==0 && $value->bankTransfer!=null)
                                                            @php $bank_transfer = $value->bankTransfer @endphp
                                                            <a class="btn btn-sm btn-success show-tooltip"
                                                                href='{{ url("bank_transfer/$bank_transfer->id") }}'
                                                                title="Edit"><i class="fa fa-eye"></i></a>
                                                        @endif
                                                        <!-- @if (get_action_icons('reservation/{id}/delete', 'get'))
                                                            <form action="{{ route('reservation.destroy', $value->id) }}"
                                                                method="POST" style="display: initial;">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    style="height: 28px;"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </form>
                                                        @endif -->
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
        $('#reservation').addClass('active');
        $('#reservation_index').addClass('active');
    </script>
@stop
