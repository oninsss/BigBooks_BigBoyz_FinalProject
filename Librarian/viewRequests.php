<div class="table-wrapper">
    <div class="header">
        <div class="titleBar">
            <span class="material-symbols-outlined" id="_sidebar-toggle">
                menu
            </span>
            <h1>View Requests</h1>
        </div>
        <div class="bottom">
            <div class="inner-nav">
                <form method="GET" action="index.php">
                    <input type="hidden" name="page" value="viewRequests">
                    <div class="searchBar">
                        <input 
                            type="text" 
                            name="search" 
                            value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" 
                            placeholder="Search Record">
                        <button type="submit" id="_search">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                    </div>
                    <div class="filter">
                        <select name="request-filter" id="_request-filter">
                            <option value="borrow-requests" <?php if(isset($_GET['request-filter']) && $_GET['request-filter'] == 'borrow-requests') echo 'selected'; ?>>Borrow Requests</option>
                        </select>
                        <button type="submit" id="_filter-btn">
                            <p>Filter</p>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <table class="request-list-header">
            <tr id="_header">
            <?php
            $requestFilter = isset($_GET['request-filter']) ? $_GET['request-filter'] : '';
                switch($requestFilter) {
                    case 'borrow-requests':
                        echo "<th>Request ID</th>";
                        echo "<th>Book ID</th>";
                        echo "<th>Requested by</th>";
                        echo "<th>Request Date</th>";
                        echo "<th>Actions</th>";
                        break;
                    default :
                        echo "<th>Request ID</th>";
                        echo "<th>Book ID</th>";
                        echo "<th>Requested by</th>";
                        echo "<th>Request Date</th>";
                        echo "<th>Actions</th>";
                        break;
                }
            ?>
            </tr>
        </table>
    </div>

    <table class="request-list">
        <?php
            include "../database.php";
            switch ($requestFilter) {
                case 'borrow-requests':
                    $sql = "SELECT * FROM borrow_book WHERE status = 'pending'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['borrow_id'] . "</td>";
                            echo "<td>" . $row['book_id'] . "</td>";
                            echo "<td>" . $row['borrowed_by'] . "</td>";
                            echo "<td>" . $row['borrow_date'] . "</td>";
                            echo "<td>
                                    <div class='btnGrp'>
                                        <button class='positiveBtn' data-request-id='" . $row['borrow_id'] . "'>Approve</button>
                                        <button class='negativeBtn' data-request-id='" . $row['borrow_id'] . "'>Reject</button>
                                    </div>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No requests found</td></tr>";
                    }
                    break;
                default:
                    $sql = "SELECT * FROM borrow_book WHERE status = 'pending'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['borrow_id'] . "</td>";
                            echo "<td>" . $row['book_id'] . "</td>";
                            echo "<td>" . $row['borrowed_by'] . "</td>";
                            echo "<td>" . $row['borrow_date'] . "</td>";
                            echo "<td>
                                    <div class='btnGrp'>
                                        <button class='positiveBtn' data-request-id='" . $row['borrow_id'] . "'>Approve</button>
                                        <button class='negativeBtn' data-request-id='" . $row['borrow_id'] . "'>Reject</button>
                                    </div>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No requests found</td></tr>";
                    }
                    break;
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
            <form method="POST" action="updateRequestStatus.php">
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
            <form method="POST" action="updateRequestStatus.php">
                <input type="hidden" name="request_id" id="reject-request-id">
                <input type="hidden" name="status" value="Rejected">
                <button type="submit" class="negativeBtn">Reject</button>
            </form>
            <button class="close-modal">Cancel</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const approveButtons = document.querySelectorAll('.positiveBtn');
        const rejectButtons = document.querySelectorAll('.negativeBtn');
        const approveModal = document.querySelector('.approve-modal-bg');
        const rejectModal = document.querySelector('.reject-modal-bg');
        const closeModalButtons = document.querySelectorAll('.close-modal');
        const approveRequestId = document.getElementById('approve-request-id');
        const rejectRequestId = document.getElementById('reject-request-id');

        approveButtons.forEach(button => {
            button.addEventListener('click', () => {
                approveRequestId.value = button.getAttribute('data-request-id');
                approveModal.style.display = 'flex';
            });
        });

        rejectButtons.forEach(button => {
            button.addEventListener('click', () => {
                rejectRequestId.value = button.getAttribute('data-request-id');
                rejectModal.style.display = 'flex';
            });
        });

        closeModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                approveModal.style.display = 'none';
                rejectModal.style.display = 'none';
            });
        });
    });
</script>
