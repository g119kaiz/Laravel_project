<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>ユーザー検索</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    </head>
    <body>
	<h1>ユーザー検索</h1>
	<input type="text" id="search-text" placeholder="検索ワードを入力">
	<p id="users">
	    @foreach ($users as $user)
	        <a href="users/{{$user->id}}">{{$user->name}}</a><br>
	    @endforeach
	</p>
        <div class='users'>
            <script>
                searchWord = function(){
                    document.getElementById("users").innerHTML = '';
                    @foreach ($users as $user)
                    var str = '{{$user->name}}';
                    var result = str.indexOf(document.getElementById('search-text').value);
                    if(result != -1){
                        document.getElementById("users").innerHTML += '<a href="users/{{$user->id}}">{{$user->name}}</a><br>';
                    }
                    @endforeach
                }
                $('#search-text').on('input', searchWord);
            </script>
	    </div>
	<div class='paginate'>
            {{ $users->links() }}
    </div>
    </body>
</html>