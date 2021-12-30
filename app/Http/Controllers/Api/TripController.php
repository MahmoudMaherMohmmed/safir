<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Trip;
use App\Models\Country;
use App\Models\SpecialTrip;
use App\Models\Reservation;
use App\Models\Bank;
use App\Models\BankTransfer;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\UploaderService;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class TripController extends Controller
{
    /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'bank_transfers';
    
    public function __construct(UploaderService $uploaderService)
    {
        $this->uploaderService = $uploaderService;
    }

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
                'country' => isset($lang) && $lang!=null ? $trip->country->getTranslation('title', $lang) : $trip->country->title,
                'category' => isset($lang) && $lang!=null ? $trip->category->getTranslation('title', $lang) : $trip->category->title,
            ];
        }

        return $trip_array;
    }

    public function clientCurrentReservations(Request $request){
        $client_id = $request->user()->id;
        $reservations_array = [];

        $reservations = Reservation::where('client_id', $client_id)->get();
        if(isset($reservations) && $reservations!=null){
            foreach($reservations as $reservation){
                if((isset($reservation->trip) && $reservation->trip!=null) && $reservation->trip->to >= date('Y-m-d'))
                {
                    array_push($reservations_array, $this->formatMyReservationTrip($reservation, $request->lang));
                }
            }
        }

        return response()->json(['reservations' => $reservations_array], 200);
    }

    public function clientFinishedReservations(Request $request){
        $client_id = $request->user()->id;
        $reservations_array = [];

        $reservations = Reservation::where('client_id', $client_id)->where('status', '!=', 1)->get();
        if(isset($reservations) && $reservations!=null){
            foreach($reservations as $reservation){
                if((isset($reservation->trip) && $reservation->trip!=null) && $reservation->trip->to < date('Y-m-d'))
                {
                    array_push($reservations_array, $this->formatMyReservationTrip($reservation, $request->lang));
                }
            }
        }

        return response()->json(['reservations' => $reservations_array], 200);
    }

    private function formatMyReservationTrip($reservation, $lang)
    {
        $trip_array = [];
        $trip = $reservation->trip;
 
        if(isset($trip) && $trip!=null){
            $trip_array = [
                'trip_id' => $reservation->id,
                'trip_title' => isset($lang) && $lang!=null ? $trip->getTranslation('name', $lang) : $trip->name,
                'trip_description' => isset($lang) && $lang!=null ? $trip->getTranslation('description', $lang) : $trip->description,
                'trip_price' => $trip->price,
                'trip_start_date' => $trip->from,
                'trip_end_date' => $trip->to,
                'trip_duration' => $this->getTripDuration($trip->from, $trip->to),
                'trip_persons_count' => $trip->persons_count,
                'trip_image' => url($trip->image),
                'trip_images' => $this->tripImages($trip),
                'status' => $reservation->status,
                'payment_type' => $reservation->payment_type,
                'country' => isset($lang) && $lang!=null ? $trip->country->getTranslation('title', $lang) : $trip->country->title,
                'category' => isset($lang) && $lang!=null ? $trip->category->getTranslation('title', $lang) : $trip->category->title,
            ];
        }

        return $trip_array;
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

        $special_trip = SpecialTrip::create( array_merge($request->all(), ['client_id' => $request->user()->id]) );

        $this->sendSpecialTripNotification($special_trip);

        return response()->json(['message' => 'Your request registered successfully.'], 200);
    }

    public function reserveTrip(Request $request){
        $Validated = Validator::make($request->all(), [
            'trip_id' => 'required',
            'payment_type' => 'required',
            'image'      => 'max:65536'
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $trip = Trip::where('id', $request->trip_id)->first();
        if(isset($trip) && $trip!=null){
            $reservation = new Reservation();
            $reservation->client_id = $request->user()->id;
            $reservation->fill($request->only('trip_id', 'payment_type'));
            if($reservation->save()){
                if($reservation->payment_type == 0){
                    $this->saveBankTransfer($request, $reservation->id);
                }

                $this->sendReservationNotification($reservation);

                return response()->json(['message' => 'appointment reserved successfully.'], 200);
            }else{
                return response()->json(['message' => 'an error occurred.'], 200);
            }  
        }else{
            return response()->json(['message' => 'This trip is not in out system.'], 200);
        }
    }

    public function specialTripClientCurrentReservations(Request $request){
        $client_id = $request->user()->id;
        $special_trips_array = [];

        $special_trips = specialTrip::where('client_id', $client_id)->get();
        if(isset($special_trips) && $special_trips!=null){
            foreach($special_trips as $trip){
                if($this->specialTripEndDate($trip) >= date('Y-m-d')){
                    array_push($special_trips_array, [
                        'id' => $trip->id,
                        'start_date' => $trip->start_date,
                        'duration' => $trip->days_count,
                        'persons_count' => $trip->persons_count,
                        'status' => $trip->status,
                        'country' => isset($lang) && $lang!=null ? $trip->country->getTranslation('title', $lang) : $trip->country->title,
                        'category' => isset($lang) && $lang!=null && $lang=='ar' ? 'رحلات خاصة' : 'Special Trip',
                    ]);
                }
            }
        }

        return response()->json(['special_trips' => $special_trips_array], 200);
    }

    public function specialTripClientFinishedReservations(Request $request){
        $client_id = $request->user()->id;
        $special_trips_array = [];

        $special_trips = specialTrip::where('client_id', $client_id)->where('status', '!=', 1)->get();
        if(isset($special_trips) && $special_trips!=null){
            foreach($special_trips as $trip){
                if($this->specialTripEndDate($trip) < date('Y-m-d')){
                    array_push($special_trips_array, [
                        'id' => $trip->id,
                        'start_date' => $trip->start_date,
                        'duration' => $trip->days_count,
                        'persons_count' => $trip->persons_count,
                        'status' => $trip->status,
                        'country' => isset($lang) && $lang!=null ? $trip->country->getTranslation('title', $lang) : $trip->country->title,
                        'category' => isset($lang) && $lang!=null && $lang=='ar' ? 'رحلات خاصة' : 'Special Trip',
                    ]);
                }
            }
        }

        return response()->json(['special_trips' => $special_trips_array], 200);
    }

    private function specialTripEndDate($trip){
        return Carbon::parse($trip->start_date)->addDays($trip->days_count)->format('Y-m-d');
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

    private function sendSpecialTripNotification($special_trip){
        $client = Client::where('id', $special_trip->client_id)->first();
        
        if(isset($client) && $client!=null){
            sendNotification($client->device_token, array(
                "title" => "اضافة طلب البرنامج الخاص",
                "body" => "تم اضافة طلبك بنجاح سيتم مراجعة الطلب والتواصل معكم فى اقرب وقت ممكن"
                ) 
            );
        }

        return true;
    }

    private function sendReservationNotification($reservation){
        $client = Client::where('id', $reservation->client_id)->first();
        
        
        if(isset($client) && $client!=null){
            sendNotification($client->device_token, array(
                "title" => 'اضافة الطلب', 
                "body" => "تم اضافة طلبك بنجاح سيتم مراجعة الطلب والتواصل معكم فى اقرب وقت ممكن"
              )
            );
        }

        return true;
    }

    public function countries(Request $request){
        $countries_ids = Trip::groupBy('country_id')->pluck('country_id');

        return response()->json(['countries' => $this->formatCountries($countries_ids, $request->lang)], 200);
    }

    private function formatCountries($countries_ids, $lang)
    {
        $countries_array = [];

        foreach($countries_ids as $id){
            $country = Country::where('id', $id)->first();
            if(isset($country) && $country!=null){
                array_push($countries_array,[
                    'id' => $country->id,
                    'title' => isset($lang) && $lang!=null ? $country->getTranslation('title', $lang) : $country->title,
                ]);
            }
        }

        return $countries_array;
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