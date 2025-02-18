<?php
session_start();

include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$search_term = isset($_GET['search']) ? $_GET['search'] : '';

try {
    $sql = "SELECT * FROM equipment";
    if (!empty($search_term)) {
        $sql .= " WHERE name LIKE :search OR type LIKE :search OR status LIKE :search OR description LIKE :search";
    }
    $stmt = $pdo->prepare($sql);

    if (!empty($search_term)) {
        $stmt->bindValue(':search', '%' . $search_term . '%');
    }

    $stmt->execute();
    $equipment = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Equipment Management System</title>
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
            text-align: center;
        }

        p {
            margin-bottom: 10px;
            text-align: center;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .actions {
            white-space: nowrap; /* Prevent line breaks */
        }

        .search-form {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-form input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
        }

        .search-form button {
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Equipment Management System</h1>
        <p>Logged in as <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($_SESSION['user_type'], ENT_QUOTES, 'UTF-8') ?>)</p>
        <p><a href="logout.php">Logout</a></p>

        <div class="search-form">
            <form method="get">
                <input type="text" name="search" placeholder="Search equipment..." value="<?= htmlspecialchars($search_term, ENT_QUOTES, 'UTF-8') ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <?php if ($_SESSION['user_type'] == 'admin'): ?>
            <a href="add_equipment.php">Add New Equipment</a>
            <br><a href="export_equipment.php">Export Equipment Data (CSV)</a><br>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equipment as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($item['type'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($item['status'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="actions">
                        <a href="view_equipment.php?id=<?= htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8') ?>">View</a>
                        <?php if ($_SESSION['user_type'] == 'admin'): ?>
                            | <a href="edit_equipment.php?id=<?= htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8') ?>">Edit</a>
                            | <a href="delete_equipment.php?id=<?= htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8') ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="script.js"></script>
</body>
</html>
