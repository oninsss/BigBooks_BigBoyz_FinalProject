<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../database.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$studentID = $_SESSION['student_id'];

$result = $conn->query("SELECT COUNT(transaction_id) AS count FROM bigbooks.return_books_transactions");
if ($result) {
    $row = $result->fetch_assoc();
    $transactionsCount = $row['count'];
} else {
    echo "Error: " . $conn->error;
    exit();
}

$transactionID = "RB" . date("Y") . sprintf("%04d", $transactionsCount + 1);

$bookID = isset($_POST['book_id']) ? $_POST['book_id'] : '';
$returnDate = isset($_POST['returnDate']) ? $_POST['returnDate'] : '';
$status = 'Pending';
$bbTransaction_id = isset($_POST['transaction_id']) ? $_POST['transaction_id'] : '';

// Debugging output
echo "transactionID: $transactionID, bookID: $bookID, returnDate: $returnDate, status: $status, bbTransaction_id: $bbTransaction_id<br>";

$sql = "INSERT INTO bigbooks.return_books_transactions (transaction_id, book_id, reference_id, returned_by, date_returned, b_status) VALUES ('$transactionID', '$bookID', '$bbTransaction_id', '$studentID', '$returnDate', '$status')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit();
}

$referenceID = $transactionID;

$allTransactCountSql = $conn->query("SELECT COUNT(transaction_id) AS count FROM bigbooks.all_transactions");
if ($allTransactCountSql) {
    $row = $allTransactCountSql->fetch_assoc();
    $allTransactionsCount = $row['count'];
} else {
    echo "Error: " . $conn->error;
    exit();
}

$allTransactionsID = 'TR' . $referenceID . sprintf('%04d', $allTransactionsCount + 1);

$allTransactSql = "INSERT INTO bigbooks.all_transactions (transaction_id, reference_id, user_id, tr_date, purpose) VALUES ('$allTransactionsID', '$referenceID', '$studentID', '$returnDate', 'Return')";

// Debugging output
echo "allTransactionsID: $allTransactionsID, referenceID: $referenceID, studentID: $studentID, returnDate: $returnDate<br>";

if ($conn->query($allTransactSql) === TRUE) {
    echo "New record created successfully<br>";
    echo "<script>window.location.href = 'index.php?page=borrowedBooks';</script>";
} else {
    echo "Error: " . $allTransactSql . "<br>" . $conn->error;
}

$paymentSql = "SELECT * FROM bigbooks.borrow_books_transactions WHERE user_id = '$studentID' AND b_status = 'Approved'";
$paymentResult = $conn->query($paymentSql);

if ($paymentResult->num_rows > 0) {
    while ($row = $paymentResult->fetch_assoc()) {
        $bookID = $row['book_id'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];

        $sql = "SELECT * FROM bigbooks.return_books_transactions WHERE reference_id = '" . $row['transaction_id'] . "'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $returnDate = $row['date_returned'];
            }
        }

        if ($returnDate > $end_date) {
            $days = abs(strtotime($returnDate) - strtotime($end_date)) / (60 * 60 * 24);
            $penalty = $days * 10;

            $sql = "SELECT * FROM bigbooks.user WHERE user_id = '$studentID'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $db_balance = $row['acc_balance'];
                }
            }

            $newBalance = $db_balance + $penalty;

            $sql = "UPDATE bigbooks.user SET acc_balance = '$newBalance' WHERE user_id = '$studentID'";

            if ($conn->query($sql) === TRUE) {
                echo "Penalty of ₱$penalty has been added to your account. Your new balance is ₱$newBalance.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

    }
}
$conn->close();
?>
