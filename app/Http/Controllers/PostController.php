<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\Game;
use App\Comment;
use App\Like;

class PostController extends Controller
{
 /**
 *  * Post一覧を表示する
 *   * 
 *     * @param Post Postモデル
 *     * @return array Postモデルリスト
 *      */
 public function index(Post $post)
 {
     $user_id = Auth::user()->id;
     $post = Post::where('user_id', $user_id)->orderBy('updated_at', 'DESC')->get(); //ログイン付けてないから0にしているけどいずれはuseridにする
     return view('posts/index')->with([
            'posts' => $post
         ]);
 }
 public function show(Post $post)
 {
     $replies = Comment::where('post_id', $post->id)->get();
	    return view('posts/show')->with([
	        'post'=> $post,
	        'replies'=> $replies
	     ]);
 }
 public function create(int $id)
 {
	    return view('posts/create')->with([
	            'game_id'=> $id
	        ]);
 }
 public function store(Request $request, Post $post)
 {
	    $input = $request['post'];
	    $file = $request->file('image');
	    if( $file ){
	       $path = Storage::disk('s3')->put('/', $file);
	       $post->image_path = Storage::disk('s3')->url($path);
	    }else{
	       $post->image_path = 'NULL';
	    }
	    $post->fav_count = '0';
	    $post->fill($input)->save();
	    return redirect('/posts/' . $post->id);
 }
 public function like(Request $request, Post $post, Like $like)
 {
    $user_id = Auth::user()->id;
    $review_id = $request->review_id; //2.投稿idの取得
    $already_liked = Like::where('user_id', $user_id)->where('post_id', $review_id)->first();
    $post = Post::where('id',$review_id)->first();
    $favcnt = $post->fav_count;
    if(!$already_liked){
        $favcnt++;
        $like->post_id = $review_id;
        $like->reply_id = 'NULL';
        $like->user_id = $user_id;
        $like->save();
    }else{
        $favcnt--;
        Like::where('user_id', $user_id)->where('post_id', $review_id)->delete();
    }
    $post->fav_count = $favcnt;
    $post->save();
    //5.この投稿の最新の総いいね数を取得
    $param = [
        'review_likes_count' => $favcnt,
    ];
    return response()->json($param); //6.JSONデータをjQueryに返す
 }
 public function gamelist(Game $game)
 {
     return view('posts/gamelist')->with([
            'games' => $game->getPaginateByLimit()
         ]);
 }
 public function gameindex(Game $game)
 {
     $post = Post::where('game_id',$game->id)->get();
     return view('posts/gameindex')->with([
            'posts' => $post,
            'game' => $game
         ]);
 }
}
