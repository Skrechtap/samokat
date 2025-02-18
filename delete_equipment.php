<?php
include 'db_config.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php"); // Redirect if not logged in or not an admin
    exit();
}
$equipment_id = $_GET['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM equipment WHERE id = ?");
    $stmt->execute([$equipment_id]);
    header("Location: index.php");
    exit();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>
