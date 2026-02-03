<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $message = trim($_POST["message"] ?? "");

    $errors = [];

    if ($name === "") {
        $errors[] = "Name is required.";
    }
    if ($email === "") {
        $errors[] = "Email is required.";
    }
    if ($message === "") {
        $errors[] = "Message is required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
        }
        .box {
            width: 400px;
            margin: 80px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h3 {
            margin-top: 0;
        }
        .error {
            color: #c0392b;
        }
        .success {
            color: #27ae60;
        }
        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #2980b9;
        }
    </style>
</head>
<body>

<div class="box">
<?php
if (!empty($errors)) {
    echo "<h3 class='error'>Form Error</h3>";
    foreach ($errors as $error) {
        echo "<p>• $error</p>";
    }
    echo '<a href="contact.html">← Go back</a>';
} else {
    echo "<h3 class='success'>Thank you!</h3>";
    echo "<p><strong>Name:</strong> $name</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Message:</strong><br>$message</p>";
    echo '<a href="contact.html">← Back to form</a>';
}
?>
</div>

</body>
</html>