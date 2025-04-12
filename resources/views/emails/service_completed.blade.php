<!DOCTYPE html>
<html>

<head>
    <title>Service Request Completed</title>
</head>

<body>
    <p>Dear {{ $client->name }},</p>
    <p>We are pleased to inform you that your service request for "{{ $serviceName }}" has been successfully completed.
    </p>
    <p>If you have any questions, feel free to contact us.</p>
    <p>Thank you for choosing our service!</p>
    <p>Best regards,<br> {{ env('APP_NAME') }}</p>
</body>

</html>
