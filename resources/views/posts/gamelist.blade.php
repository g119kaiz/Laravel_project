<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>ゲームタイトル一覧</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    </head>
    <body>
	<h1>ゲームタイトル一覧</h1>
	<input type="text" id="search-text" placeholder="検索ワードを入力">
	<p id="titles">
	    @foreach ($games as $game)
	        <a href="games/{{$game->id}}">{{$game->title}}</a><br>
	    @endforeach
	</p>
        <div class='games'>
            <script>
                searchWord = function(){
                    document.getElementById("titles").innerHTML = '';
                    @foreach ($games as $game)
                    var str = '{{$game->title}}';
                    var result = str.indexOf(document.getElementById('search-text').value);
                    if(result != -1){
                        document.getElementById("titles").innerHTML += '<a href="games/{{$game->id}}">{{$game->title}}</a><br>';
                    }
                    @endforeach
                }
                $('#search-text').on('input', searchWord);
            </script>
	    </div>
	<div class='paginate'>
            {{ $games->links() }}
    </div>
    </body>
</html>