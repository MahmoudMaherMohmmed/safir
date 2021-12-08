<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = $this->formatCategories(Category::get(), $request->lang);

        return response()->json(['categories' => $categories]);
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
}