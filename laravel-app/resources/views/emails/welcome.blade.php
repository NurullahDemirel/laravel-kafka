<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome Aboard!</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 30px;">
<div style="max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <h2 style="color: #2c3e50;">🎉 Welcome, {{ $email }}!</h2>

    <p style="font-size: 16px; color: #555;">
        We're excited to have you on board.
    </p>

    <p style="font-size: 16px; color: #555;">
        Thank you for joining us! You can get started by clicking the button below:
    </p>

    <a href="{{ url('/') }}" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">
        Go to App
    </a>

    <p style="margin-top: 30px; font-size: 14px; color: #999;">
        If you didn’t sign up for this account, you can safely ignore this email.
    </p>
</div>
</body>
</html>
