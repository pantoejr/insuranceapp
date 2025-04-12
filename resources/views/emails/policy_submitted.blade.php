<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policy Submitted Alert</title>
</head>

<body>
    <p>Dear {{ $user->name }},</p>
    <p>Kindly note that there's a policy pending your approval on {{ env('APP_URL') }}.</p>
    <p>Best regards,<br>{{ strtoupper(env('APP_NAME')) }}</p>
</body>

</html>
