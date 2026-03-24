<?php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ thống quản lý</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            padding: 40px;
        }

        h1 {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: 0.3s;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .desc {
            font-size: 14px;
            color: #666;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .footer {
            text-align: center;
            color: white;
            margin-top: 30px;
            font-size: 13px;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <h1>🚀 Hệ thống quản lý CRUD</h1>

    <div class="grid">

        <a href="students/index.php">
            <div class="card">
                <div class="icon">🎓</div>
                <div class="title">Sinh viên</div>
                <div class="desc">Quản lý thông tin sinh viên</div>
            </div>
        </a>

        <a href="courses/index.php">
            <div class="card">
                <div class="icon">📚</div>
                <div class="title">Khóa học</div>
                <div class="desc">Tạo và quản lý khóa học</div>
            </div>
        </a>

        <a href="enrollments/index.php">
            <div class="card">
                <div class="icon">📝</div>
                <div class="title">Đăng ký học</div>
                <div class="desc">Liên kết sinh viên với khóa học</div>
            </div>
        </a>
</div>

    <div class="footer">
        © <?= date('Y') ?> | PHP + MySQL
    </div>

</div>

</body>
</html>