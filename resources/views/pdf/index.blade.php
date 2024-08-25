<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Tag</th>
            <th>Tag time</th>
        </tr>
        </thead>
        <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td>{{ $tag->user_id }}</td>
                    <td>{{ $tag->status }}</td>
                    <td>{{ $tag->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
