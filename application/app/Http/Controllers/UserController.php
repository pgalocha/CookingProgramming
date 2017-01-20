<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
class UserController extends Controller
{

    public function index()
    {
        throw new \Exception("My error");
        return array("OK");

        $object= new \stdClass();
        $object->property = "Here we go";
        return response()->json($object);
    }

    public function getAll(){
        return User::all();
    }

    public function getAllPosts()
    {
        return User::select('id','name','email')
            ->with(['posts'=>function($q){
       $q->select('id','title','user_id')->active();
    }])
        ->get();
    }


}
