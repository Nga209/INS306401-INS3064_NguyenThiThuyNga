<?php
/**
 * Step 1: Account Information
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration - Step 1</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .box {
            background: #fff;
            padding: 30px;
            width: 360px;
            border-radius: 6px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }
        h2 { text-align: center; color: #2c3e50; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            background: #2c3e50;
            color: #fff;
            border: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Step 1: Account Info</h2>

    <form method="post" action="step2.php">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Next</button>
    </form>
</div>

</body>
</html>
