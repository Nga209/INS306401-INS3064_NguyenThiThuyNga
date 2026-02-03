<?php
/**
 * Sticky Form Example
 * Objective: Preserve form values when validation fails
 */

$errors = [];
$data = [
    'name'  => '',
    'email' => '',
];

/* Detect POST request */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get & sanitize input
    $data['name']  = trim($_POST['name'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $password      = $_POST['password'] ?? '';

    // Validation
    if ($data['name'] === '') {
        $errors[] = "Name is required.";
    }

    if ($data['email'] === '') {
        $errors[] = "Email is required.";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password is too short (minimum 8 characters).";
    }

    // Success (no errors)
    if (empty($errors)) {
        echo "<h2 style='text-align:center;color:green;'>Form submitted successfully!</h2>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sticky Form</title>
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

        .form-box {
            background: #ffffff;
            padding: 30px;
            width: 380px;
            border-radius: 6px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 12px;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        button {
            width: 100%;
            margin-top: 18px;
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

        .error-box {
            background: #fff3f3;
            border-left: 4px solid #d9534f;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 14px;
            color: #a94442;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Register</h2>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $error): ?>
                • <?= htmlspecialchars($error) ?><br>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <label>Name</label>
        <input type="text" name="name"
               value="<?= htmlspecialchars($data['name']) ?>">

        <label>Email</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($data['email']) ?>">

        <label>Password</label>
        <input type="password" name="password">

        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>
