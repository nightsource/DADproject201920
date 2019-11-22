<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\Wallet as WalletResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\User;
use Hash;

class WalletControllerAPI extends Controller
{  
    public function show($email)
    {
        return new WalletResource(Wallet::where('email', '=', $email)->firstOrFail());
    }

    public function store($email)
    {       
        //this is a automatic request from when a user is created                   
        $wallet = new Wallet();        
        $wallet->email = $email;
        $wallet->balance = 0;
        $wallet->save();

        return response()->json(new WalletResource($wallet), 201);
    }

    //duvida se a procura é por id ou por email
    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'balance' => 'required',
        ]);

        $wallet = Wallet::where('email', '=', $request->email)->firstOrFail();
        $wallet->update($request->all());
        return new WalletResource($wallet);
    }    
}
