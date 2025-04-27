<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policy Expiry Notification</title>
</head>

<body>
    <p>Dear {{ $client->full_name }},</p>
    @if ($isExpired)
        <p>We would like to inform you that your policy {{ $policy->policyType->name }} expired on
            {{ $policy->policy_duration_end }}.</p>
    @else
        <p>We would like to inform you that your policy {{ $policy->policyType->name }} is set to expire on
            {{ $policy->policy_duration_end }}.</p>
    @endif
    <p>Please contact us to renew your policy.</p>
    <p>Thank you for choosing our services.</p>
    <p>Best regards,<br>{{ strtoupper(env('APP_NAME')) }}</p>
</body>

</html>
