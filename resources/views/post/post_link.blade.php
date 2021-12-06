<td>
    <input type="text"  id="url_h{{$post->id}}{{$post->operator->id}}" value="{{$post->url}}">
    <span class="btn">{{$post->operator->country->title}}-{{$post->operator->name}}</span>
    <span class="btn" onclick="x = document.getElementById('url_h{{$post->id}}{{$post->operator->id}}'); x.select();document.execCommand('copy')"> <i class="fa fa-copy"></i> </span>
    <br>
</td>
