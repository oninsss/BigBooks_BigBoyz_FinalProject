<?php
include "../database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['transaction_id'])) {
        $transactionId = $_POST['transaction_id'];
        $currentDate = date('Y-m-d');

        // Update returned_books_transactions table
        $sql1 = "UPDATE returned_books_transactions SET 
                    date_approved = '$currentDate', 
                    b_status = 'Cleared' 
                WHERE transaction_id = '$transactionId'";

        // Update borrow_books_transactions table
        // $sql2 = "UPDATE borrow_books_transactions SET 
        //             b_status = 'Cleared' 
        //         WHERE transaction_id = '$transactionId'";

        // Fetch returned_by from returned_books_transactions
        $sqlFetch = "SELECT returned_by FROM returned_books_transactions WHERE transaction_id = '$transactionId'";
        $result = $conn->query($sqlFetch);
        $row = $result->fetch_assoc();
        $returnedBy = $row['returned_by'];

        // Insert into all_transactions table
        $sql3 = "INSERT INTO all_transactions (reference_id, user_id, tr_date, purpose) 
                VALUES ('$transactionId', '$returnedBy', '$currentDate', 'Return')";

        // Execute all queries
        if ($conn->query($sql1) === TRUE && $conn->query($sql3) === TRUE) {
            header("Location: ./index.php?page=viewRequests");
            exit();
        } else {
            echo "Error updating records: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Error: transaction_id not set.";
    }
} else {
    echo "Invalid request.";
}
?>
