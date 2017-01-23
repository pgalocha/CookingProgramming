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
    public function getCommentsByPost($id){
        return Comment::select('*')
            ->where('post_id','=',$id)
            ->get();
    }
    public function save(Request $request){
        $comment = null;
        if ($request->id){ //edit
            $comment=Comment::find($request->id);
        }else{ //new
            $comment = new Comment();
        }
        $comment->text = $request->text;
        $comment->active = $request->active;
        $comment->email = $request->email;
        $comment->save();
        return $comment;
    }

}
