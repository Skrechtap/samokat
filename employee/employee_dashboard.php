<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'employee') {
    header("Location: ../login.php"); // Redirect if not logged in or not an employee
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Dashboard</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            margin-bottom: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, Employee!</h1>
        <p>Logged in as <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><a href="../index.php">View Equipment</a></p>  <!-- Link back to equipment viewing (read-only) -->
        <p><a href="../logout.php">Logout</a></p>
    </div>
</body>
</html>
