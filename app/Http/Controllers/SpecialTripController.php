<?php

namespace App\Http\Controllers;

use App\Models\SpecialTrip;
use App\Models\Notification;
use App\Models\Country;
use App\Models\Client;
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
        $special_trips = SpecialTrip::latest()->get();

        $this->updateSpecialTripViewed();
        
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
        $clients = Client::all();

        return view('special_trip.form', compact('special_trip', 'countries', 'clients'));
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
            'client_id'  => 'required',
            'country_id' => 'required',
            'start_date' => 'required',
            'days_count' => 'required',
            'persons_count' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $special_trip = SpecialTrip::create( $request->all() );

        $this->sendNotification($special_trip);

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
        return view('special_trip.form', compact('special_trip', 'countries', 'clients'));
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
            'start_date'     => 'required',
            'days_count'  => 'required',
            'persons_count'     => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $special_trip = SpecialTrip::find($id);
        $special_trip->start_date = $request->start_date;
        $special_trip->days_count = $request->days_count;
        $special_trip->persons_count = $request->persons_count;
        $special_trip->description = $request->description;
        $special_trip->status = $request->status;
        $special_trip->save();

        $this->sendNotification($special_trip);
        
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

    private function sendNotification($special_trip){
        $client = Client::where('id', $special_trip->client_id)->first();
        $notification = null;
        $title = null;
        $body = null;

        if($special_trip->status == 0){
            $title = 'اضافة طلب البرنامج الخاص';
            $body = 'تم اضافة طلبك بنجاح سيتم مراجعة الطلب والتواصل معكم فى اقرب وقت ممكن.';
            $notification = array("title" => $title, "body" => $body);
        
        }elseif($special_trip->status == 1){
            $title = 'قبول طلب البرنامج الخاص';
            $body = 'تم قبول طلبك بنجاح يمكنك الان مراجعة طلبك فى طلباتى الخاصة وسيتم التواصل معكم لمناقشة برنامج الرحلة الخاصه بيكم.';
            $notification = array("title" => $title, "body" => $body);
        
        }else{
            $title = 'الغاء البرنامج الخاص';
            $body = 'تم الغاء برنامجكم الخاص يرجى محاولت اضافة برنامج اخر او التواصل مع الاداره من خلال الارقام الموضحه فى التطبيق للاستفسار عن اسباب عدم قبول البرنامج.';
            $notification = array("title" => $title, "body" => $body);
        }
        
        if(isset($client) && $client!=null){
            sendNotification($client->device_token, $notification);
            $this->saveNotifications($client->id, $title, $body);
        }

        return true;
    }

    private function saveNotifications($client_id, $title, $body){
        $notification = new Notification();
        $notification->client_id = $client_id;
        $notification->title = $title;
        $notification->body = $body;
        $notification->save();

        return true;
    }

    private function updateSpecialTripViewed(){
        $special_trips = SpecialTrip::where('viewed', 0)->get();
        if(isset($special_trips) && $special_trips!=null){
            foreach($special_trips as $special_trip){
                $special_trip->viewed = 1;
                $special_trip->save();
            }
        }

        return true;
    }
}
