@extends('layouts.app')
@section('content')
<!DOCTYPE HTML>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Posts</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            $(function () {
                let replike = $('.replike-toggle');
                let likeReplyId;
                replike.on('click', function () { 
                let $this = $(this); 
                likeReplyId = $this.data('reply-id'); 
                console.log(likeReplyId);
                //ajax処理スタート
                $.ajax({
                headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
                url: '/replike', 
                type: 'POST',
                data: { 
                    'reply_id': likeReplyId 
                },
                dataType : 'json'
                })
                //通信成功した時の処理
                .done(function (data) {
                   if($this.attr('class') == 'far fa-heart replike-toggle'){
                        $this.removeClass('far fa-heart replike-toggle');
                        $this.addClass('fas fa-heart replike-toggle')
                        $this.css("color","red");
                   }else{
                        $this.removeClass('fas fa-heart replike-toggle');
                        $this.addClass('far fa-heart replike-toggle');
                        $this.css("color","gray");
                   }
                   $this.next('.like-counter').html(data.reply_likes_count);
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
        <div class="content">
            <div class="content__post">
                <h2>
		        <i class="fas fa-user-circle"></i>{{ $comment->user_name }}
		        </h2>
                <p>{{ $comment->text }}</p>
                @if( $comment->image_path != 'NULL' )
                    <img src="{{ $comment->image_path }}" width="200px"><br>
                @endif
                @if(!$comment->isLikedBy(Auth::user()))
                    <i class="far fa-heart replike-toggle" data-reply-id="{{$comment->id}}"></i>
                    <span class="like-counter">{{ $comment->fav_count }}</span>
                @else
                    <i class="fas fa-heart replike-toggle" style="color:red;" data-reply-id="{{$comment->id}}"></i>
                    <span class="like-counter">{{ $comment->fav_count }}</span>
                @endif
            </div>
            <form action="/posts/reply/id" method="POST">
                @csrf
                <input type="hidden" name="post[post_id]" value="NULL">
                <input type="hidden" name="post[parent_id]" value="{{$comment->id}}">
                <input type="submit" value="返信">
            </form>
        </div>
            <div class="replies">
                @foreach($replies as $reply)
                    <h1>&nbsp;|</h1>
                    <h2>
                    <i class="fas fa-user-circle"></i>{{ $reply->user_name }}
                    </h2>
                    <p>{{ $reply->text }}</p>
                    @if($reply->image_path != 'NULL')
                        <img src="{{ $reply->image_path }}" width="200px"><br>
                    @endif
                    <a href="/reply/{{ $reply->id }}">詳細へ</a>
                    @if(!$reply->isLikedBy(Auth::user()))
                        <i class="far fa-heart replike-toggle" data-reply-id="{{$reply->id}}"></i>
                        <span class="like-counter">{{ $reply->fav_count }}</span>
                    @else
                        <i class="fas fa-heart replike-toggle" style="color:red;" data-reply-id="{{$reply->id}}">
                        <span class="like-counter">{{ $reply->fav_count }}</span>
                    @endif
                    <form action="/posts/reply/id" method="POST">
                        @csrf
                        <input type="hidden" name="post[post_id]" value="NULL">
                        <input type="hidden" name="post[parent_id]" value="{{$reply->id}}">
                        <input type="submit" value="返信">
                    </form>
                @endforeach
            </div>
        <div class="footer">
            <a href="/">戻る</a>
        </div>
    </body>
</html>
@endsection