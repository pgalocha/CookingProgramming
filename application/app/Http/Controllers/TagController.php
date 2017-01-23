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
    public function index()
    {
        return Tag::get();
    }
    public function show($id)
    {
        return Tag::find($id);
    }
    public function save(Request $request){
        $tag = null;
        if ($request->id){ //edit
            $tag=Tag::find($request->id);
        }else{ //new
            $tag = new Tag();
        }
        $tag->title = $request->title;
        $tag->save();
        return $tag;
    }
    public function getAllwithPosts(){
        return Tag::select('id','title')
            ->with(['posts'=>function($q){
                $q->select('id','title')->active();
            }])
            ->get();
    }

}
