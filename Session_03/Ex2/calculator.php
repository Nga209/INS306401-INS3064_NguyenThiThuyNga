<?php
/**
 * Exercise 2: Arithmetic Calculator
 * Focus: Type Casting, Numeric Validation, Switch statement
 */

$result = null;
$error  = "";
$value1 = "";
$value2 = "";
$operator = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $value1   = $_POST["value1"] ?? "";
    $value2   = $_POST["value2"] ?? "";
    $operator = $_POST["operator"] ?? "";

    /* ===== Numeric Validation ===== */
    if ($value1 === "" || $value2 === "") {
        $error = "Both numeric values are required.";
    } elseif (!is_numeric($value1) || !is_numeric($value2)) {
        $error = "Please enter valid numeric values.";
    } else {
        /* ===== Type Casting ===== */
        $num1 = (float) $value1;
        $num2 = (float) $value2;

        /* ===== Arithmetic Logic ===== */
        switch ($operator) {
            case "add":
                $result = $num1 + $num2;
                break;
            case "subtract":
                $result = $num1 - $num2;
                break;
            case "multiply":
                $result = $num1 * $num2;
                break;
            case "divide":
                if ($num2 == 0) {
                    $error = "Division by zero is not allowed.";
                } else {
                    $result = $num1 / $num2;
                }
                break;
            default:
                $error = "Please select a valid operation.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Arithmetic Calculator</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --bg-color: #f4f6f8;
            --border-color: #dee2e6;
            --error-color: #b02a37;
            --success-color: #146c43;
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

        .calculator {
            background: #ffffff;
            padding: 30px;
            width: 360px;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: var(--primary-color);
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 14px;
            color: #343a40;
        }

        input, select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            box-sizing: border-box;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--primary-color);
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

        .message {
            margin-top: 18px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
        }

        .error {
            color: var(--error-color);
        }

        .result {
            color: var(--success-color);
        }
    </style>
</head>
<body>

<div class="calculator">
    <h2>Arithmetic Calculator</h2>

    <form method="post">
        <div class="form-group">
            <label>First Number</label>
            <input type="text" name="value1" value="<?= htmlspecialchars($value1) ?>">
        </div>

        <div class="form-group">
            <label>Second Number</label>
            <input type="text" name="value2" value="<?= htmlspecialchars($value2) ?>">
        </div>

        <div class="form-group">
            <label>Operation</label>
            <select name="operator">
                <option value="">-- Select an operation --</option>
                <option value="add" <?= $operator === "add" ? "selected" : "" ?>>Addition (+)</option>
                <option value="subtract" <?= $operator === "subtract" ? "selected" : "" ?>>Subtraction (−)</option>
                <option value="multiply" <?= $operator === "multiply" ? "selected" : "" ?>>Multiplication (×)</option>
                <option value="divide" <?= $operator === "divide" ? "selected" : "" ?>>Division (÷)</option>
            </select>
        </div>

        <button type="submit">Calculate</button>
    </form>

    <?php if ($error): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($result !== null): ?>
        <div class="message result">Result: <?= $result ?></div>
    <?php endif; ?>
</div>

</body>
</html>
