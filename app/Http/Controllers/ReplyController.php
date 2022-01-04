<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Like;

class ReplyController extends Controller
{
 /**
 *  * Post一覧を表示する
 *   * 
 *     * @param Comment Commentモデル
 *     * @return array Commentモデルリスト
 *      */
 public function reply(Request $request){
     return view('posts/reply')->with([
            'post_id' => $request->input('post.post_id'),
            'parent_id'=> $request->input('post.parent_id')
         ]);
 }
 public function show(Comment $comment){
      $replies = Comment::where('parent_id', $comment->id)->get();
      return view('posts/reply_show')->with([
	         'comment'=> $comment,
	         'replies'=> $replies
	       ]);
 }
 public function store(Request $request, Comment $comment)
 {
	    $input = $request['post'];
	    $file = $request->file('image');
	    if($file){
	        $path = Storage::disk('s3')->put('/', $file);
	        $comment->image_path = Storage::disk('s3')->url($path);
	    }else{
	        $comment->image_path = 'NULL';
	    }
	    $comment->fav_count = '0';
	    $comment->fill($input)->save();
	    if($comment->parent_id == "NULL"){
	        return redirect('/posts/' . $comment->post_id);
	    }
	    return redirect('/reply/' . $comment->parent_id);
 }
 public function replike(Request $request, Comment $comment, Like $like)
 {
 	$user_id = Auth::user()->id;
    $reply_id = $request->reply_id; //2.投稿idの取得
    $already_liked = Like::where('user_id', $user_id)->where('reply_id', $reply_id)->first();
    $comment = Comment::where('id',$reply_id)->first();
    $favcnt = $comment->fav_count;
    if(!$already_liked){
        $favcnt++;
        $like->post_id = 'NULL';
        $like->reply_id = $reply_id;
        $like->user_id = $user_id;
        $like->save();
    }else{
        $favcnt--;
        Like::where('user_id', $user_id)->where('reply_id', $reply_id)->delete();
    }
    $comment->fav_count = $favcnt;
    $comment->save();
    //5.この投稿の最新の総いいね数を取得
    $param = [
        'reply_likes_count' => $favcnt,
    ];
    return response()->json($param); //6.JSONデータをjQueryに返す
 }
}