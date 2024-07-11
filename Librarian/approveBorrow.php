<?php
include "../database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = mysqli_real_escape_string($conn, $_POST['request_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);

    if ($new_status === 'Approve') {
        $new_status = 'Approved';
    }
    
    $sql = "UPDATE borrow_books_transactions SET b_status = '$new_status' WHERE transaction_id = '$request_id'";
    if ($conn->query($sql) === TRUE) {
        $result = $conn->query("SELECT transaction_id FROM all_transactions WHERE reference_id = '$request_id'");
        if ($result->num_rows > 0) {
            $sql_update = "UPDATE all_transactions SET purpose = 'Approved' WHERE reference_id = '$request_id'";
            if ($conn->query($sql_update) === TRUE) {
                header("Location: ./index.php?page=viewRequests");
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            $result = $conn->query("SELECT COUNT(*) AS count FROM all_transactions");
            $row = $result->fetch_assoc();
            $count = $row['count'] + 1;

            $transaction_id = 'TR' . $request_id . str_pad($count, 4, '0', STR_PAD_LEFT);

            $tr_date = date('Y-m-d H:i:s');

            $purpose = ($new_status == 'Approved') ? 'Approved' : 'Rejected';

            $sql_insert = "INSERT INTO all_transactions (transaction_id, reference_id, user_id, tr_date, purpose) VALUES ('$transaction_id', '$request_id', '$request_id', '$tr_date', '$purpose')";
            if ($conn->query($sql_insert) === TRUE) {
                header("Location: ./index.php?page=viewRequests");
                exit();
            } else {
                echo "Error inserting record: " . $conn->error;
            }
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>