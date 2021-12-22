@extends('template')
@section('page_title')
    @lang('messages.bank_transfers.bank_transfer_details')
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-black">
                        <div class="box-title">
                            <h3><i class="fa fa-table"></i> @lang('messages.bank_transfers.bank_transfer_details')</h3>
                        </div>
                        <div class="box-content">
                            <div class="table-responsive">
                                <table class="table table-striped dt-responsive" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td> @lang('messages.name') </td>
                                            <td> {{ $bank_transfer->reservation->client->name }} </td>
                                        </tr>
                                        <tr>
                                            <td>@lang('messages.trips.name')</td>
                                            <td> {{ $bank_transfer->reservation->trip->getTranslation('name', Session::get('applocale')) }} </td>
                                        </tr>
                                        <tr>
                                            <td> @lang('messages.bank_transfers.bank_name') </td>
                                            <td> {{ $bank_transfer->bank_name }} </td>
                                        </tr>
                                        <tr>
                                            <th> @lang('messages.bank_transfers.bank_account_name') </th>
                                            <td> {{ $bank_transfer->bank_account_name }} </td>
                                        </tr>
                                        <tr>
                                            <th> @lang('messages.bank_transfers.bank_account_number') </th>
                                            <td> {{ $bank_transfer->bank_account_number }} </td>
                                        </tr>
                                        <tr>
                                            <th> @lang('messages.bank_transfers.IBAN') </th>
                                            <td> {{ $bank_transfer->IBAN }} </td>
                                        </tr>
                                        <tr>
                                            <th> @lang('messages.bank_transfers.image') </th>
                                            <td> <img src="{{ url($bank_transfer->image) }}" /> </td>
                                        </tr>
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
        $('#bank_transfer').addClass('active');
        $('#bank_transfer_index').addClass('active');
    </script>
@stop
