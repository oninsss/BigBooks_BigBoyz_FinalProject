<head>
    <link rel="stylesheet" type="text/css" href="./Assets/Style/viewHistory.css">
</head>

<?php

    echo '<div class="historyCont">';
    echo '<h1>Transaction History</h1>';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include '../database.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $student_id = isset($_SESSION['student_id']) ? $_SESSION['student_id'] : '';

    $sql = "SELECT * FROM all_transactions WHERE user_id = '$student_id'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<th>';
        echo '<td>Transaction ID</td>';
        echo '<td>Reference ID</td>';
        echo '<td>Transaction Date</td>';
        echo '<td>Transaction Type</td>';
        echo '</th>';
        echo '<tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<td></td>';
            echo '<td>' . $row['transaction_id'] . '</td>';
            echo '<td>' . $row['reference_id'] . '</td>';
            echo '<td>' . $row['tr_date'] . '</td>';
            echo '<td>' . $row['purpose'] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo 'No history found.';
    }
    echo '</div>';

?>