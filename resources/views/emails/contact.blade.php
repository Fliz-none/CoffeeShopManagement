<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ mới từ trang web</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #007bff; /* Đường viền trên cùng */
        }
        h1 {
            color: #333;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .info-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f0f8ff; /* Màu nền nhạt cho các khối thông tin */
            border-left: 5px solid #007bff; /* Đường viền bên trái */
        }
        p {
            line-height: 1.6;
            color: #555;
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thông tin liên hệ</h1>
        <div class="info-section">
            <p><strong>Tên:</strong> {{ $data['name'] }}</p>
            <p><strong>Email:</strong> {{ $data['email'] }}</p>
            <p><strong>Chủ đề:</strong> {{ $data['subject'] }}</p>
            <p><strong>Nội dung:</strong></p>
            <p>{{ $data['message'] }}</p>
        </div>
        <div class="footer">
            <p>Cảm ơn bạn đã liên hệ với chúng tôi!</p>
            <p>Chúng tôi sẽ phản hồi trong thời gian sớm nhất.</p>
        </div>
    </div>
</body>
</html>
