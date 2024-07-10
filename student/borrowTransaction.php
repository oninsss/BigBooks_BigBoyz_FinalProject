<?php
    include '../database.php';
    session_start();

    $sampleUsername = 'STUD0001';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $book_id = isset($_POST['book_id']) ? $_POST['book_id'] : '';
    $student_id = $sampleUsername;
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $author = isset($_POST['author']) ? $_POST['author'] : '';
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
    $status = 'Pending';

    $result = $conn->query("SELECT COUNT(transaction_id) AS count FROM bigbooks.borrow_books_transactions");

    if ($result) {
        $row = $result->fetch_assoc();
        $transactionsCount = $row['count'];
    } else {
        // Handle the error appropriately
        $transactionsCount = 0;
        echo "Error: " . $conn->error;
    }

    //add the year in between the transaction_id
    $transaction_id = 'BB' . date('Y') . sprintf('%04d', $transactionsCount + 1 );
        

    $sql = "INSERT INTO bigbooks.borrow_books_transactions (transaction_id, book_id, borrowed_by, b_start_date, b_end_date, b_status) VALUES ('$transaction_id','$book_id', '$student_id', '$start_date', '$end_date', '$status')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        $_SESSION['borrow_success'] = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        $_SESSION['borrow_success'] = false;
    }

    $reference_id = $transaction_id;
    
    $allTransactCountSql = $conn->query("SELECT COUNT(transaction_id) AS count FROM bigbooks.all_transactions");

    if ($allTransactCountSql) {
        $row = $allTransactCountSql->fetch_assoc();
        $allTransactionsCount = $row['count'];
    } else {
        // Handle the error appropriately
        $allTransactionsCount = 0;
        echo "Error: " . $conn->error;
    }
    
    $all_transactions_id = 'TR' . $reference_id . sprintf('%04d', $allTransactionsCount + 1);

    $allTransactSql = "INSERT INTO bigbooks.all_transactions (transaction_id, reference_id, user_id, tr_date, purpose) VALUES ('$all_transactions_id', '$transaction_id', '$student_id', '$start_date', 'Borrow')";
    if ($conn->query($allTransactSql) === TRUE) {
        echo "New record created successfully";
        header('Location: ./index.php?page=viewBooks');
    } else {
        echo "Error: " . $allTransactSql . "<br>" . $conn->error;
    }

    $conn->close();
?>