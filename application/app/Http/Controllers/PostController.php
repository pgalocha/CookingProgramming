<?php

namespace App\Http\Controllers;

 use Illuminate\Http\Request;

use App\Http\Requests;
 use App\Http\Controllers\Controller;
 use App\Post;

class PostController extends Controller
{
    // Retorna uma quantidade de posts em ordem cronológica

    public function last($n=3)
    {
        return Post::select('id','title', 'text','active','user_id')
            ->with(['tags'=>function($q){
                $q->select('id','title');
            }])
            ->with(['comments'=>function($q){
                $q->active()->select('active','post_id');
            }])
            ->with(['user'=>function($q){
                $q->select('id','name','email');
            }])
            ->orderBy('id', 'desc')
            ->take($n)
            ->get();
    }

    public function index()
    {
        return Post::get();
    }
    public function getTitles()
    {
        return Post::select('id','title')->get();
    }
}
