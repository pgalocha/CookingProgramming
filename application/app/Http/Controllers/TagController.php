<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;
class TagController extends Controller
{
// ... code ...
    public function getAll(){
        return Tag::select('id','title')->get();
    }

    public function getAllwithPosts(){
        return Tag::select('id','title')
            ->with(['posts'=>function($q){
                $q->select('id','title')->active();
            }])
            ->get();
    }

}
