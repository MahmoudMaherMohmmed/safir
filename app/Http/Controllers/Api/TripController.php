<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Trip;
use App\Models\Country;
use App\Models\specialTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class TripController extends Controller
{
    public function show(Request $request, $id)
    {
        $trip = Trip::where('id', $id)->first();

        return response()->json(['trip' => $this->formatTrip($trip, $request->lang)], 200);
    }

    private function formatTrip($trip, $lang)
    {
        $trip_array = [];

        if(isset($trip) && $trip!=null){
            $trip_array = [
                'id' => $trip->id,
                'title' => isset($lang) && $lang!=null ? $trip->getTranslation('name', $lang) : $trip->name,
                'description' => isset($lang) && $lang!=null ? $trip->getTranslation('description', $lang) : $trip->description,
                'price' => $trip->price,
                'start_date' => $trip->from,
                'end_date' => $trip->to,
                'duration' => $this->getTripDuration($trip->from, $trip->to),
                'persons_count' => $trip->persons_count,
                'image' => url($trip->image),
            ];
        }

        return $trip_array;
    }

    private function getTripDuration($start_date, $end_date)
    {
        return CarbonPeriod::create($start_date, $end_date)->count();
    }

    public function specialTrip(Request $request)
    {
        $Validated = Validator::make($request->all(), [
            'country_id' => 'required',
            'start_date' => 'required',
            'days_count' => 'required',
            'persons_count' => 'required',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403); 

        specialTrip::create( array_merge($request->all(), ['client_id' => $request->user()->id]) );

        return response()->json(['message' => 'Your request registered successfully.'], 200);
    }

    public function reserveAppointment(Request $request){
        $Validated = Validator::make($request->all(), [
            'trip_id' => 'required',
            'payment_type' => 'required',
            'image'      => 'max:65536'
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $reservation = new Reservation();
        $reservation->client_id = $request->user()->id;
        $reservation->fill($request->only('trip_id', 'payment_type'));
        if($reservation->save()){

            if($reservation->payment_type == 1){
                $this->saveBankTransfer($request, $reservation->id);
            }

            return response()->json(['message' => 'appointment reserved successfully.'], 200);
        }else{
            return response()->json(['message' => 'an error occurred.'], 200);
        }  
    }

    private function saveBankTransfer($request, $reservation_id){
        $bank = Bank::where('id', $request->bank_id)->first();

        if(isset($bank) && $bank!=null){
            $bank_transfer = New BankTransfer();
            $bank_transfer->reservation_id = $reservation_id;
            $bank_transfer->bank_name = $bank->name;
            $bank_transfer->bank_account_name = $bank->account_name;
            $bank_transfer->bank_account_number = $bank->account_number;
            $bank_transfer->IBAN = $bank->IBAN;
            $bank_transfer->image = $this->handleFile($request['image']);
            $bank_transfer->save();
        }

        return true;
    }

}