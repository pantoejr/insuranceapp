<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Happy Birthday</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            color: #333333;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 18px;
            color: #666666;
        }

        .content {
            margin-top: 20px;
            font-size: 16px;
            color: #444444;
            line-height: 1.6;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            text-align: center;
            color: #999999;
        }

        .emoji {
            font-size: 24px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="emoji">🎉</div>
            <h1>Happy Birthday, {{ $client->full_name }}!</h1>
            <p>Wishing you a wonderful day</p>
        </div>
        <div class="content">
            <p>On behalf of our entire team, we wish you a day filled with joy, laughter, and unforgettable moments.</p>
            <p>Thank you for being a valued part of our community. We truly appreciate you!</p>
            <p>Have an amazing birthday!</p>
        </div>
        <div class="footer">
            {{ env('APP_NAME') }}
        </div>
    </div>
</body>

</html>
