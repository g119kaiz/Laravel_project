<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
    </head>
    <body>
        <h1>Blog Name</h1>
        <form action="/posts" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="text">
                <h2>Body</h2>
                <textarea name="post[text]" placeholder="Now I'm playing..."></textarea>
            </div>
            <div class="image">
                <h2>Image</h2>
                <input type="file" name="image" accept="image/png, image/jpeg"/>
            </div>
            <input type="submit" value="保存"/>
        </form>
         <div class="back">[<a href="/">back</a>]</div>
    </body>
</html>

