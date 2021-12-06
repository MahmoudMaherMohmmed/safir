@extends('template')
@section('page_title')
{{ request()->filled('categoy_id')?  $categoryTitle : trans('messages.Content Type.Content') }}
@stop
@section('content')
<div class="row" style="margin-right: 0; margin-left: 0;">
  <div class="col-md-12">
    <div class="row">

      <div class="col-md-12">
        <div class="box box-black">
          <div class="box-title">
            <h3><i class="fa fa-table"></i> @lang('messages.Content Type.Content')</h3>
            <div class="box-tool">
              <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
              <a data-action="close" href="#"><i class="fa fa-times"></i></a>
            </div>
          </div>
          <div class="box-content">
            <div class="btn-toolbar pull-right">
              <div class="btn-group">
                @if (get_action_icons('content/create', 'get'))
                <a class="btn btn-circle show-tooltip" title="" href="{{url('content/create')}}" data-original-title="Add new record"><i class="fa fa-plus"></i></a>
                @endif
                <?php
                $table_name = "contents";
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
                    <th>id</th>
                    <th>@lang('messages.Title')</th>
                    <th>@lang('messages.Content Type.Content')</th>
                    <th>@lang('messages.Category.Category')</th>
                    <th>@lang('messages.Content Type.Content Type')</th>
                    <th>@lang('messages.Content Type.patch number')</th>
                    <th>@lang('messages.action')</th>
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
    $('#contents').addClass('active');
    $('#contents_index').addClass('active');

</script>

<script>
    window.onload = function() {
        $('#dtcontent').DataTable({
            "processing": true,
            "serverSide": true,
            // "search": {"regex": true},
            "ajax": {
            type: "GET",
            "url": "{!! url('content/allData?category_id='.request('category_id')) !!}",
            "data":"{{csrf_token()}}"
            },
            columns: [
            {data: 'index', searchable: false, orderable: false},
            {data: 'id'},
            {data: 'title'},
            {data: 'content'},
            {data: 'Category'},
            {data: 'content_type'},
            {data: 'patch number'},
            {data: 'action', searchable: false}
            ]
            , "pageLength": 10
        });
    };

    $(document).ajaxComplete(function() {
        $("audio").on("play", function() {
            $("audio").not(this).each(function(index, audio) {
                audio.pause();
            });
        });
    });
</script>
@stop
