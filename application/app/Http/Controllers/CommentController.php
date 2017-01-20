<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comment;

class CommentController extends Controller
{
    //

    public function last($n=3){
        return Comment::select('id','text','post_id')
            ->active()
            ->orderBy('id', 'desc')
            ->with(['post'=>function($q){
                $q->select('id','title');
            }])
            ->take($n)
            ->get();
    }

    public function getAll($n=100){
        return Comment::select('id','text','post_id','email')
            ->active()
            ->orderBy('id', 'desc')
            ->with(['post'=>function($q){
                $q->select('id','title');
            }])

            ->take($n)
            ->get();
    }

}
