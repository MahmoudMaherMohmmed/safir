<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Trip;
use App\Models\Country;
use App\Models\specialTrip;
use App\Models\Reservation;
use App\Models\Bank;
use App\Models\BankTransfer;
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

                return response()->json(['message' => 'appointment reserved successfully.'], 200);
            }else{
                return response()->json(['message' => 'an error occurred.'], 200);
            }  
        }else{
            return response()->json(['message' => 'This trip is not in out system.'], 200);
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