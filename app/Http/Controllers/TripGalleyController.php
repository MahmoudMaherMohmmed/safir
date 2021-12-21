<?php

namespace App\Http\Controllers;

use App\Models\TripGalley;
use Illuminate\Http\Request;
use App\Http\Services\UploaderService;
use Illuminate\Http\UploadedFile;

class TripGalleyController extends Controller
{
    /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'trips_gallery';
    /**
     * @var UploaderService
     */
    private $uploaderService;

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(UploaderService $uploaderService)
    {
        $this->get_privilege();
        $this->uploaderService = $uploaderService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                $trip_gallery = new TripGalley();
                $trip_gallery->image = $this->handleFile($request->image);
                $trip_gallery->trip_id = $request->trip_id;
                $trip_gallery->save();
            }
        }

        \Session::flash('success', trans('messages.Added Successfully'));
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TripGalley  $tripGalley
     * @return \Illuminate\Http\Response
     */
    public function show(TripGalley $tripGalley)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TripGalley  $tripGalley
     * @return \Illuminate\Http\Response
     */
    public function edit(TripGalley $tripGalley)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TripGalley  $tripGalley
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TripGalley $tripGalley)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TripGalley  $tripGalley
     * @return \Illuminate\Http\Response
     */
    public function destroy(TripGalley $tripGalley)
    {
        //
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
