<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
class DepartmentControllerAPI extends Controller
{
    //
    public function get(){
        $departments = Department::all();

        return response()->json($departments);
    }
}
