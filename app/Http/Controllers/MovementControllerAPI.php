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
use App\Category;

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
            return MovementResource::collection(Movement::orderBy('id', 'desc')->take(5)->paginate(5));
        } else {
            return MovementResource::collection(Movement::orderBy('id', 'desc')->take(5)->get());
        }      
    }    

    public function registerIncomeByOperator(Request $request)
    {          
        $request->validate([
                'email' => 'required',
                'type_payment' => 'required|in:bt,c',
                'iban' => 'sometimes|regex:/^[A-Z]{2}[0-9]{23}+$/',
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
                'iban' => 'sometimes|regex:/^[A-Z]{2}[0-9]{23}+$/',
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required',
            'category_id' => 'required',
            'type' => 'required'

        ]);
        $movement = Movement::findOrFail($id);
        $movement->fill($request->all());
        $movement->update();
        return response()->json($movement, 200);
    }

    public function registerInternalMovement(Request $request){

        $request->validate([
            'category_id' => 'required',
            'start_balance' => 'required',
            'end_balance' => 'required',
            'email' => 'required',
            'wallet_id' => 'required',
            'transfer_wallet_id' => 'required',
            'value' => 'required|between:0.01,5000.00'
        ]);
        $origWallet = Wallet::where('id', '=', $request->wallet_id)->first();
        $origWallet->balance = $request->end_balance;
        $destWallet = Wallet::where('id', '=', $request->transfer_wallet_id)->first();
        $destWalletBalance = $destWallet->balance;
        $value = $request->value;
        $destWallet->balance = $destWalletBalance + $value;
        $orig_mov = new Movement();
        $dest_mov = new Movement();
        $orig_mov->wallet_id = $request->wallet_id;
        $orig_mov->type = 'e';
        $orig_mov->transfer = 1;
        $orig_mov->transfer_wallet_id = $request->transfer_wallet_id;
        $orig_mov->category_id = $request->category_id;
        $orig_mov->description = $request->description;
        $orig_mov->date = Carbon::now();
        $orig_mov->start_balance = $request->start_balance;
        $orig_mov->end_balance = $request->end_balance;
        $orig_mov->value = $request->value;
        $orig_mov->type_payment = 'c';
        $dest_mov->wallet_id = $request->transfer_wallet_id;
        $dest_mov->type = 'i';
        $dest_mov->transfer = 1;
        $dest_mov->transfer_wallet_id = $request->wallet_id;
        $dest_mov->category_id = $request->category_id;
        $dest_mov->source_description = $request->description;
        $dest_mov->date = Carbon::now();
        $dest_mov->start_balance = $destWallet->balance;
        $dest_mov->end_balance = $destWallet->balance + $request->value;
        $dest_mov->value = $request->value;
        $dest_mov->type_payment = 'c';
        $orig_mov->save();
        $dest_mov->transfer_movement_id = $orig_mov->id;
        $dest_mov->save();
        $origWallet->save();
        $destWallet->save();
        return response()->json(new MovementResource($orig_mov), 201);
        // return response()->json($destWalletBalance);
    }

    public function registerExternalMovement(Request $request){
        $request->validate([
            'type' => 'required',
            'iban' => 'sometimes|regex:/^[A-Z]{2}[0-9]{23}+$/',
            'category_id' => 'required',
            'start_balance' => 'required',
            'end_balance' => 'required',
            'wallet_id' => 'required',
            'type_payment' => 'required',
            'value' => 'required|between:0.01,5000.00'
        ]);

        $wallet = Wallet::where('id', '=', $request->wallet_id)->first();
        $wallet->balance = $request->end_balance;
        $orig_mov = new Movement();
        $orig_mov->wallet_id = $request->wallet_id;
        $orig_mov->type = 'e';
        $orig_mov->transfer = 1;
        $orig_mov->category_id = $request->category_id;
        $orig_mov->description = $request->description;
        $orig_mov->type_payment = $request->type_payment;
        if($request->type_payment=='mb'){
            $orig_mov->mb_entity_code = $orig_mov->mb_entity_code;
            $orig_mov->mb_payment_reference = $orig_mov->mb_payment_reference;
        } else if($request->type_payment=='bt'){
            $orig_mov->iban = $request->iban;
        }
        $orig_mov->date = Carbon::now();
        $orig_mov->start_balance = $request->start_balance;
        $orig_mov->end_balance = $request->end_balance;
        $orig_mov->value = $request->value;
        $orig_mov->save();
        $wallet->save();
        return response()->json(new MovementResource($orig_mov), 201);
        // return response()->json($wallet, 201);
    }
}
/*
wallet_id
type
transfer
transfer_movement_id
transfer_wallet_id
type_payment
category_id
iban
mb_entity_code
mb_payment_reference
description
source_description
date
start_balance
end_balance
value */