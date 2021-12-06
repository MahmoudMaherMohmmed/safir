{{-- input category --}}
@include('content.select_category')

{{-- input Content Type --}}

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Content Type.Content Type')<span
            class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        {!! Form::select('content_type_id', $content_types->pluck('title', 'id'), null, ['class' => 'form-control chosen-rtl', 'id' => 'first_select', 'required']) !!}
    </div>
</div>

{{-- input Title --}}

<div class="form-group" id="cktextarea">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Title') <span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <ul id="myTab1" class="nav nav-tabs">
            <?php $i = 0; ?>
            @foreach ($languages as $language)
                <li class="{{ $i++ ? '' : 'active' }}"><a href="#title{{ $language->short_code }}"
                        data-toggle="tab">
                        {{ $language->title }}</a></li>
            @endforeach
        </ul>
        <div class="tab-content">
            <?php $i = 0; ?>
            @foreach ($languages as $language)
                <div class="tab-pane fade in {{ $i++ ? '' : 'active' }}" id="title{{ $language->short_code }}">
                    <input class="form-control" name="title[{{ $language->short_code }}]" value="@if ($content) {!! $content->getTranslation('title', $language->short_code) !!} @endif" />
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- input patch number --}}
<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Content Type.patch number') </label>
    <div class="col-sm-9 col-lg-10 controls">
        {!! Form::number('patch_number', null, ['placeholder' => 'Patch Number', 'class' => 'form-control', 'min' => 0]) !!}
    </div>
</div>

@if ($content)
    {{-- input advanced --}}
    @if ($content->type->id == 1)
        <div class="form-group" id="advanced">
            <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Content Type.Content') <span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-lg-10 controls">
                <ul id="myTab1" class="nav nav-tabs">
                    <?php $i = 0; ?>
                    @foreach ($languages as $language)
                        <li class="{{ $i++ ? '' : 'active' }}"><a href="#description{{ $language->short_code }}"
                                data-toggle="tab"> {{ $language->title }}</a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach ($languages as $language)
                        <div class="tab-pane fade in {{ $i++ ? '' : 'active' }}"
                            id="description{{ $language->short_code }}">
                            <textarea class="form-control col-md-12 ckeditor" id="ckeditor"
                                name="path[{{ $language->short_code }}]" rows="6">
                            @if ($content)
                            {!! $content->getTranslation('path', $language->short_code) !!}
                            @endif
                        </textarea>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @else

        <div class="form-group" hidden id="advanced">
            <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Content Type.Content') <span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-lg-10 controls">
                <ul id="myTab1" class="nav nav-tabs">
                    <?php $i = 0; ?>
                    @foreach ($languages as $language)
                        <li class="{{ $i++ ? '' : 'active' }}"><a href="#description{{ $language->short_code }}"
                                data-toggle="tab"> {{ $language->title }}</a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach ($languages as $language)
                        <div class="tab-pane fade in {{ $i++ ? '' : 'active' }}"
                            id="description{{ $language->short_code }}">
                            <textarea class="form-control col-md-12 ckeditor" id="ckeditor" disabled
                                name="path[{{ $language->short_code }}]" rows="6">
                            @if ($content)
                            {!! $content->getTranslation('path', $language->short_code) !!}
                            @endif
                        </textarea>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    {{-- input normal --}}

    @if ($content->type->id == 2)
        <div class="form-group" id="normal">
            <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Content Type.Content') <span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-lg-10 controls">
                <ul id="myTab1" class="nav nav-tabs">
                    <?php $i = 0; ?>
                    @foreach ($languages as $language)
                        <li class="{{ $i++ ? '' : 'active' }}"><a href="#path{{ $language->short_code }}"
                                data-toggle="tab"> {{ $language->title }}</a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach ($languages as $language)
                        <div class="tab-pane fade in {{ $i++ ? '' : 'active' }}"
                            id="path{{ $language->short_code }}">
                            <input class="form-control" name="path[{{ $language->short_code }}]" value="@if ($content) {!! $content->getTranslation('path', $language->short_code) !!} @endif" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="form-group" hidden id="normal">
            <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Content Type.Content') <span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-lg-10 controls">
                <ul id="myTab1" class="nav nav-tabs">
                    <?php $i = 0; ?>
                    @foreach ($languages as $language)
                        <li class="{{ $i++ ? '' : 'active' }}"><a href="#path{{ $language->short_code }}"
                                data-toggle="tab"> {{ $language->title }}</a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach ($languages as $language)
                        <div class="tab-pane fade in {{ $i++ ? '' : 'active' }}"
                            id="path{{ $language->short_code }}">
                            <input class="form-control" disabled name="path[{{ $language->short_code }}]"
                                value="@if ($content) {!! $content->getTranslation('path', $language->short_code) !!} @endif" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- input image --}}

    @if ($content->type->id == 3)
        <div class="form-group" id="image">
            <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Content Type.Content') <span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-md-8 controls">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                        @if ($content)
                            <img src="{{ $content->path }}" alt="" />
                        @else
                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                        @endif
                    </div>
                    <div class="fileupload-preview fileupload-exists img-thumbnail"
                        style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                    <div>
                        <span class="btn btn-file"><span class="fileupload-new">@lang('messages.select_image')</span>
                            <span class="fileupload-exists">Change</span>
                            {!! Form::file('path', ['accept' => 'image/*', 'class' => 'default']) !!}
                        </span>
                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    </div>
                </div>
                <span class="label label-important">NOTE!</span>
                <span>Only extensions supported png, jpg, and jpeg</span>
            </div>
        </div>
    @else
        <div class="form-group" hidden id="image">
            <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Content Type.Content') <span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-md-8 controls">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                        @if ($content)
                            <img src="{{ $content->path }}" alt="" />
                        @else
                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                        @endif
                    </div>
                    <div class="fileupload-preview fileupload-exists img-thumbnail"
                        style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                    <div>
                        <span class="btn btn-file"><span class="fileupload-new">@lang('messages.select_image')</span>
                            <span class="fileupload-exists">Change</span>
                            {!! Form::file('path', ['accept' => 'image/*', 'class' => 'default', 'disabled' => true]) !!}
                        </span>
                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    </div>
                </div>
                <span class="label label-important">NOTE!</span>
                <span>Only extensions supported png, jpg, and jpeg</span>
            </div>
        </div>
    @endif
    {{-- input audio --}}

    @if ($content->type->id == 4)
        <div class="form-group" id="audio">
            <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Content Type.Content') <span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-md-8 controls">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                        @if ($content)
                            <audio controls>
                                <source src="{{ $content->path }}">
                            </audio>
                        @endif
                    </div>
                    <div class="fileupload-preview fileupload-exists img-thumbnail"
                        style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                    <div>
                        <span class="btn btn-file"><span class="fileupload-new">Select Audio File</span>
                            <span class="fileupload-exists">Change</span>
                            {!! Form::file('path', ['accept' => 'audio/*', 'class' => 'default']) !!}
                        </span>
                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    </div>
                </div>
                <span class="label label-important">NOTE!</span>
                <span>Only extensions supported mp3</span>
            </div>
        </div>
    @else
        <div class="form-group" hidden id="audio">
            <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Content Type.Content') <span
                    class="text-danger">*</span></label>
            <div class="col-sm-9 col-md-8 controls">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                        @if ($content)
                            <audio controls>
                                <source src="{{ $content->path }}">
                            </audio>
                        @endif
                    </div>
                    <div class="fileupload-preview fileupload-exists img-thumbnail"
                        style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                    <div>
                        <span class="btn btn-file"><span class="fileupload-new">Select Audio File</span>
                            <span class="fileupload-exists">Change</span>
                            {!! Form::file('path', ['accept' => 'audio/*', 'class' => 'default', 'disabled' => true]) !!}
                        </span>
                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    </div>
                </div>
                <span class="label label-important">NOTE!</span>
                <span>Only extensions supported mp3</span>
            </div>
        </div>
    @endif
    {{-- input video --}}

    @if ($content->type->id == 5)
        <div id="video">
            <div class="form-group">
                <label class="col-sm-3 col-md-2 control-label">Image Preview</label>
                <div class="col-sm-9 col-md-8 controls">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                            @if ($content)
                                <img src="{{ $content->image_preview }}" alt="" />
                            @else
                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                            @endif
                        </div>
                        <div class="fileupload-preview fileupload-exists img-thumbnail"
                            style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                            <span class="btn btn-file"><span
                                    class="fileupload-new">@lang('messages.select_image')</span>
                                <span class="fileupload-exists">Change</span>
                                {!! Form::file('image_preview', ['accept' => 'image/*', 'class' => 'default']) !!}
                            </span>
                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                        </div>
                    </div>
                    <span class="label label-important">NOTE!</span>
                    <span>Only extensions supported png, jpg, and jpeg</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Content Type.Content') <span
                        class="text-danger">*</span></label>
                <div class="col-sm-9 col-md-8 controls">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                            @if ($content)
                                <video width="100%" height="100%" controls>
                                    <source src="{{ $content->path }}">
                                </video>
                            @endif
                        </div>
                        <div class="fileupload-preview fileupload-exists img-thumbnail"
                            style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                            <span class="btn btn-file"><span class="fileupload-new">Select Video File</span>
                                <span class="fileupload-exists">Change</span>
                                {!! Form::file('path', ['accept' => 'video/*', 'class' => 'default']) !!}
                            </span>
                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                        </div>
                    </div>
                    <span class="label label-important">NOTE!</span>
                    <span>Only extension supported mp4, flv, and 3gp</span>
                </div>


            </div>
        </div>
    @else
        <div hidden id="video">
            <div class="form-group">
                <label class="col-sm-3 col-md-2 control-label">@lang('messages.Image Preview')</label>
                <div class="col-sm-9 col-md-8 controls">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                            @if ($content)
                                <img src="{{ $content->image_preview }}" alt="" />
                            @else
                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                            @endif
                        </div>
                        <div class="fileupload-preview fileupload-exists img-thumbnail"
                            style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                            <span class="btn btn-file"><span
                                    class="fileupload-new">@lang('messages.select_image')</span>
                                <span class="fileupload-exists">Change</span>
                                {!! Form::file('image_preview', ['accept' => 'image/*', 'class' => 'default']) !!}
                            </span>
                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                        </div>
                    </div>
                    <span class="label label-important">NOTE!</span>
                    <span>Only extensions supported png, jpg, and jpeg</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Content Type.Content') <span
                        class="text-danger">*</span></label>
                <div class="col-sm-9 col-md-8 controls">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                            @if ($content)
                                <video width="100%" height="100%" controls>
                                    <source src="{{ $content->path }}">
                                </video>
                            @endif
                        </div>
                        <div class="fileupload-preview fileupload-exists img-thumbnail"
                            style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                            <span class="btn btn-file"><span class="fileupload-new">Select Video File</span>
                                <span class="fileupload-exists">Change</span>
                                {!! Form::file('path', ['accept' => 'video/*', 'class' => 'default', 'disabled' => true]) !!}
                            </span>
                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                        </div>
                    </div>
                    <span class="label label-important">NOTE!</span>
                    <span>Only extension supported mp4, flv, and 3gp</span>
                </div>


            </div>
        </div>
    @endif
    {{-- input external --}}

    @if ($content->type->id == 6)
        <div id="external">
            <div class="form-group">
                <label class="col-sm-3 col-md-2 control-label">@lang('messages.Image Preview')</label>
                <div class="col-sm-9 col-md-8 controls">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                            @if ($content)
                                <img src="{{ $content->image_preview }}" alt="" />
                            @else
                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                            @endif
                        </div>
                        <div class="fileupload-preview fileupload-exists img-thumbnail"
                            style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                            <span class="btn btn-file"><span
                                    class="fileupload-new">@lang('messages.select_image')</span>
                                <span class="fileupload-exists">Change</span>
                                {!! Form::file('image_preview', ['accept' => 'image/*', 'class' => 'default']) !!}
                            </span>
                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                        </div>
                    </div>
                    <span class="label label-important">NOTE!</span>
                    <span>Only extensions supported png, jpg, and jpeg</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Content Type.Content') <span
                        class="text-danger">*</span></label>
                <div class="col-sm-9 col-lg-10 controls">
                    {!! Form::text('path', null, ['placeholder' => trans('messages.Content Type.Content'), 'class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    @else
        <div hidden id="external">
            <div class="form-group">
                <label class="col-sm-3 col-md-2 control-label">@lang('messages.Image Preview')</label>
                <div class="col-sm-9 col-md-8 controls">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                            @if ($content)
                                <img src="{{ $content->image_preview }}" alt="" />
                            @else
                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                            @endif
                        </div>
                        <div class="fileupload-preview fileupload-exists img-thumbnail"
                            style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                            <span class="btn btn-file"><span
                                    class="fileupload-new">@lang('messages.select_image')</span>
                                <span class="fileupload-exists">Change</span>
                                {!! Form::file('image_preview', ['accept' => 'image/*', 'class' => 'default']) !!}
                            </span>
                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                        </div>
                    </div>
                    <span class="label label-important">NOTE!</span>
                    <span>Only extensions supported png, jpg, and jpeg</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">@lang('messages.Content Type.Content') <span
                        class="text-danger">*</span></label>
                <div class="col-sm-9 col-lg-10 controls">
                    {!! Form::text('path', null, ['placeholder' => trans('messages.Content Type.Content'), 'class' => 'form-control', 'disabled' => true]) !!}
                </div>
            </div>
        </div>
    @endif
@endif

{{-- buttonAction --}}
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        {!! Form::submit($buttonAction, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
