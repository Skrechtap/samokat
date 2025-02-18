<?php
    include 'db_config.php';

    try {
        $stmt = $pdo->query("SELECT * FROM equipment");
        $equipment = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }

    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="equipment_data.csv"');

    $output = fopen('php://output', 'w');
    
    if (!empty($equipment)) {
        fputcsv($output, array_keys($equipment[0]));

        foreach ($equipment as $row) {
            fputcsv($output, $row);
        }
    }

    fclose($output);
    exit();
    ?>
    
