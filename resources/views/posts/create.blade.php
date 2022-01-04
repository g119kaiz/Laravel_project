@extends('layouts.app')
@section('content')
<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>投稿画面</title>
    </head>
    <body>
        <h1>投稿画面</h1>
        <form action="/posts" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="text">
                <h2>文章</h2>
                <textarea name="post[text]" placeholder="Now I'm playing..."></textarea>
            </div>
            <div class="image">
                <h2>画像</h2>
                <input type="file" name="image" accept="image/png, image/jpeg"/>
            </div>
            <div class="game_id">
                <input type="hidden" name="post[game_id]" value="{{ $game_id }}">
            </div>
                <input type="hidden" name="post[user_id]" value="{{ Auth::user()->id }}">
                <input type="hidden" name="post[user_name]" value="{{ Auth::user()->name }}">
            <input type="submit" value="保存"/>
        </form>
         <div class="back">[<a href="/">back</a>]</div>
    </body>
</html>
@endsection
