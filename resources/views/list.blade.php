<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fff; /* Change background to white */
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        table {
            width: 80%;
            margin: 20px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #000; /* Change header background to black */
            color: #fff; /* Change text color to white */
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.6);
        }

        a {
            color: #333;
            text-decoration: none;
        }
    </style>
</head>

<body class="antialiased">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>File Name</th>
                <th>URL</th>
                <th>Image</th>
                <th>Store In</th>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
                <tr>
                    <td>{{ $file->id }}</td>
                    <td>{{ $file->file_name }}</td>
                    <td>
                        <a href="{{ $file->url }}">{{ $file->url }}</a>
                    </td>
                    <td>
                        <img src="{{ $file->url }}" alt="image"
                            style="width: 128px; height: 128px; object-fit: cover">
                    </td>
                    <td>{{ $file->store_in }}</td>
                    <td>{{ $file->first_name }}</td>
                    <td>{{ $file->last_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>