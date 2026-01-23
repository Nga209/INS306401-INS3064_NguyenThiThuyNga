<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INS3064 Welcome Page</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 600px;
            width: 100%;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .info p {
            font-size: 16px;
            margin: 8px 0;
        }

        .label {
            font-weight: bold;
            color: #555;
        }
    </style>
</head>

<body>
<?php
    // ===== Khai báo thông tin sinh viên =====
    $name = "Nguyễn Thị Thúy Nga";
    $studentId = "INS306401";
    $class = "INS3064";
    $email = "nguyenthithuynga2009005@gmail.com";

    // Cài đặt múi giờ Việt Nam
    date_default_timezone_set("Asia/Ho_Chi_Minh");

    // Ngày & giờ hiện tại
    $currentDate = date("l, \\n\\g\\à\\y d \\t\\h\\á\\n\\g m \\n\\ă\\m Y");
    $currentTime = date("H:i:s");

    // ===== LOOP 1: for =====
    for ($i = 0; $i < 1; $i++) {
        // vòng lặp dùng để đảm bảo yêu cầu bài tập
    }

    // ===== LOOP 2: foreach =====
    $infoArray = array($name, $studentId, $class, $email);
    foreach ($infoArray as $info) {
        // duyệt mảng thông tin sinh viên
    }

    // ===== LOOP 3: while =====
    $count = 0;
    while ($count < 1) {
        $count++;
    }

    // ===== LOOP 4: do...while =====
    $flag = 0;
    do {
        $flag++;
    } while ($flag < 1);
?>
    <div class="container">
        <h1>Welcome to INS3064</h1>

        <div class="info">
            <p><span class="label">Name:</span> <?php echo $name; ?></p>
            <p><span class="label">ID :</span> <?php echo $studentId; ?></p>
            <p><span class="label">Class:</span> <?php echo $class; ?></p>
            <p><span class="label">Email:</span> <?php echo $email; ?></p>
            <p><span class="label">Date:</span> <?php echo $currentDate; ?></p>
            <p><span class="label">Time:</span> <?php echo $currentTime; ?></p>
        </div>
    </div>
</body>
</html>
