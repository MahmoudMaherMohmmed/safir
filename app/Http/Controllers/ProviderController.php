<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Repository\LanguageRepository;

use App\Models\Provider;
use Validator;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->get_privilege();
        $this->languageRepository    = $languageRepository;
    }

    public function index()
    {
        $providers = Provider::all();
        $languages = $this->languageRepository->all();
        return view('provider.index', compact('providers', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provider = null;
        $languages = $this->languageRepository->all();

        return view('provider.form', compact('provider', 'languages'));
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
            'image' => ''
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }
        }

        $provider = new Provider();
        $provider->fill($request->except('title'));
        foreach ($request->title as $key => $value) {
            $provider->setTranslation('title', $key, $value);
        }
        $provider->save();
        \Session::flash('success', trans('messages.has been deleted successfully'));
        return redirect('/provider');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $provider = Provider::findOrFail($id);
        $categorys = $provider->categories;
        //dd($categorys);
        return view('category.index', compact('provider', 'categorys'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $provider = Provider::findOrFail($id);
        $languages = $this->languageRepository->all();
        return view('provider.form', compact('provider', 'languages'));
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
            'image' => ''
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $provider = Provider::findOrFail($id);

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }
            // dd($provider->image);
            if ($provider->image) {
                $this->delete_image_if_exists(base_path('/uploads/provider/' . basename($provider->image)));
            }
        }

        $provider->fill($request->except('title'));
        foreach ($request->title as $key => $value) {
            $provider->setTranslation('title', $key, $value);
        }
        $provider->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/provider');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $provider = Provider::find($id);
        $provider->delete();

        return redirect()->back();
    }
}
