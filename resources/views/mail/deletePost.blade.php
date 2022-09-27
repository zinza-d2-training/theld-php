<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
</head>
<body>
    <p><b>Dear {{ $data['user']->name }},</b></p>

    <p>Your Post has been deleted</p>
    <p>Post: {{ $data['post']->title }}</p>
</body>
</html>