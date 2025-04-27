<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Placing Slip - {{ $client->full_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .meta-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section h2 {
            font-size: 18px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .details {
            margin-left: 20px;
        }

        .details p {
            margin: 5px 0;
        }

        .highlight {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="{{ public_path('assets/images/VfPHgMS4ndKGxFSTrjGZDZqL5kpgXpnj2hTAZ8vn.png') }}"
            style="width: 100%; max-width: 200px;">
        <div class="header">
            <h1>QUOTATION PLACING SLIP</h1>
        </div>

        <div class="meta-info">
            <div>
                <p><span class="highlight">Date:</span> {{ now() }}</p>
                <p><span class="highlight">To:</span> {{ $insurer->company_name }}</p>
            </div>
            <div>
                <p><span class="highlight">From:</span> {{ env('APP_NAME') }}</p>
                <p><span class="highlight">Subject:</span> Bind Cover Third Party Motor Insurance Policy</p>
            </div>
        </div>

        <div class="section">
            <h2>Client Details:</h2>
            <div class="details">
                <p><span class="highlight">Name of Insured:</span> {{ $client->full_name }}</p>
                <p><span class="highlight">Address:</span> {{ $client->address }}</p>
                <p><span class="highlight">Occupation:</span> TBA</p>
                <p><span class="highlight">Phone Number:</span> {{ $client->phone }}</p>
            </div>
        </div>

        <div class="section">
            <h2>Vehicle Details:</h2>
            <div class="details">
                <p><span class="highlight">Make & Model:</span> {{ $policyAssignment->vehicle_make }}</p>
                <p><span class="highlight">Year of Manufacture:</span> {{ $policyAssignment->vehicle_year }}</p>
                <p><span class="highlight">Chassis Number:</span> {{ $policyAssignment->vehicle_VIN }}</p>
                <p><span class="highlight">Registration Number:</span> {{ $policyAssignment->vehicle_reg_number }}</p>
                <p><span class="highlight">Vehicle Usage:</span> {{ ucfirst($policyAssignment->vehicle_use_type) }}</p>
            </div>
        </div>

        <div class="section">
            <h2>Insurance Details:</h2>
            <div class="details">
                <p><span class="highlight">Annual Premium:</span>
                    {{ $policyAssignment->cost . ' ' . strtoupper($policyAssignment->currency) }}</p>
                <p><span class="highlight">Period of Coverage:</span> {{ $policyAssignment->policy_duration_start }} -
                    {{ $policyAssignment->policy_duration_end }}</p>
            </div>
        </div>
    </div>
</body>

</html>
