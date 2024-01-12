<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>
<body class="antialiased">
    <form action="/upload" method="post" enctype="multipart/form-data">
        @csrf
        <label for="first"></label>
        <input type="text" id="first" name="first" placeholder="first name" /><br>
        <label for="last"></label>
        <input type="text" name="last" placeholder="first name" /><br>
        <input type="file" id="last" name="file"><br>
        <select name="store" id="">
            <option value="1" selected>Space</option>
            <option value="2">Block</option>
        </select>
        <button type="submit">Upload</button>
    </form>
</body>
</html>