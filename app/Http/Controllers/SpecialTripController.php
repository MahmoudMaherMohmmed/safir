<?php

namespace App\Http\Controllers;

use App\Models\SpecialTrip;
use App\Models\Country;
use Illuminate\Http\Request;
use Validator;

class SpecialTripController extends Controller
{

    public function __construct()
    {
        $this->get_privilege();
    }

    public function index()
    {
        $special_trips = SpecialTrip::all();
        return view('special_trip.index', compact('special_trips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $special_trip = null;
        $countries = Country::all();

        return view('special_trip.form', compact('special_trip', 'countries'));
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
            'client_id'      => 'required',
            'country_id'     => 'required',
            'start_date'     => 'required',
            'days_count'  => 'required',
            'persons_count'     => 'required',
            'description' => 'required',
            'status' => 'requird'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        dd( $request->all() );
        SpecialTrip::create( $request->all() );

        \Session::flash('success', trans('messages.Added Successfully'));

        return redirect('/special_trip');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $special_trip = SpecialTrip::findOrFail($id);
        return view('special_trip.index', compact('special_trip'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $special_trip = SpecialTrip::findOrFail($id);
        $countries = Country::all();
        $clients = Client::all();
        return view('special_trip.form', compact('special_trip', 'countries'));
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
            'client_id'      => 'required',
            'country_id'     => 'required',
            'start_date'     => 'required',
            'days_count'  => 'required',
            'persons_count'     => 'required',
            'description' => 'required',
            'status' => 'requird'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/special_trip');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $special_trip = SpecialTrip::find($id);
        $special_trip->delete();

        return redirect()->back();
    }
}
