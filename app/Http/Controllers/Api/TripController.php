<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Trip;
use App\Models\Country;
use Illuminate\Http\Request;
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
}