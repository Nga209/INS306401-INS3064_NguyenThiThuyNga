<?php
session_start();

/* ====== TÀI KHOẢN MẪU ====== */
$correct_username = "admin";
$correct_password = "123456";

/* ====== KHỞI TẠO BỘ ĐẾM ====== */
if (!isset($_SESSION["attempts"])) {
    $_SESSION["attempts"] = 0;
}

$message = "";
$message_class = "";

/* ====== XỬ LÝ ĐĂNG NHẬP ====== */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (empty($username) || empty($password)) {
        $message = "Please fill in all required fields.";
        $message_class = "error";
    } else {
        if ($username === $correct_username && $password === $correct_password) {
            $message = "Login successful.";
            $message_class = "success";
            $_SESSION["attempts"] = 0;
        } else {
            $_SESSION["attempts"]++;
            $message = "Login failed. Attempt count: " . $_SESSION["attempts"];
            $message_class = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background-color: #f1f3f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background-color: #ffffff;
            padding: 30px;
            width: 320px;
            border-radius: 6px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #495057;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #2c3e50;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1f2d3a;
        }

        .message {
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
        }

        .error {
            color: #b02a37;
        }

        .success {
            color: #146c43;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>User Login</h2>

    <form method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>

    <?php if ($message): ?>
        <div class="message <?= $message_class ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
