@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{$user->name}}のホーム画面</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            $(function () {
                let like = $('.like-toggle'); 
                let likeReviewId;
                like.on('click', function () { 
                let $this = $(this);
                likeReviewId = $this.data('review-id');
                console.log(likeReviewId);
                //ajax処理スタート
                $.ajax({
                headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
                url: '/like',
                type: 'POST',
                data: { 
                    'review_id': likeReviewId 
                },
                dataType : 'json'
                })
                //通信成功した時の処理
                .done(function (data) {
                    if($this.attr('class') == 'far fa-heart like-toggle'){
                        $this.removeClass('far fa-heart like-toggle');
                        $this.addClass('fas fa-heart like-toggle')
                        $this.css("color","red");
                   }else{
                        $this.removeClass('fas fa-heart like-toggle');
                        $this.addClass('far fa-heart like-toggle');
                        $this.css("color","gray");
                   }
                   $this.next('.like-counter').html(data.review_likes_count);
                })
                //通信失敗した時の処理
                .fail(function () {
                console.log('fail'); 
                });
            });
            });
        </script>
    </head>
    <body>
	<h1>{{ $user->name }}のホーム画面</h1>
	<a href='/games'>ゲーム一覧</a>
	<a href='/'>ホームに戻る</a>
        <div class='posts'>
            @foreach ($posts as $post)
                <div class='post'>
		        	 <h2>
		                 <i class="fas fa-user-circle"></i><b>{{ $post->user_name }}</b>
		             </h2>
		            <p>{{$post->text}}</p>
		        @if ( $post->image_path != 'NULL' )
                    <img src="{{ $post->image_path }}" width="200px">
                @endif
                <a href='/posts/{{$post->id}}'>詳細へ</a>
                @if (!$post->isLikedBy(Auth::user()))
		            <i class="far fa-heart like-toggle" data-review-id="{{$post->id}}"></i>
			        <span class="like-counter">{{$post->fav_count}}</span>
			    @else
			        <i class="fas fa-heart like-toggle" style="color: red;" data-review-id="{{$post->id}}"></i>
			        <span class="like-counter">{{$post->fav_count}}</span>
			    @endif
                </div>
            @endforeach
	</div>

    </body>
</html>
@endsection