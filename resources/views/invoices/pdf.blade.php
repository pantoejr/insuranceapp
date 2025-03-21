<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ public_path('assets/images/VfPHgMS4ndKGxFSTrjGZDZqL5kpgXpnj2hTAZ8vn.png') }}"
                                    style="width: 100%; max-width: 300px;">
                            </td>
                            <td>
                                Invoice #: {{ $invoice->invoice_id }}<br>
                                Created: {{ date('Y-m-d', strtotime($invoice->created_at)) }}<br>
                                Due: {{ date('Y-m-d', strtotime($invoice->due_date)) }}
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
                                {{ strtoupper(env('APP_NAME')) }}<br>
                                2nd Street, Sinkor, Monrovia, Liberia<br>
                                +231 777 000 000
                            </td>
                            <td>
                                {{ $invoice->client->full_name }}<br>
                                {{ $invoice->client->address }}<br>
                                {{ $invoice->client->phone }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Item</td>
                <td>Cost</td>
            </tr>
            <tr class="item">
                <td>{{ $invoice->policy->name . ' (' . $invoice->policy->number . ' )' }}</td>
                <td>{{ $invoice->total_amount }}</td>
            </tr>
            <tr class="total">
                <td></td>
                <td>Total: {{ $invoice->total_amount }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
