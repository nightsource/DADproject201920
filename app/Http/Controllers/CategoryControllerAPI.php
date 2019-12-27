<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\Category as CategoryResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Category;

class CategoryControllerAPI extends Controller
{  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        return CategoryResource::collection(Category::all());
    }
}
