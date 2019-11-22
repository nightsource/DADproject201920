

    <?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\Wallet as WalletResource;
use App\Http\Resources\Transaction as TransactionResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\User;
//use App\StoreUserRequest;
use Hash;

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
                'amount' => 'required',
                'type' => '',
                'source_description' => '',
                'iban' => ''
            ]);

        $user = User::find($request->email);

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
            $photoname = Storage::putFile('fotos', $request->file('file'));        
        
        $user = new User();
        $user->fill($request->all());
        $user->photo = $photoname;
        $user->password = Hash::make($user->password);
        $user->save();
        return response()->json(new UserResource($user), 201);
    }
}
