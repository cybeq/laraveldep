<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{

    public function __construct(){
        $this->middleware('verified');
    }

    public function addComment(Request $request){
        $comment = new comment;
        $comment->body = $request->input('body');
        $comment->user_id = Auth::user()->id;
        $comment->photo_id =$request->id;
        $comment->save();
        return back();
    }

    public function getComments($photo_id){
        $comments = DB::table('comments')->select()
            ->where('photo_id', $photo_id)
            ->get()->toArray();
        return $comments;
    }

    public function deleteCommentById(Request $request){
       $owner = DB::table('photos')->where('id', $request->photo_id)
            ->select('user_id')->get()->first();

       if($owner->user_id==Auth::user()->id) {
           DB::table('comments')->where('id', $request->id)
               ->delete();
           return back();
       }else return abort(404);

    }
    public function visitorDeleteCommentById(Request $request){
        if($request->user_id == Auth::user()->id){
           DB::table('comments')->where('id', $request->id)->delete();
           return back();
        }else return abort(404);
    }

    public function deleteCommentByIdByCommentator(Request $request){

    }
}
