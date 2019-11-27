<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;


use App\Http\Resources\User as UserResource;
use App\Http\Resources\Wallet as WalletResource;
use App\Http\Resources\Transaction as TransactionResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\User;
use App\Wallet;
use App\Transaction;

class TransactionControllerAPI extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return TransactionResource::collection(Transaction::paginate(25));
        } else {
            return TransactionResource::collection(Transaction::all());
        }
    }    

    public function show($id)
    {
        return new TransactionResource(Transaction::find($id));
    }  

    //US 6 - can be adapted to future use
    public function registerIncomeByOperator(Request $request)
    {          
        $request->validate([
                'email' => 'required',
                'type_payment' => 'required|in:bt,c',
                'iban' => 'sometimes|regex:/^[A-Za-z]{2}[0-9]{23}+$/',
                'value' => 'required|numeric|between:0.01,5000.00'
            ]);
            
        $userwallet = Wallet::where('email', '=', $request->email)->first();
        
        //insert
        $transaction = new Transaction();        
        $transaction->fill($request->all());

        $transaction->wallet_id = $userwallet->id;
        $transaction->category_id = 29;
        $transaction->transfer = 0;
        $transaction->start_balance = $userwallet->balance;
        $transaction->end_balance = $userwallet->balance + $request->value;        
        $transaction->type = 'i';      
        $transaction->date = Carbon::now();    
                  
        $transaction->save();

        $userwallet->balance = $userwallet->balance + $request->value;
        $userwallet->save();
        return response()->json(new TransactionResource($transaction), 201);
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
        
        $transaction = new Transaction();
        $transaction->fill($request->all());
        $transaction->save();
        return response()->json(new TransactionResource($transaction), 201);
    }
}
