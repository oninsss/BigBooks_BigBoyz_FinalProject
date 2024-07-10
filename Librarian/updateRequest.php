<?php
include "../database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = mysqli_real_escape_string($conn, $_POST['request_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);

    $sql = "UPDATE borrow_book SET status = '$new_status' WHERE borrow_id = '$request_id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../index.php?page=viewRequests");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
