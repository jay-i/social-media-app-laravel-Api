<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Mail</title>
</head>
<body>
    <h1>Email : {{ $email }}</h1>
    <p>Password Reset Link : <a href="{{ $url }}">Click To Change Password</a></p>
</body>
</html>