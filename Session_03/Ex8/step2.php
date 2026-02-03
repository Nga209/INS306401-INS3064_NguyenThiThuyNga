<?php
/**
 * Step 2: Profile Information & Final Result
 */

// Get data from Step 1
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Check if final submission
$is_final = ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bio']));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration - Step 2</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .box {
            background-color: #ffffff;
            padding: 30px;
            width: 380px;
            border-radius: 6px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        textarea {
            resize: none;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            background-color: #2c3e50;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1f2d3a;
        }

        .result p {
            margin: 8px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="box">

<?php if ($is_final): ?>

    <h2>Registration Complete</h2>

    <div class="result">
        <p><strong>Username:</strong> <?= htmlspecialchars($_POST['username']) ?></p>
        <p><strong>Password:</strong> <?= htmlspecialchars($_POST['password']) ?></p>
        <p><strong>Bio:</strong> <?= htmlspecialchars($_POST['bio']) ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($_POST['location']) ?></p>
    </div>

    <!-- Back to Step 1 -->
    <form action="step1.php" method="get">
        <button type="submit">Back to Step 1</button>
    </form>

<?php else: ?>

    <h2>Step 2: Profile Info</h2>

    <form method="post">
        <!-- Hidden fields from Step 1 -->
        <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
        <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">

        <label>Bio</label>
        <textarea name="bio" rows="3" required></textarea>

        <label>Location</label>
        <input type="text" name="location" required>

        <button type="submit">Finish</button>
    </form>

<?php endif; ?>

</div>

</body>
</html>
