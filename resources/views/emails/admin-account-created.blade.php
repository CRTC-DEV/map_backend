<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .credentials {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .login-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 15px 0;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Admin Account Created</h2>
        </div>
        
        <div class="content">
            <p>Hello {{ $name }},</p>
            
            <p>Your admin account has been successfully created. Below are your login credentials:</p>
            
            <div class="credentials">
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
            </div>
            
            <p>You can access your account by clicking the button below:</p>
            
            <a href="{{ config('app.url') }}/web-login" class="login-button">Login to Admin Panel</a>
            
            <p>Or by visiting this URL in your browser:</p>
            <p>{{ config('app.url') }}/web-login</p>
            
            <p>Please login to your account and change your password immediately for security reasons.</p>
            
            <p>If you did not request this account, please contact the system administrator.</p>
        </div>

        <div class="footer">
            <p>This is an automated message from your system.</p>
        </div>
    </div>
</body>
</html> 