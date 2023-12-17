<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ForgotPasswordMail</title>
    <style>

    </style>
</head>
<body>
    <h1>Reset password</h1>
        <p>To reset your password click the following link (<span style="color:red;">IMPORTANT</span>: You only have ten minutes until expiration): </p>
        <a href='http://localhost:5173/resetPassword/{{$token}}' rel='noreferrer' referrerpolicy='origin' clicktracking='off'>Change your password</a>
</body>
</html>