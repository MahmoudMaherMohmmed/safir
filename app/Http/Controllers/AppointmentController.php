<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Validator;

class AppointmentController extends Controller
{

    public function __construct()
    {
        $this->get_privilege();
    }

    public function index()
    {
        $appointments = Appointment::all();
        return view('appointment.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $appointment = null;
        $doctors = Doctor::all();

        return view('appointment.form', compact('appointment', 'doctors'));
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
            'doctor_id'      => 'required',
            'date_from'     => 'required',
            'date_to'     => 'required',
            'from'  => 'required',
            'to'     => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dates = CarbonPeriod::create($request->date_from, $request->date_to);
        if(isset($dates) && $dates!=null){
            $times = $this->getHoursBetweenPeriod($request->from, $request->to);
            foreach($dates as $date){
                if(isset($times) && count($times)>0){
                    foreach($times as $time){
                        $appointment = new Appointment();
                        $appointment->doctor_id = $request->doctor_id;
                        $appointment->date = $date->format('Y-m-d');
                        $appointment->from = date('H:i A', strtotime($time));
                        $appointment->to = date('H:i A', (strtotime($time) + 60*60) );
                        $appointment->save();
                    }
                }
            }
        }

        \Session::flash('success', trans('messages.Added Successfully'));

        return redirect('/appointment');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('appointment.index', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $doctors = Doctor::all();
        return view('appointment.form', compact('appointment', 'doctors'));
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
        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/appointment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::find($id);
        $appointment->delete();

        return redirect()->back();
    }

    private function getHoursBetweenPeriod($from, $to){
        $times = [];
        $tStart = strtotime($from);
        $tEnd = strtotime($to);
        $tNow = $tStart;

        while($tNow <= $tEnd){
            array_push($times, date('H:i',$tNow));
            $tNow = strtotime('+60 minutes',$tNow);
        }

        return $times;
    }
}
