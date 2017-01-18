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


}
