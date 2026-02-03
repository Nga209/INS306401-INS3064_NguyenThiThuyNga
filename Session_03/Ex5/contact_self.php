<?php
/**
 * Exercise 5: Self-Processing Contact Form
 * Pattern: Logic is handled at the top of the file, View is rendered below.
 */

$is_submitted = false;
$errors = [];
$data = [];

/* ===== Request Detection ===== */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize input data (Security Basics)
    $data['name']    = trim($_POST['full_name'] ?? '');
    $data['email']   = trim($_POST['email'] ?? '');
    $data['phone']   = trim($_POST['phone'] ?? '');
    $data['message'] = trim($_POST['message'] ?? '');

    /* ===== Validation Logic ===== */
    if (empty($data['name'])) {
        $errors[] = "Full name is required.";
    }
    if (empty($data['email'])) {
        $errors[] = "Email address is required.";
    }
    if (empty($data['message'])) {
        $errors[] = "Message content is required.";
    }

    // If no validation errors, mark submission as successful
    if (empty($errors)) {
        $is_submitted = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self-Processing Contact Form</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #6c757d;
            --bg-color: #f4f6f8;
            --border-color: #dee2e6;
            --success-color: #146c43;
            --error-color: #b02a37;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background-color: var(--bg-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background: #ffffff;
            padding: 35px;
            border-radius: 8px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: var(--primary-color);
        }

        .success-card {
            text-align: center;
        }

        .success-card p {
            color: #555;
            font-size: 14px;
        }

        .error-box {
            background: #f8f9fa;
            border-left: 4px solid var(--error-color);
            padding: 12px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #343a40;
            font-size: 14px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        textarea {
            resize: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            background-color: #1f2d3a;
        }

        a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
<?php if ($is_submitted): ?>
    <div class="success-card">
        <h2>Thank You!</h2>
        <p>Your information has been submitted successfully.</p>
        <p>
            We will contact <strong><?= htmlspecialchars($data['name']) ?></strong>
            via email: <?= htmlspecialchars($data['email']) ?>
        </p>
        <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">Submit another request</a>
    </div>
<?php else: ?>
    <h2>Contact Us</h2>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $error): ?>
                <div style="color: var(--error-color); font-size: 14px;">
                    • <?= htmlspecialchars($error) ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name"
                   value="<?= htmlspecialchars($data['name'] ?? '') ?>"
                   placeholder="John Doe">
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email"
                   value="<?= htmlspecialchars($data['email'] ?? '') ?>"
                   placeholder="email@example.com">
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone"
                   value="<?= htmlspecialchars($data['phone'] ?? '') ?>"
                   placeholder="+1 234 567 890">
        </div>

        <div class="form-group">
            <label>Message</label>
            <textarea name="message" rows="4"
                      placeholder="Enter your message here..."><?= htmlspecialchars($data['message'] ?? '') ?></textarea>
        </div>

        <button type="submit">Submit</button>
    </form>
<?php endif; ?>
</div>

</body>
</html>
