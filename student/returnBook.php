<?php
    if (session_start() === PHP_SESSION_NONE) {
        session_start();
    }

    include '../database.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $studentID = $_SESSION['student_id'];
    

    $result = $conn->query("SELECT COUNT(transaction_id) AS count FROM bigbooks.return_books_transactions");
    $row = $result->fetch_assoc();
    $transactionsCount = $row['count'];


    $transactionID = "RB" . date("Y") . sprintf("%04d", $transactionsCount + 1);

    $bookID = isset($_POST['book_id']) ? $_POST['book_id'] : '';
    $returnDate = isset($_POST['returnDate']) ? $_POST['returnDate'] : '';
    $status = 'Pending';
    $bbTransaction_id = isset($_POST['transaction_id']) ? $_POST['transaction_id']: '';

    $sql = "INSERT INTO bigbooks.return_books_transactions (transaction_id, book_id, reference_id, returned_by, date_returned, b_status) VALUES ('$transactionID', '$bookID', '$bbTransaction_id', '$studentID', '$returnDate', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        echo "<script>window.location.href = 'index.php?page=borrowedBooks';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $referenceID = $transactionID;

    $allTransactCountSql = $conn->query("SELECT COUNT(transaction_id) AS count FROM bigbooks.all_transactions");
    $row = $allTransactCountSql->fetch_assoc();
    $allTransactionsCount = $row['count'];

    $allTransactionsID = 'TR' . $referenceID . sprintf('%04d', $allTransactionsCount + 1);
    
    $allTransactSql = "INSERT INTO bigbooks.all_transactions (transaction_id, reference_id, user_id, tr_date, purpose) VALUES ('$allTransactionsID', '$transactionID', '$studentID', '$returnDate', 'Return')";

    if ($conn->query($allTransactSql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $allTransactSql . "<br>" . $conn->error;
    }

    

    $conn->close();

    
?>