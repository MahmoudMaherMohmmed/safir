<div id="rbt">
  @if(isset($_REQUEST['content_id']))
  <div class="form-group">
      <label for="textfield5" class="col-sm-3 col-lg-2 control-label">@lang('messages.content')<span class="text-danger">*</span></label>
      <div class="col-sm-9 col-lg-10 controls">
          <select  name="content_id" class="form-control chosen-rtl">
              <option id="category_{{ $_REQUEST['content_id'] }}" value="{{ $_REQUEST['content_id'] }}">{{ $_REQUEST['title']}}</option>
          </select>
      </div>
  </div>
  @else
  <div class="form-group">
      <label class="col-sm-3 col-lg-2 control-label">@lang('messages.content')<span class="text-danger">*</span></label>
      <div class="col-sm-9 col-lg-10 controls">
          {!! Form::select('content_id',$contents->pluck('title','id'),null,['class'=>'form-control chosen-rtl','required']) !!}
      </div>
  </div>
  @endif

  @if(!$rbt)
  <div class="row">
    <div class="col-md-2 col-md-offset-5">
      <button type="button" class="btn btn-success add_rbt_code"  name="button"> <i class="fa fa-plus"></i> @lang('messages.Rbts.Create New Item') </button>
    </div>
  </div>
  @endif

  @if($rbt)
    <div class="form-group">
        <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Operator.Operator')<span class="text-danger">*</span></label>
        <div class="col-sm-9 col-lg-10 controls">
          <select class="form-control chosen-rtl"  name="operator_id" required>
            @foreach($operators as $operator)
            <option value="{{$operator->id}}" @if($rbt) @if($rbt->operator_id == $operator->id) selected @endif @endif>{{$operator->name}}-{{$operator->country->title}}</option>
            @endforeach
          </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 col-lg-2 control-label">@lang('messages.rbt code') <span class="text-danger">*</span></label>
        <div class="col-sm-9 col-lg-10 controls">
            {!! Form::number('rbt_code',null,['placeholder'=>'rbt_code','class'=>'form-control','min'=>0 , 'required']) !!}
        </div>
    </div>

  @endif

</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        {!! Form::submit($buttonAction,['class'=>'btn btn-primary']) !!}
    </div>
</div>
