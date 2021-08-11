<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
<h2>Welcome To Booking.com, {{$user['name']}}</h2>
<br/>
Your registered email-id is {{$user['email']}} , Please click on the below link to verify your email account
<br/>
<a href="{{route('registerationmail',['token'=>$user->verifyuser->token])}}">Verify Email</a>
</body>

</html>