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
    <table>
        <tr>
            <td>First</td>
            <td>Last</td>
            <td>Image</td>
        </tr>
        @foreach($data as $info)
        <tr>
            <td>{{$info->first}}</td>
            <td>{{$info->last}}</td>
            <td>
                <img @if ($info->store =="2")
                src="/display/{{ $info->path }}"
                alt="Block Error"
                @else
                src="https://quiz4daroth.sgp1.digitaloceanspaces.com/{{ $info->path }}"
                alt="Spaces Error"
                @endif
                >
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>