<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include 'db_config.php';

$equipment_id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM equipment WHERE id = ?");
    $stmt->execute([$equipment_id]);
    $equipment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$equipment) {
        die("Equipment not found.");
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Equipment Details</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: left;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        p {
            margin-bottom: 10px;
            line-height: 1.6;
        }

        strong {
            font-weight: bold;
            color: #555;
        }

        a {
            color: #007bff;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Equipment Details</h1>
        <p><strong>ID:</strong> <?= htmlspecialchars($equipment['id'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Name:</strong> <?= htmlspecialchars($equipment['name'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Type:</strong> <?= htmlspecialchars($equipment['type'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($equipment['status'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($equipment['description'], ENT_QUOTES, 'UTF-8') ?></p>
        <a href="index.php">Back to List</a>
    </div>
</body>
</html>
