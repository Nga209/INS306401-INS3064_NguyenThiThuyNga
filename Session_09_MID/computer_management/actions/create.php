<?php
require_once '../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $computer_name = trim($_POST['computer_name']);
    $model = trim($_POST['model']);
    $operating_system = trim($_POST['operating_system']);
    $processor = trim($_POST['processor']);
    $memory = $_POST['memory'] ?: null;
    $available = $_POST['available'] ?? 1;

    if(empty($computer_name) || empty($model)) {
        header("Location: ../dashboard.php?error=Computer name and model are required");
        exit();
    }

    try {
        $sql = "INSERT INTO computers (computer_name, model, operating_system, processor, memory, available) 
                VALUES (:name, :model, :os, :processor, :memory, :available)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $computer_name,
            ':model' => $model,
            ':os' => $operating_system,
            ':processor' => $processor,
            ':memory' => $memory,
            ':available' => $available
        ]);
        header("Location: ../dashboard.php?success=Computer added successfully");
    } catch(PDOException $e) {
        header("Location: ../dashboard.php?error=Database error: " . $e->getMessage());
    }
}
?>