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
}