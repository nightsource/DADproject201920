<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\Wallet as WalletResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Wallet;
use Hash;

class WalletControllerAPI extends Controller
{  
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return WalletResource::collection(Wallet::paginate(25));
        } else {
            return WalletResource::collection(Wallet::all());
        }
    }

    public function show(Request $request)
    {
        return new WalletResource(Wallet::firstOrFail($request->user()->id));
    }

    public function store($email)
    {                       
        $wallet = new Wallet();        
        $wallet->email = $email;
        $wallet->balance = 0;
        $wallet->save();

        return response()->json(new WalletResource($wallet), 201);
    }

    public function get(Request $request)
    {
        $wallet = Wallet::findOrFail($request->user()->id);

        return new WalletResource($wallet);
    }

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
