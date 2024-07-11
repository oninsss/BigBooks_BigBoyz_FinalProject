<?php
include "../database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['transaction_id'])) {
        $transactionId = mysqli_real_escape_string($conn, $_POST['transaction_id']);
        $currentDate = date('Y-m-d');

        // Update the b_status to 'Cleared'
        $sql = "UPDATE return_books_transactions SET 
                    b_status = 'Cleared' 
                WHERE transaction_id = '$transactionId'";

        // Fetch the returned_by field
        $sqlFetch = "SELECT returned_by FROM return_books_transactions WHERE transaction_id = '$transactionId'";
        $result = $conn->query($sqlFetch);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $returnedBy = $row['returned_by'];

            // Execute the update query
            if ($conn->query($sql) === TRUE) {
                // Generate new transaction ID for all_transactions
                $resultCount = $conn->query("SELECT COUNT(*) AS count FROM all_transactions");
                $rowCount = $resultCount->fetch_assoc();
                $count = $rowCount['count'] + 1;

                $newTransactionId = 'TR' . $transactionId . str_pad($count, 4, '0', STR_PAD_LEFT);
                $trDate = date('Y-m-d H:i:s');
                $purpose = 'Cleared';

                // Insert new transaction into all_transactions
                $sqlInsert = "INSERT INTO all_transactions (transaction_id, reference_id, user_id, tr_date, purpose) 
                              VALUES ('$newTransactionId', '$transactionId', '$returnedBy', '$trDate', '$purpose')";
                if ($conn->query($sqlInsert) === TRUE) {
                    header("Location: ./index.php?page=viewRequests");
                    exit();
                } else {
                    echo "Error inserting record into all_transactions: " . $conn->error;
                }
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "Error: No record found with the given transaction_id.";
        }

        $conn->close();
    } else {
        echo "Error: transaction_id not set.";
    }
} else {
    echo "Invalid request.";
}
?>