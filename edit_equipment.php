<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php"); // Redirect if not logged in or not an admin
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Equipment</title>
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
    text-align: left; /* Align form elements to the left */
}

h1 {
    color: #333;
    text-align: center; /* Center the heading */
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555; /* Darken the label text */
}

input[type="text"],
select,
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
}

input[type="text"]:focus,
select:focus,
textarea:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

select {
    height: 40px; /* Adjust select box height */
}

textarea {
    height: 100px;
    resize: vertical; /* Allow vertical resizing */
}

button {
    background-color: #007bff;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
    transition: background-color 0.3s ease; /* Smooth transition */
}

button:hover {
    background-color: #0056b3;
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
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $type = $_POST['type'];
        $status = $_POST['status'];
        $description = $_POST['description'];
        try {
            include 'db_config.php';
            $stmt = $pdo->prepare("INSERT INTO equipment (name, type, status, description) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $type, $status, $description]);
            header("Location: index.php"); // Redirect after successful addition
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            die();
        }
    }
    ?>
    <div class="container">
        <h1>Add New Equipment</h1>
        <form method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="type">Type:</label>
            <input type="text" id="type" name="type" required>
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="Operational">Operational</option>
                <option value="Maintenance">Maintenance</option>
                <option value="Out of Service">Out of Service</option>
            </select>
            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>
            <button type="submit">Add Equipment</button>
        </form>
    </div>
</body>
</html>
