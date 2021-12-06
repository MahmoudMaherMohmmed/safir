@extends('template')
@section('page_title')
 {{ request()->filled('operator_id') || request()->filled('content_id') ? $pageTitle : trans('messages.Post.Post') }}
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-black">
                    <div class="box-title">
                        <h3><i class="fa fa-table"></i> @lang('messages.Post.Post')</h3>
                        <div class="box-tool">
                            <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                            <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="box-content">
                        <div class="btn-toolbar pull-right">
                            <div class="btn-group">
                                <a class="btn btn-circle show-tooltip" title="" href="{{url('post/create')}}" data-original-title="Add new record"><i class="fa fa-plus"></i></a>
                                <?php
                                $table_name = "posts";
                                // pass table name to delete all function
                                // if the current route exists in delete all table flags it will appear in view
                                // else it'll not appear
                                ?>
                                @include('partial.delete_all')
                            </div>
                        </div>
                        <br><br>
                        <div class="table-responsive">
                            <table id="dtcontent" class="table table-striped dt-responsive" cellspacing="0" width="100%">

                                <thead>
                                    <tr>
                                        <th style="width:18px"><input type="checkbox" id="check_all" data-table="{{ $table_name }}"></th>
                                        <th>@lang('messages.content')</th>
                                        <th>@lang('messages.published date')</th>
                                        <th>@lang('messages.Status')</th>
                                        <th>@lang('messages.url')</th>
                                        <th>@lang('messages.user')</th>
                                        <th >@lang('messages.action')</th>
                                    </tr>
                                </thead>

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
    $('#post').addClass('active');
    $('#post_index').addClass('active');
</script>

<script>
    window.onload = function() {
        $('#dtcontent').DataTable({
            "processing": true,
            "serverSide": true,
            // "search": {"regex": true},
            "ajax": {
            type: "GET",
            "url": "{!! url('post/allData?operator_id='.request('operator_id').'&content_id='.request('content_id')) !!}",
            "data":"{{csrf_token()}}"
            },
            columns: [
            {data: 'index', searchable: false, orderable: false},
            {data: 'content'},
            {data: 'published date'},
            {data: 'status'},
            {data: 'url'},
            {data: 'user'},
            {data: 'action', searchable: false}
            ]
            , "pageLength": 5
        });
    };
</script>
@stop
