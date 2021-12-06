<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index(Request $request)
    {
        $specialties = $this->formateSpecialties(Specialty::get(), $request->lang);

        return response()->json(['specialties' => $specialties]);
    }

    private function formateSpecialties($specialties, $lang){
        $specialties_array = [];

        foreach($specialties as $specialty){
            array_push($specialties_array, [
                'id' => $specialty->id,
                'title' => isset($lang) && $lang!=null ? $specialty->getTranslation('title', $lang) : $specialty->title,
                'description' => isset($lang) && $lang!=null ? $specialty->getTranslation('description', $lang) : $specialty->description,
                'image' => url($specialty->image),
                'doctors_count' => $specialty->doctors->count(),
                'doctors' => $this->formateDoctors($specialty, $lang),
            ]);
        }

        return $specialties_array;
    }

    public function specialty($id, Request $request){
        $specialty_data = [];
        $specialty = Specialty::where('id', $id)->first();

        if(isset($specialty) && $specialty!=null){
            $specialty_data = $this->formateSpecialty($specialty, $request->lang);
        }

        return response()->json(['specialty' => $specialty_data]);
    }

    private function formateSpecialty($specialty, $lang){
        $specialty_array = [
            'id' => $specialty->id,
            'title' => isset($lang) && $lang!=null ? $specialty->getTranslation('title', $lang) : $specialty->title,
            'description' => isset($lang) && $lang!=null ? $specialty->getTranslation('description', $lang) : $specialty->description,
            'image' => url($specialty->image),
            'doctors_count' => $specialty->doctors->count(),
            'doctors' => $this->formateDoctors($specialty, $lang),
        ];

        return $specialty_array;
    }

    private function formateDoctors($specialty, $lang){
        $doctors_array = [];

        $doctors_count = $specialty->doctors->count();

        if($doctors_count > 0){
            $doctors = $specialty->doctors;

            foreach($doctors as $doctor){
                array_push($doctors_array,[
                    'id' => $doctor->id,
                    'name' => isset($lang) && $lang!=null ? $doctor->getTranslation('name', $lang) : $doctor->name,
                    'subspecialty' => isset($lang) && $lang!=null ? $doctor->getTranslation('subspecialty', $lang) : $doctor->subspecialty,
                    'graduation_university' => isset($lang) && $lang!=null ? $doctor->getTranslation('graduation_university', $lang) : $doctor->graduation_university,
                    'image' => url($doctor->image),
                ]);
            }
        }

        return $doctors_array;
    }
}
