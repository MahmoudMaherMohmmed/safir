<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $media = Media::all();
        
        return response()->json(['media' => $this->formatMedia($media, $request->lang)], 200);
    }

    private function formatMedia($media, $lang)
    {
        $media_array = [];

        if(isset($media) && $media!=null){
            foreach($media as $video){
                array_push($media_array, [
                    'id' => $video->id,
                    'title' => isset($lang) && $lang!=null ? $video->getTranslation('title', $lang) : $video->title,
                    'views' => $video->views,
                    'video' => url($video->video),
                    'image' => url($video->image),
                    'created_at' => $video->created_at->diffForHumans(),
                ]);
            }
        }

        return $media_array;
    }

    public function updateViews(Request $request){
        $media = Media::where('id', $request->id)->first();

        if(isset($media) && $media!=null){
            $media->views = $media->views + 1;
            $media->save();
        }

        return response()->json(['views' => 'media views updated successfully.'], 200);
    }
}