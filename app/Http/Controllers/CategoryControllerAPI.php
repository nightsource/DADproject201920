<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\Category as CategoryResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Category;
use App\Movement; 

class CategoryControllerAPI extends Controller
{  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      return CategoryResource::collection(Category::all());
        
    }     

    public function get(Request $request)
    {
       // return $request->category();
       return CategoryResource::collection(Category::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z ]+$/',
            'type' => 'required'

            ]);

            $category = new Category();
            $category->fill($request->all());
            $category->save();
            return response()->json(new CategoryResource($category), 201);
    }


}
