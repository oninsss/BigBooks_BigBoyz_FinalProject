<?php
include "../database.php";
?>

<div class="table-wrapper">
    <div class="header">
        <div class="titleBar">
            <span class="material-symbols-outlined" id="_sidebar-toggle">menu</span>
            <h1>View Requests</h1>
        </div>
        <div class="bottom">
            <div class="inner-nav">
                <form method="GET" action="index.php">
                    <input type="hidden" name="page" value="viewRequests">
                    <div class="searchBar">
                        <input type="text" name="search" value="<?php if (isset($_GET['search'])) { echo $_GET['search']; } ?>" placeholder="Search Record">
                        <button type="submit" id="_search">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                    </div>
                    <div class="filter">
                        <select name="request-filter" id="_request-filter">
                            <option value="borrow-requests" <?php if (isset($_GET['request-filter']) && $_GET['request-filter'] == 'borrow-requests') echo 'selected'; ?>>Borrow Requests</option>
                            <option value="return-requests" <?php if (isset($_GET['request-filter']) && $_GET['request-filter'] == 'return-requests') echo 'selected'; ?>>Return Requests</option>
                        </select>
                        <button type="submit" id="_filter-btn"><p>Filter</p></button>
                    </div>
                </form>
            </div>
        </div>

        <table class="request-list-header">
            <tr id="_header">
                <?php
                $requestFilter = isset($_GET['request-filter']) ? $_GET['request-filter'] : '';
                switch($requestFilter) {
                    case 'return-requests':
                        echo "<th>Return ID</th>";
                        echo "<th>Book ID</th>";
                        echo "<th>Returned by</th>";
                        echo "<th>Return Date</th>";
                        echo "<th>Actions</th>";
                        break;
                    case 'payment-requests':
                        echo "<th>Payment ID</th>";
                        echo "<th>Book ID</th>";
                        echo "<th>Borrowed by</th>";
                        echo "<th>Approved by</th>";
                        echo "<th>Payment Date</th>";
                        echo "<th>Actions</th>";
                        break;
                    default:
                        echo "<th>Borrow ID</th>";
                        echo "<th>Book ID</th>";
                        echo "<th>Borrowed by</th>";
                        echo "<th>Borrow Date</th>";
                        echo "<th>Actions</th>";
                        break;
                }
                ?>
            </tr>
        </table>
    </div>

    <table class="request-list">
        <?php
        switch ($requestFilter) {
            case 'return-requests':
                $requests = "SELECT * FROM return_books_transactions 
                                        WHERE b_status = 'Pending'";
                break;
            case 'payment-requests':
                $requests = "";
                break;
            default:
            $requests = "SELECT * FROM borrow_books_transactions 
                        WHERE b_status = 'Pending'";
            break;
        }

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $requests = "SELECT * FROM borrow_books_transactions WHERE 
                         transaction_id LIKE '%$search%' OR 
                         book_id LIKE '%$search%' OR 
                         borrowed_by LIKE '%$search%' OR 
                         approved_by LIKE '%$search%'";
        }

        $result = $conn->query($requests);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                switch ($requestFilter) {
                    case 'borrow-requests':
                        echo "<td>" . $row['transaction_id'] . "</td>";
                        echo "<td>" . $row['book_id'] . "</td>";
                        echo "<td>" . $row['borrowed_by'] . "</td>";
                        echo "<td>" . $row['b_start_date'] . "</td>";
                        echo "<td>
                                <div class='btnGrp'>
                                    <button class='positiveBtn' onclick='openApproveModal(\"" . $row['transaction_id'] . "\")'>Approve</button>
                                    <button class='negativeBtn' onclick='openRejectModal(\"" . $row['transaction_id'] . "\")'>Reject</button>
                                </div>
                            </td>";
                        break;
                    case 'return-requests':
                        echo "<td>" . $row['transaction_id'] . "</td>";
                        echo "<td>" . $row['book_id'] . "</td>";
                        echo "<td>" . $row['returned_by'] . "</td>";
                        echo "<td>" . $row['date_returned'] . "</td>";
                        echo "<td>
                                <div class='btnGrp'>
                                    <button class='positiveBtn' onclick='openApproveReturnModal(\"" . $row['transaction_id'] . "\")'>Approve</button>
                                </div>
                            </td>";
                        break;
                    case 'payment-requests':
                        break;
                    default:
                        echo "<td>" . $row['transaction_id'] . "</td>";
                        echo "<td>" . $row['book_id'] . "</td>";
                        echo "<td>" . $row['borrowed_by'] . "</td>";
                        echo "<td>" . $row['b_start_date'] . "</td>";
                        echo "<td>
                                <div class='btnGrp'>
                                    <button class='positiveBtn' onclick='openApproveModal(\"" . $row['transaction_id'] . "\")'>Approve</button>
                                    <button class='negativeBtn' onclick='openRejectModal(\"" . $row['transaction_id'] . "\")'>Reject</button>
                                </div>
                            </td>";
                        break;
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No records found</td></tr>";
        }
        ?>
    </table>
</div>

<div class="approve-modal-bg" style="display: none;">
    <div class="approve-modal">
        <div class="modal-header">
            <h2>Approve Request</h2>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to approve this request?</p>
        </div>
        <div class="modal-footer">
            <form method="POST" action="approveBorrow.php">
                <input type="hidden" name="request_id" id="approve-request-id">
                <input type="hidden" name="status" value="Approved">
                <button type="submit" class="positiveBtn">Approve</button>
            </form>
            <button class="close-modal">Cancel</button>
        </div>
    </div>
</div>

<div class="reject-modal-bg" style="display: none;">
    <div class="reject-modal">
        <div class="modal-header">
            <h2>Reject Request</h2>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to reject this request?</p>
        </div>
        <div class="modal-footer">
            <form method="POST" action="approveBorrow.php">
                <input type="hidden" name="request_id" id="reject-request-id">
                <input type="hidden" name="status" value="Rejected">
                <button type="submit" class="negativeBtn">Reject</button>
            </form>
            <button class="close-modal">Cancel</button>
        </div>
    </div>
</div>

<div class="approve-return-modal-bg" style="display: none;">
    <div class="approve-modal">
        <div class="modal-header">
            <h2>Approve Request</h2>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to approve this request?</p>
        </div>
        <div class="modal-footer">
            <form method="POST" action="approveReturn.php">
                <input type="hidden" name="transaction_id" id="approve-return-request-id"> <!-- Change name to "transaction_id" -->
                <input type="hidden" name="status" value="Approved">
                <button type="submit" class="positiveBtn">Approve</button>
            </form>
            <button class="close-modal">Cancel</button>
        </div>
    </div>
</div>

<script>
    function openApproveModal(transactionId) {
        document.getElementById('approve-request-id').value = transactionId;
        document.querySelector('.approve-modal-bg').style.display = 'flex';
    }

    function openRejectModal(transactionId) {
        document.getElementById('reject-request-id').value = transactionId;
        document.querySelector('.reject-modal-bg').style.display = 'flex';
    }

    function openApproveReturnModal(transactionId) {
        document.getElementById('approve-return-request-id').value = transactionId; <!-- Change ID to match the hidden input ID -->
        document.querySelector('.approve-return-modal-bg').style.display = 'flex';
    }

    document.addEventListener('DOMContentLoaded', () => {
        const closeModalButtons = document.querySelectorAll('.close-modal');
        closeModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                document.querySelector('.approve-modal-bg').style.display = 'none';
                document.querySelector('.reject-modal-bg').style.display = 'none';
                document.querySelector('.approve-return-modal-bg').style.display = 'none';
            });
        });
    });
</script>
