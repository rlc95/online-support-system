<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Support Ticket</title>
</head>
<body>
    <h1>Hello, {{ $customer->name }}!</h1>
    <h1>Reference Number: {{ $customer->ref }}!</h1>
    <p>Thank you for reaching out to support. Your ticket has been created successfully. Our team will get back to you shortly.</p>
    <p>If you need immediate assistance, please reply to this email.</p>
</body>
</html>