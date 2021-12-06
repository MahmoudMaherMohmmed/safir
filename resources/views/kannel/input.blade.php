<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.kannel.title') <span
            class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        {!! Form::text('title', null, ['placeholder' => '' . \Lang::get('messages.kannel.title') . '', 'class' => 'form-control btn-lg', 'required']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.kannel.url') <span
            class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        {!! Form::url('url', null, ['placeholder' => '' . \Lang::get('messages.kannel.url') . '', 'class' => 'form-control', 'required']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.kannel.excel_link')</label>
    <div class="col-sm-9 col-lg-10 controls">
        {!! Form::text('excel_link', null, ['placeholder' => '' . \Lang::get('messages.kannel.excel_link') . '', 'class' => 'form-control btn-lg']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.kannel.status')<span
            class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <div class="col-sm-9 col-lg-10 controls">
            {!! Form::select('status', ['1' => 'Active', '0' => 'Not Active'], null, ['class' => 'form-control chosen-rtl', 'required']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        {!! Form::submit($buttonAction, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
