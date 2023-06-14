<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Account</title>
</head>
<body>

    <b>Hello, {{\App\User::getFullName($user->id)}}</b>
    <p>Almost done, @ {{\App\User::getFullName($user->id)}}! To complete your TripsCon sign up, we just need to verify your email address: . <a href="http://tripsconpro.wantechsolutions.com/email/verification/{{$user->id}}/{{$token}}" target="_blank">Confirm Verification</a></p>

</body>
</html>
