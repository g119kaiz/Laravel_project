<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
	<h1>Blog Name</h1>
	[<a href='/posts/create'>投稿</a>]
        <div class='posts'>
            @foreach ($posts as $post)
                <div class='post'>
		    <h2 class='id'>
			<a href="posts/{{$post->id}}">詳細へ</a>
		    </h2>
		    <p class='user_id'>{{ $post->user_id }}</p>
		    <p class='text'>{{ $post->text}}</p>
                </div>
            @endforeach
	</div>
	<div class='paginate'>
            {{ $posts->links() }}
        </div>
    </body>
</html>
