<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Repository\LanguageRepository;
use App\Http\Services\UploaderService;
use Illuminate\Http\UploadedFile;

use Validator;

class TripController extends Controller
{
    /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'trips';
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
        $trips = Trip::all();
        $languages = $this->languageRepository->all();
        return view('trip.index', compact('trips', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $trip = null;
        $categories = Category::all();
        $countries = Country::all();
        $languages = $this->languageRepository->all();

        return view('trip.form', compact('trip', 'categories', 'countries', 'languages'));
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
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'required|array',
            'description.*' => 'required|string',
            'price' => 'required',
            'from' => 'required',
            'to' => 'required',
            'persons_count' => 'required',
            'category_id' => 'required',
            'country_id' => 'required',
            'image' => ''
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $trip = new Trip();
        $trip->fill($request->except('name', 'description', 'ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            $trip->image = $this->handleFile($request['image']);
        }

        foreach ($request->name as $key => $value) {
            $trip->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $trip->setTranslation('description', $key, $value);
        }
        
        $trip->save();
        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/trip');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trip = Trip::findOrFail($id);
        return view('trip.index', compact('trip'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trip = Trip::findOrFail($id);
        $categories = Category::all();
        $countries = Country::all();
        $languages = $this->languageRepository->all();
        return view('trip.form', compact('trip', 'categories', 'countries', 'languages'));
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
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'required|array',
            'description.*' => 'required|string',
            'price' => 'required',
            'from' => 'required',
            'to' => 'required',
            'persons_count' => 'required',
            'category_id' => 'required',
            'country_id' => 'required',
            'image' => ''
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $trip = Trip::findOrFail($id);

        $trip->fill($request->except('name', 'description', 'ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            if ($trip->image) {
                $this->delete_image_if_exists(base_path('/uploads/trips/' . basename($trip->image)));
            }

            $trip->image = $this->handleFile($request['image']);
        }

        foreach ($request->name as $key => $value) {
            $trip->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $trip->setTranslation('description', $key, $value);
        }
        
        $trip->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/trip');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trip = Trip::find($id);
        $trip->delete();

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function gallery($id)
    {
        $trip = Trip::findOrFail($id);
        return view('trip.gallery', compact('trip'));
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
