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
	    return view('posts/show')->with(['post'=> $post]);
 }
 public function create()
 {
	    return view('posts/create');
 }
 public function store(Request $request, Post $post)
 {
	    $input = $request['post'];
	    $post->fill($input)->save();
	    $file = $request->file('image');
	    Storage::disk('s3')->put('/', $file);
	    return redirect('/posts/' . $post->id);
 }
}
