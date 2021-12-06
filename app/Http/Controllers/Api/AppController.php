<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Massara;
use App\Models\Term;
use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;

class AppController extends Controller
{

    public function aboutMassara(Request $request){
        $massara = Massara::first();
        $about_massara = [];
        $lang = $request->lang;

        if(isset($massara) && $massara!=null){
            $about_massara = [
                'description' => isset($lang) && $lang!=null ? $massara->getTranslation('description', $lang) : $massara->description,
            ];
        }

        return response()->json(['massara' => $about_massara], 200);
    }

    public function center(Request $request){
        $center = Center::first();
        $center_info = [];
        $lang = $request->lang;

        if(isset($center) && $center!=null){
            $center_info = [
                'description' => isset($lang) && $lang!=null ? $center->getTranslation('description', $lang) : $center->description,
                'email' => $center->email,
                'contact_email' => $center->contact_email,
                "phone_1" => $center->phone_1,
                "phone_2" => $center->phone_2,
                "facebook_link" => $center->facebook_link,
                "whatsapp_link" => $center->whatsapp_link,
                "instagram_link" => $center->instagram_link,
                "lat" => $center->lat,
                "lng" => $center->lng,
                "logo" => url($center->logo),
            ];
        }

        return response()->json(['center' => $center_info], 200);
    }

    public function TermsAndConditions(Request $request){
        $term = Term::first();
        $terms_and_conditions = [];
        $lang = $request->lang;

        if(isset($term) && $term!=null){
            $terms_and_conditions = [
                'description' => isset($lang) && $lang!=null ? $term->getTranslation('description', $lang) : $term->description,
            ];
        }

        return response()->json(['terms_and_conditions' => $terms_and_conditions], 200);
    }

    public function contactMail(Request $request){
        $Validated = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $center = Center::first();
        if(isset($center) && $center!=null){
            $data = ['name'=>$request->name, 'subject'=>$request->subject, 'message_body'=>$request->message];
            $message = $request->message;
            Mail::send('mail', $data, function($message) use ($center, $request) {
                $message->to($center->contact_email, 'Massara')
                ->subject($request->subject)
                ->from('info@massara.com','Massara Contact Us');
             });
    
             return response()->json(['message' => 'Your Message Sent Successfully.'], 200);
        }else{
            return response()->json(['message' => 'No Contact Mail is configured.'], 403);
        }
        
    }
    
}
