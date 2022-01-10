<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Notification;
use App\Models\Client;
use App\Models\Trip;
use Illuminate\Http\Request;

use Validator;

class ReservationController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->get_privilege();
    }

    public function index()
    {
        $reservations = Reservation::latest()->get();

        $this->updateReservationViewed();
        
        return view('reservation.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reservation = null;
        $clients = Client::all();
        $trips = Trip::all();
        return view('reservation.form', compact('reservation', 'clients', 'trips'));
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
            'client_id' => 'required',
            'trip_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $reservation = new Reservation();
        $reservation->fill($request->all());
        $reservation->save();

        $this->sendNotification($reservation);

        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/reservation');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('reservation.index', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $clients = Client::all();
        $trips = Trip::all();
        return view('reservation.form', compact('reservation', 'clients', 'trips'));
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
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $reservation = Reservation::findOrFail($id);
        $reservation->fill($request->all());
        $reservation->save();

        $this->sendNotification($reservation);

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/reservation');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);
        $reservation->delete();

        return redirect()->back();
    }

    private function sendNotification($reservation){
        $client = Client::where('id', $reservation->client_id)->first();
        $notification = null;
        $title = null;
        $body = null;

        if($reservation->status == 1){
            $title = 'اضافة الطلب';
            $body = 'تم اضافة طلبك بنجاح سيتم مراجعة الطلب والتواصل معكم فى اقرب وقت ممكن.';
            $notification = array("title" => $title, "body" => $body);

        }elseif($reservation->status == 2){
            $title = 'قبول الطلب';
            $body = 'تم قبول طلبك بنجاح يمكنك الان مراجعة طلبك فى حجوزاتى وسيتم التواصل معكم قبيل الرحله مباشر.';
            $notification = array("title" => $title, "body" => $body);
        }else{
            $title = 'الغاء الطلب';
            $body = 'تم الغاء طلبكم يرجى محاولت اضافة الرحله مره اخرى او التواصل مع الاداره من خلال الارقام الموضحه فى التطبيق للاستفسار عن اسباب عدم قبول الطلب.';
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

    private function updateReservationViewed(){
        $reservations = Reservation::where('viewed', 0)->get();
        if(isset($reservations) && $reservations!=null){
            foreach($reservations as $reservation){
                $reservation->viewed = 1;
                $reservation->save();
            }
        }

        return true;
    }

}
