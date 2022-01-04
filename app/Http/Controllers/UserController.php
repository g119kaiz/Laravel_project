<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Like;
use App\User;
use App\Post;

class UserController extends Controller
{
    public function userlist(User $user){
        return view('posts/userlist')->with([
            'users' => $user->getPaginateByLimit()
         ]);
    }
    public function userindex(int $id){
        $post = Post::where('user_id', $id)->get();
        $user = User::where('id', $id)->first();
        return view('posts/userindex')->with([
            'posts' => $post,
            'user' => $user
         ]);
    }
}