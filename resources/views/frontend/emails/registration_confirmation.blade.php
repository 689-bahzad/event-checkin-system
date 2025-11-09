<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
        }
        .qr-code {
            text-align: center;
            margin-top: 20px;
        }
        img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hi, {{ $registration->name }}!</h2>
        <p>Thank you for registering. Here are your registration details:</p>
        <div class="qr-code">
            <p>Your QR Code:</p>
            <img src="{{ $message->embed($defaultImagePath) }}" alt="QR Code">
            <img src="{{ $message->embed($qrCodeImagePath) }}" alt="QR Code">
        </div>
        <p>If you have any questions, feel free to contact us.</p>
        <p>Best regards,<br/>The Team</p>
    </div>
</body>
</html>
