<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;


use App\Http\Resources\User as UserResource;
use App\Http\Resources\Wallet as WalletResource;
use App\Http\Resources\Movement as MovementResource;
use App\Charts\SampleChart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\User;
use App\Wallet;
use App\Movement;

class ChartControllerAPI extends Controller
{
    public function monthly(Request $request)
    {

        $sub = DB::table('movements')
        ->select(DB::raw('MAX(DATE)'))
        ->where('wallet_id', "=", $request->user()->id)
        ->where('date', ">", DB::raw('DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 12 MONTH) ,"%Y-%m-01")'))
        ->where('date', "<", DB::raw('DATE_FORMAT(NOW(), "%Y-%m-01")'))
        ->groupBy(DB::raw('YEAR(DATE)'), DB::raw('MONTH(DATE)'));      

        $chart = DB::table('movements')
        ->select(DB::raw("CONCAT(YEAR(DATE), ' ', MONTHNAME(DATE)) AS label"), 'VALUE AS data')
        ->whereIn('date', $sub)
        ->distinct()
        ->get();

        return $chart;
    }
    public function bank(Request $request)
    {
        $sub = DB::table('movements')
        ->select(DB::raw('MAX(DATE)'))
        ->where('wallet_id', "=", $request->user()->id)
        ->where('date', ">", DB::raw('DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 12 MONTH) ,"%Y-%m-01")'))
        ->where('date', "<", DB::raw('DATE_FORMAT(NOW(), "%Y-%m-01")'))
        ->groupBy(DB::raw('YEAR(DATE)'), DB::raw('MONTH(DATE)'));      

        $chart = DB::table('movements')
        ->select(DB::raw("CONCAT(YEAR(DATE), ' ', MONTHNAME(DATE)) AS label"), 'VALUE AS data')
        ->whereIn('date', $sub)
        ->distinct()
        ->get();

        return $chart;
    }

    public function incomeexpense(Request $request)
    {

        $chart = DB::table('movements')
        ->select(DB::raw("SUM(VALUE) AS value"), DB::raw("YEAR(DATE) AS year"), DB::raw("MONTH(DATE) AS month"), 
            DB::raw("CONCAT(YEAR(DATE), ' ', MONTHNAME(DATE)) AS label"), 'TYPE AS type')
        ->where('wallet_id', "=", $request->user()->id)
        ->where('date', ">", DB::raw('DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 12 MONTH) ,"%Y-%m-01")'))
        ->where('date', "<", DB::raw('DATE_FORMAT(NOW(), "%Y-%m-01")'))
        ->groupBy('year', 'month', 'label', 'type')   
        ->orderBy('year') 
        ->orderBy('month') 
        ->orderBy('type', 'desc') 
        ->get(); 

        return $chart;
    }
}
