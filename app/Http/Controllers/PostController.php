<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;

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
     return view('posts/index')->with(['posts' => $post->getPaginateByLimit()]);
 }
 public function show(Post $post)
 {
     $replies = Post::where('parent_id', $post->id)->get();
	    return view('posts/show')->with([
	        'post'=> $post,
	        'replies'=> $replies
	     ]);
 }
 public function reply(Post $post){
     return view('posts/reply')->with(['post'=> $post]);
 }
 public function create()
 {
	    return view('posts/create');
 }
 public function store(Request $request, Post $post)
 {
	    $input = $request['post'];
	    $post->fill($input)->save();
	    if($request->input('parent_id')){
	       $post->parent_id = $request->input('parent_id');
	    }
	    $file = $request->file('image');
	    Storage::disk('s3')->put('/', $file);
	    return redirect('/posts/' . $post->id);
 }
}
