<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policy Approved</title>
</head>

<body>
    <p>Dear {{ $client->full_name }},</p>
    <p>We are pleased to inform you that your policy has been approved. You can come to pick it up at your convenience.
    </p>
    <p>Please find attached the invoice for your policy.</p>
    <p>Thank you for choosing our services.</p>
    <p>Best regards,<br>{{ strtoupper(env('APP_NAME')) }}</p>
</body>

</html>
