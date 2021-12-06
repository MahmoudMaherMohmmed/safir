<td>
    @if ($content->type->id == $contentTypes::ADVANCED_TEXT)
        @foreach ($languages as $language)
            <ul>
                <li> <b>{{ $language->title }} :</b> {!! $content->getTranslation('path', $language->short_code) !!}</li>
            </ul>
        @endforeach
    @elseif($content->type->id == $contentTypes::NORMAL_TEXT)
        @foreach ($languages as $language)
            <ul>
                <li> <b>{{ $language->title }} :</b> {{ $content->getTranslation('path', $language->short_code) }}</li>
            </ul>
        @endforeach
    @elseif($content->type->id == $contentTypes::IMAGE)
        <img src="{{ $content->path }}" alt="" style="width:250px" height="200px">
    @elseif($content->type->id == $contentTypes::AUDIO)
        <audio controls src="{{ $content->path }}" style="width:100%"></audio>
    @elseif($content->type->id == $contentTypes::VIDEO)
        <video src="{{ $content->path }}" style="width:250px;height:200px" height="200px" controls
            poster="{{ $content->image_preview }}"></video>'
    @elseif($content->type->id == $contentTypes::YOUTUBVIDEO)
    
        <iframe src="{{ $content->path }}" width="250px" height="200px"></iframe>
    @elseif($content->type->id == $contentTypes::EXTERNALLINK)
        <a href="'.$content->path.'">{{ $content->path }}</a>
    @endif
</td>
