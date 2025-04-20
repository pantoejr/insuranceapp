<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $policyType->name }} Request</title>
</head>

<body>
    <p>Dear {{ $insurer->key_contact_person }}, </p>
    <p>Regarding the above subject, please find attached a placement slip for our client's vehicle to initiate motor
        insurance coverage, effective today {{ $policyAssignment->policy_duration_start }} till
        {{ $policyAssignment->policy_duration_end }}.</p>
    <p>We appreciate your prompt attention to this and look forward to receiving the documents soon</p>
    <p>Thank you, as always, for your cooperation.</p>
    <p>Best regards,<br>{{ strtoupper(env('APP_NAME')) }}</p>
</body>

</html>
