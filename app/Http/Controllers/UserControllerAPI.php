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

class UserControllerAPI extends Controller
{
    public function index(Request $request)
    {
        /*if ($request->has('page')) {
            return UserResource::collection(User::paginate(10));
        } else */
            return UserResource::collection(User::all());
        
    }     

    public function show(Request $request, $id)
    {        
        return $request->user()->id == $id || $request->user()->type == 'a' ? new UserResource(User::find($id)) : response()->json("404 User not found", 404);        
    }

    public function get(Request $request)
    {
        return $request->user();
    }

    public function store(Request $request)
    {                
        $request->validate([
                'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
                'email' => 'required|email|unique:users,email',
                'type' => '',
                'photo' => '',
                'nif' => ''
            ]);

        $photoname = NULL;
        if(!is_null($request->file('file')))
        $photoname  = Storage::putFile('public/fotos', $request->file('file'));      
              
        
        $user = new User();
        $user->fill($request->all());
        $user->photo = $photoname;      
        $user->password = Hash::make($user->password);
        $user->save();
        
        if($user->type == 'u') {
            $wallet = new Wallet();
            $wallet->id = $user->id;        
            $wallet->email = $user->email;
            $wallet->balance = 0;        
            $wallet->save();
        }

        return response()->json(new UserResource($user), 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'required|email|unique:users,email,'.$id,
            'type' => 'required'
        ]);
        $user = User::findOrFail($id);
        $user->fill($request->all());
        $user->password = Hash::make($request->password);
        $user->update();
        return response()->json($user, 200);
        // return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }

    public function emailAvailable(Request $request)
    {
        $totalEmail = 1;
        if ($request->has('email') && $request->has('id')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->where('id', '<>', $request->id)->count();
        } else if ($request->has('email')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->count();
        }
        return response()->json($totalEmail == 0);
    }
}
