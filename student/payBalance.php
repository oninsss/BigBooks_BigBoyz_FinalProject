<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../database.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$paymentAmount = isset($_POST['amount']) ? mysqli_real_escape_string($conn, $_POST['amount']) : '';
$student_id = $_SESSION['student_id'] ? $_SESSION['student_id'] : '';

if (empty($paymentAmount)) {
    die('ERROR: Payment amount not found.');
}

$sql = "SELECT * FROM user WHERE user_id = '$student_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $db_balance = $row['acc_balance'];
    }
}

$newBalance = $db_balance - $paymentAmount;

$sql = "UPDATE user SET acc_balance = '$newBalance' WHERE user_id = '$student_id'";

if ($conn->query($sql) === TRUE) {
    echo "Payment successful. Your new balance is ₱$newBalance.";
    echo '<script>header("Location: index.php?page=viewPayments")</script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>