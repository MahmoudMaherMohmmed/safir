<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Trip;
use App\Models\Country;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = $this->formatCategories(Category::get(), $request->lang);

        return response()->json(['categories' => $categories], 200);
    }

    private function formatCategories($categories, $lang){
        $categories_array = [];

        foreach($categories as $category){
            array_push($categories_array, [
                'id' => $category->id,
                'title' => isset($lang) && $lang!=null ? $category->getTranslation('title', $lang) : $category->title,
                'image' => url($category->image),
            ]);
        }

        return $categories_array;
    }

    public function categoryTrips(Request $request, $category_id, $country_id)
    {
        $lang = $request->lang;
        $trips = Trip::where('category_id', $category_id)
                        ->where('country_id', $country_id)
                        ->get();

        return response()->json(['trips' => $this->formatTrips($trips, $lang)], 200);
    }

    private function formatTrips($trips, $lang)
    {
        $trips_array = [];

        foreach($trips as $trip){
            array_push($trips_array, [
                'trip_id' => $trip->id,
                'trip_title' => isset($lang) && $lang!=null ? $trip->getTranslation('name', $lang) : $trip->name,
                'trip_description' => isset($lang) && $lang!=null ? $trip->getTranslation('description', $lang) : $trip->description,
                'trip_price' => $trip->price,
                'trip_start_date' => $trip->from,
                'trip_end_date' => $trip->to,
                'trip_duration' => $this->getTripDuration($trip->from, $trip->to),
                'trip_persons_count' => $trip->persons_count,
                'trip_image' => url($trip->image),
                'trip_images' => $this->tripImages($trip),
            ]);
        }

        return $trips_array;
    }

    private function getTripDuration($start_date, $end_date)
    {
        return CarbonPeriod::create($start_date, $end_date)->count();
    }

    private function tripImages($trip){
        $trip_images_array = [];
        $trip_images = $trip->images;

        if(isset($trip_images) && count($trip_images)>0){
            foreach($trip_images as $image){
                array_push($trip_images_array, url($image->image));
            }
        }

        return $trip_images_array;
    }
}