<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .receipt-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }

        .receipt-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .receipt-box table td {
            font-size: 14px;
            padding: 5px;
            vertical-align: top;
        }

        .receipt-box table tr td:nth-child(2) {
            font-size: 14px;
            text-align: right;
        }

        .receipt-box table tr.top table td {
            padding-bottom: 20px;
        }

        .receipt-box table tr.top table td.title {
            font-size: 14px;
            line-height: 45px;
            color: #333;
        }

        .receipt-box table tr.information table td {
            padding-bottom: 40px;
        }

        .receipt-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .receipt-box table tr.details td {
            padding-bottom: 20px;
        }

        .receipt-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .receipt-box table tr.item.last td {
            border-bottom: none;
        }

        .receipt-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="receipt-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ public_path('assets/images/VfPHgMS4ndKGxFSTrjGZDZqL5kpgXpnj2hTAZ8vn.png') }}"
                                    style="width: 100%; max-width: 200px;">
                            </td>
                            <td>
                                Receipt #: {{ $payment->id }}<br>
                                Date: {{ date('Y-m-d', strtotime($payment->payment_date)) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                {{ strtoupper($systemName) }}<br>
                                {{ $systemAddress }}<br>
                                {{ $systemEmail }}<br>
                                {{ $systemPhone }}
                            </td>
                            <td>
                                {{ $payment->invoice->client->full_name }}<br>
                                {{ $payment->invoice->client->address }}<br>
                                {{ $payment->invoice->client->phone }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Payment Method</td>
                <td>Amount</td>
            </tr>
            <tr class="details">
                <td>{{ ucfirst($payment->payment_method) }}</td>
                <td>{{ $payment->amount_paid }}</td>
            </tr>
            <tr class="heading">
                <td>Invoice ID</td>
                <td>Payment Reference</td>
            </tr>
            <tr class="item">
                <td>{{ $payment->invoice_id }}</td>
                <td>{{ $payment->payment_reference }}</td>
            </tr>
            <tr class="total">
                <td></td>
                <td>Total: {{ $payment->amount_paid }}</td>
            </tr>
        </table>
        <p style="text-justify:auto; font-size:14px;">{{ $payment->notes }}</p>
    </div>
</body>

</html>
