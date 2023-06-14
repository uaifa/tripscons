<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
</head>
<body>

<b>Hello, {{\App\User::getFullName($user->id)}}</b>
<p>You can reset your password by click Here. <a href="http://192.168.18.78:3000/forgot/password/{{$user->id}}/{{$token}}">Reset Password</a></p>

</body>
</html>
