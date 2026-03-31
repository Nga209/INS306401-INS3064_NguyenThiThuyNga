<?php
require_once '../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
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
        $sql = "UPDATE computers SET computer_name=:name, model=:model, operating_system=:os, 
                processor=:processor, memory=:memory, available=:available WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':name' => $computer_name,
            ':model' => $model,
            ':os' => $operating_system,
            ':processor' => $processor,
            ':memory' => $memory,
            ':available' => $available
        ]);
        header("Location: ../dashboard.php?success=Computer updated successfully");
    } catch(PDOException $e) {
        header("Location: ../dashboard.php?error=Update failed: " . $e->getMessage());
    }
}
?>