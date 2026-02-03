<?php
/**
 * Search Query Echo
 * Objective: Demonstrate GET request transparency and XSS prevention
 */

$search = "";

/* Detect GET request */
if (isset($_GET['q'])) {
    $search = trim($_GET['q']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Query Echo</title>
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

        .container {
            background-color: #ffffff;
            padding: 30px;
            width: 360px;
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
            font-size: 14px;
            display: block;
            margin-bottom: 6px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        button {
            width: 100%;
            margin-top: 15px;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1f2d3a;
        }

        .result {
            margin-top: 18px;
            font-size: 14px;
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Search</h2>

    <form method="get" action="">
        <label for="q">Search Term</label>
        <input type="text" name="q" id="q"
               value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <?php if ($search !== ""): ?>
        <div class="result">
            You searched for:
            <strong><?= htmlspecialchars($search) ?></strong>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
