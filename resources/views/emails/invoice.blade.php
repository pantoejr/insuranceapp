<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_id }}</title>
</head>

<body>
    <p>Dear {{ $invoice->client->full_name }},</p>
    <p>Please find attached the invoice {{ $invoice->invoice_id }}.</p>
    <p>Thank you for your business.</p>
    <p>Best regards,<br>{{ strtoupper(env('APP_NAME')) }}</p>
</body>

</html>
