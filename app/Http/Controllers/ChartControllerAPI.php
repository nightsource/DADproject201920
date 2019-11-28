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
    public function index(Request $request)
    {
        $chart = new SampleChart;
        $chart->labels(['One', 'Two', 'Three']);
        $chart->labels(['One', 'Two', 'Three', 'Four']);
        $chart->dataset('My dataset', 'line', [1, 2, 3, 4]);
        $chart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);

        return view('sample_view', ['chart' -> $chart]);
    }    

    public function show(Request $request, $id)
    {
        $movement = Movement::find($id);

        if($request == null || (($movement->wallet_id != $request->user()->id && $movement->transfer_wallet_id != $request->user()->id) && $request->user()->type != 'a'))
            return response()->json("Movement not found", 404);

        return new MovementResource(Movement::find($id));
    }     

    public function get(Request $request)
    {       
        return MovementResource::collection(Movement::where('wallet_id', $request->user()->id)
                                            ->orWhere('transfer_wallet_id', $request->user()->id)
                                            ->orderBy('date', 'desc')
                                            ->get());        
    }        

    public function getIncome(Request $request)
    {       
        return MovementResource::collection(Movement::where('wallet_id', $request->user()->id)
                                            ->orderBy('date', 'desc')
                                            ->get());        
    }       

    public function getExpense(Request $request)
    {       
        return MovementResource::collection(Movement::where('transfer_wallet_id', $request->user()->id)
                                            ->orderBy('date', 'desc')
                                            ->get());        
    }
}
