<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policy Completed</title>
</head>

<body>
    <p>Dear {{ $client->full_name }},</p>
    <p>Your insurance policy is now complete. <br>Thank you for choosing SAFE Insurance Brokers! Kindly visit us on 2nd
        Street, Sinkor (adjacent Monroe Chicken) or call 0888669090 / 0775061697 to arrange document delivery.</p>
    <p>Thank you for choosing our services.</p>
    <p>Best regards,<br>{{ strtoupper(env('APP_NAME')) }}</p>
</body>

</html>
