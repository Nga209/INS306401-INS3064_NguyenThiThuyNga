<?php
require_once 'utils.php';

function printResult($testName, $result) {
    return "
        <div class='row'>
            <span class='test-name'>{$testName}</span>
            <span class='badge " . ($result ? 'pass' : 'fail') . "'>
                " . ($result ? 'PASS' : 'FAIL') . "
            </span>
        </div>
    ";
}

/* ===== TEST DATA ===== */
$rawInput = " <b>Hello World</b> ";
$emailValid = "test@example.com";
$emailInvalid = "test@@mail";
$shortText = "Hi";
$validText = "Hello PHP";
$passwordWeak = "abc123";
$passwordStrong = "Pass@123";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Validation Library Test</title>
<style>
body {
    margin: 0;
    min-height: 100vh;
    background: #f1f5f9;
    font-family: system-ui, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
}

.card {
    background: #ffffff;
    width: 100%;
    max-width: 520px;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

h2 {
    margin-top: 0;
    text-align: center;
    color: #1e3a8a;
}

.section {
    margin-top: 25px;
}

.section h3 {
    margin-bottom: 10px;
    color: #334155;
    font-size: 16px;
}

.row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8fafc;
    padding: 10px 14px;
    border-radius: 6px;
    margin-bottom: 8px;
    font-size: 14px;
}

.test-name {
    color: #1f2937;
}

.badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 12px;
}

.pass {
    background: #dcfce7;
    color: #166534;
}

.fail {
    background: #fee2e2;
    color: #991b1b;
}
</style>
</head>

<body>

<div class="card">
    <h2>Validation Library Test</h2>

    <div class="section">
        <h3>Sanitize</h3>
        <?= printResult(
            "Sanitize removes HTML & spaces",
            sanitize($rawInput) === "Hello World"
        ); ?>
    </div>

    <div class="section">
        <h3>Email Validation</h3>
        <?= printResult("Valid email", validateEmail($emailValid)); ?>
        <?= printResult("Invalid email", !validateEmail($emailInvalid)); ?>
    </div>

    <div class="section">
        <h3>Length Validation</h3>
        <?= printResult("Too short string", !validateLength($shortText, 5, 20)); ?>
        <?= printResult("String within range", validateLength($validText, 5, 20)); ?>
    </div>

    <div class="section">
        <h3>Password Validation</h3>
        <?= printResult("Weak password", !validatePassword($passwordWeak)); ?>
        <?= printResult("Strong password", validatePassword($passwordStrong)); ?>
    </div>
</div>

</body>
</html>