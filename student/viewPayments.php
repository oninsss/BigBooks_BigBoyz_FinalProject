<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books</title>
    <link rel="stylesheet" href="./Assets/Style/accBalance.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <div class="viewRequestsCont">
        <div class="topPart">
            <!-- Top part code here -->
        </div>

        <?php
            include '../database.php';

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $student_id = isset($_SESSION['student_id']) ? $_SESSION['student_id'] : '';

            $sql = "SELECT * FROM user WHERE user_id = '$student_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $db_balance = $row['acc_balance'];
                }
            }
        ?>

        <div class="bottomPart">
            <div class="accBalance">
                <h1>Payable Balance: ₱<?php echo $db_balance; ?></h1>
                <p>Pay your balance to continue borrowing books.</p>

                <h5>Breakdown of balance</h5>
                <table>
                    <th>
                        <td>Details</td>
                        <td>Amount</td>
                    </th>
                    <tr>
                        <td>1</td>
                        <td>3 days Overdue</td>
                        <td>₱50.00</td>
                    </tr>
                </table>

                <div class="paymentOptions">
                    <h2>Payment Options</h2>
                    <p>Pay your balance through the following options:</p>
                    <ul>
                        <a href="https://www.gcash.com"><li>GCash</li></a>
                        <a href="https://www.maya.ph"><li>PayMaya</li></a>
                        <a href="https://www.bpi.com.ph"><li>Bank Transfer</li></a>
                    </ul>
                </div>

                <h5>Direct Payment</h5>
                <form id="paymentForm" action="index.php?page=payBalance" method="post">
                    <input type="number" name="amount" class="moneyInput" placeholder="Enter amount to pay" required>
                    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                    <input type="hidden" name="balance" value="<?php echo $db_balance; ?>">
                    <button type="button" class="btn btn-success" onclick="openModal()">Pay</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>Are you sure you want to pay this amount?</p>
            <div class="modal-buttons">
                <button type="button" onclick="submitForm()">Yes</button>
                <button type="button" onclick="closeModal()">No</button>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('confirmationModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('confirmationModal').style.display = 'none';
        }

        function submitForm() {
            document.getElementById('paymentForm').submit();
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('confirmationModal')) {
                closeModal();
            }
        }
    </script>
</body>
</html>
