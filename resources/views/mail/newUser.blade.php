<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
</head>
<body>
    Your account has been created. 
    <a href="{{ route('auth.forgotPassword') }}">Click here to Reset your password and login</a>

    <h4>Your Account</h4>
    <p>Mail: <b>{{ $mailData['email'] }}</b></p>
    <p>Name: <b>{{ $mailData['name'] }}</b></p>
</body>
</html>