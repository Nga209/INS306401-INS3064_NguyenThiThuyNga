<?php
require_once '../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM computers WHERE id = :id");
        $stmt->execute([':id' => $id]);
        header("Location: ../dashboard.php?success=Computer deleted successfully");
    } catch(PDOException $e) {
        header("Location: ../dashboard.php?error=Delete failed: " . $e->getMessage());
    }
} else {
    header("Location: ../dashboard.php");
}
?>