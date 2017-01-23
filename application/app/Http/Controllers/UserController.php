<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{

    public function index()
    {
        throw new \Exception("My error");
        return array("OK");

        $object = new \stdClass();
        $object->property = "Here we go";
        return response()->json($object);
    }

    public function getAll()
    {
        return User::all();
    }

    public function getAllPosts()
    {
        return User::select('id', 'name', 'email')
            ->with(['posts' => function ($q) {
                $q->select('id', 'title', 'user_id')->active();
            }])
            ->get();
    }

    public function doLogin(Request $request){
        if (Auth::attempt(
            ['email' => $request->email,
                'password' => $request->password])) {
            return Auth::user();
        }else{
            throw new \Exception("Não foi possível realizar o login. Tente novamente.");
        }
    }

    public function doLogout()
    {
        Auth::logout();
        return Auth::user(); //tem q ser nulo
    }

    public function createLogin(Request $request)
    {
        $theUser = User::where('email', '=', $request->email)
            ->first();
        if ($theUser)
            throw new \Exception("Este email já está cadastrado");

       $user= User::create(['name'=>$request->name,'email'=> $request->email
            ,'contact'=> $request->contact,'avatar'=>'default.jpg',
            'password'=>bcrypt($request->password)]);

        Auth::login($user);
        return Auth::user();
    }
    public function getLogin(){
        return Auth::user();
    }



}
