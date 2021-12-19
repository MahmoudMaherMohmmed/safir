<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Repository\LanguageRepository;
use App\Http\Services\UploaderService;
use Illuminate\Http\UploadedFile;

use Validator;

class MediaController extends Controller
{
    /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'media';
    /**
     * @var UploaderService
     */
    private $uploaderService;

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(LanguageRepository $languageRepository, UploaderService $uploaderService)
    {
        $this->get_privilege();
        $this->languageRepository    = $languageRepository;
        $this->uploaderService = $uploaderService;
    }

    public function index()
    {
        $media = Media::all();
        $languages = $this->languageRepository->all();
        return view('media.index', compact('media', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $media = null;
        $languages = $this->languageRepository->all();

        return view('media.form', compact('media', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|array',
            'title.*' => 'required|string',
            'video' => 'required',
            'image' => ''
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $media = new Media();
        $media->fill($request->except('title', 'video', 'ímage'));

        if ($request->video) {
            $media->video = $this->handleFile($request['video']);
        }

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            $media->image = $this->handleFile($request['image']);
        }

        foreach ($request->title as $key => $value) {
            $media->setTranslation('title', $key, $value);
        }
        
        $media->save();
        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/media');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $media = Media::findOrFail($id);
        return view('media.index', compact('media'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $media = Media::findOrFail($id);
        $languages = $this->languageRepository->all();
        return view('media.form', compact('media', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|array',
            'title.*' => 'required|string',
            'video' => '',
            'image' => ''
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $media = media::findOrFail($id);

        $media->fill($request->except('title', 'video', 'ímage'));

        if ($request->video) {
            if ($media->video) {
                $this->delete_image_if_exists(base_path('/uploads/media/' . basename($media->video)));
            }

            $media->video = $this->handleFile($request['video']);
        }

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            if ($media->image) {
                $this->delete_image_if_exists(base_path('/uploads/media/' . basename($media->image)));
            }

            $media->image = $this->handleFile($request['image']);
        }

        foreach ($request->title as $key => $value) {
            $media->setTranslation('title', $key, $value);
        }
        
        $media->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/media');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $media = Media::find($id);
        $media->delete();

        return redirect()->back();
    }

    /**
     * handle image file that return file path
     * @param File $file
     * @return string
     */
    public function handleFile(UploadedFile $file)
    {
        return $this->uploaderService->upload($file, self::IMAGE_PATH);
    }
}
