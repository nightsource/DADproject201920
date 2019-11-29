<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;


use App\Http\Resources\User as UserResource;
use App\Http\Resources\Wallet as WalletResource;
use App\Http\Resources\Movement as MovementResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\User;
use App\Wallet;
use App\Movement;

class MovementControllerAPI extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return MovementResource::collection(Movement::paginate(25));
        } else {
            return MovementResource::collection(Movement::all());
        }
    }    

    public function show(Request $request, $id)
    {
        $movement = Movement::find($id);

        if($request == null || (($movement->wallet_id != $request->user()->id && $movement->transfer_wallet_id != $request->user()->id) && $request->user()->type != 'a'))
            return response()->json("404 Movement(s) not found", 404);

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

    public function getLatests(Request $request)
    {       
        if ($request->has('page')) {
            return MovementResource::collection(Movement::orderBy('id', 'desc')->take(30)->paginate(25));
        } else {
            return MovementResource::collection(Movement::orderBy('id', 'desc')->take(30)->get());
        }      
    }    

    //US 6 - can be adapted to future use
    public function registerIncomeByOperator(Request $request)
    {          
        $request->validate([
                'email' => 'required',
                'type_payment' => 'required|in:bt,c',
                'iban' => 'sometimes|regex:/^[A-Za-z]{2}[0-9]{23}+$/',
                'value' => 'required|min:0|max:5000'
            ]);
            
        $userwallet = Wallet::where('email', '=', $request->email)->first();
        
        //insert
        $movement = new Movement();        
        $movement->fill($request->all());

        $movement->wallet_id = $userwallet->id;
        $movement->category_id = 29;
        $movement->transfer = 0;
        $movement->start_balance = $userwallet->balance;
        $movement->end_balance = $userwallet->balance + $request->value;        
        $movement->type = 'i';      
        $movement->date = Carbon::now();    
                  
        $movement->save();

        //update wallet
        $userwallet->balance = $userwallet->balance + $request->value;
        $userwallet->save();
    }

    public function store(Request $request)
    {                
        $request->validate([
                'wallet_id' => 'required',
                'type' => 'required',
                'iban' => 'sometimes|regex:/^[A-Za-z]{2}[0-9]{23}+$/',
                'category' => 'required',
                'start_balance' => 'required',
                'end_balance' => 'required',
                'amount' => 'required|between:0.01,5000.00'
            ]);

        $photoname = NULL;
        if(!is_null($request->file('file')))
            $photoname = Storage::putFile('fotos', $request->file('file'));        
        
        $movement = new Movement();
        $movement->fill($request->all());
        $movement->save();
        return response()->json(new MovementResource($movement), 201);
    }
}
