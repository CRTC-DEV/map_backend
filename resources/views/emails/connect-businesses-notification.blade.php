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
            <h2>{{ $title }}</h2>
        </div>
        
        <div class="content">
            <p><strong>Action:</strong> {{ $action }}</p>
            <p><strong>Title:</strong> {{ $businessTitle }}</p>
            <p><strong>Modified By:</strong> {{ $modifiedBy }}</p>
            <p><strong>Date:</strong> {{ $date }}</p>
        </div>

        <div class="footer">
            <p>This is an automated notification from your system.</p>
        </div>
    </div>
</body>
</html> 