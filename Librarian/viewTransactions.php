<?php
    include "../database.php";
    $transactions = "SELECT * FROM transactions";
?>

<div class="table-wrapper">
    <div class="header">
        <div class="titleBar">
            <span class="material-symbols-outlined" id="_sidebar-toggle">
                menu
            </span>
            <h1>View Transactions</h1>
        </div>
        <div class="bottom">
            <div class="inner-nav">
                <form method="GET" action="index.php">
                    <input type="hidden" name="page" value="viewTransactions">
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
                        <select name="transaction-filter" id="_transaction-filter">
                            <option value="">All Transactions</option>
                            <option value="borrowed" <?php if(isset($_GET['transaction-filter']) && $_GET['transaction-filter'] == 'borrowed') echo 'selected'; ?>>Borrowed Books</option>
                            <option value="returned" <?php if(isset($_GET['transaction-filter']) && $_GET['transaction-filter'] == 'returned') echo 'selected'; ?>>Returned Books</option>
                        </select>
                        <button type="submit" id="_filter-btn">
                            <p>Filter</p>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <table class="transactions-list-header">
            <tr id="_header">
            <?php
            $transactionFilter = isset($_GET['transaction-filter']) ? $_GET['transaction-filter'] : '';
                switch($transactionFilter) {
                    case 'borrowed-books':
                        echo "<th>Borrow ID</th>";
                        echo "<th>Book ID</th>";
                        echo "<th>Borrowed by</th>";
                        echo "<th>Borrow Date</th>";
                        echo "<th>Status</th>";
                        break;
                    case 'returned':
                        echo "<th>Return ID</th>";
                        echo "<th>Book ID</th>";
                        echo "<th>Borrowed by</th>";
                        echo "<th>Approved by</th>";
                        echo "<th>Return Date</th>";
                        break;
                    default:
                        echo "<th>Transaction ID</th>";
                        echo "<th>Reference ID</th>";
                        echo "<th>User ID</th>";
                        echo "<th>Transaction Date</th>";
                        echo "<th>Purpose</th>";
                        break;
                }
            ?>
            </tr>
        </table>
    </div>

    <table class="transactions-list">
        <?php
            switch ($transactionFilter) {
                case 'borrowed':
                    $transactions = "SELECT * FROM all_transactions WHERE reference_id LIKE 'BR%'";
                    break;
                case 'returned':
                    $transactions = "SELECT * FROM all_transactions WHERE reference_id LIKE 'RR%'";
                    break;
                default:
                    $transactions = "SELECT * FROM all_transactions";
                    break;
            }

            if(isset($_GET['search']) && !empty($_GET['search'])) {
                $search = $_GET['search'];
                $transactions = "SELECT * FROM all_transactions WHERE transaction_id LIKE '%$search%' OR book_id LIKE '%$search%' OR borrower_id LIKE '%$search%' OR approved_by LIKE '%$search%' OR borrow_date LIKE '%$search%' OR return_date LIKE '%$search%'";
            }

            $result = $conn->query($transactions);

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    switch($transactionFilter) {
                        case 'borrowed':
                            echo "<td>".$row['transaction_id']."</td>";
                            echo "<td>".$row['reference_id']."</td>";
                            echo "<td>".$row['user_id']."</td>";
                            echo "<td>".$row['tr_date']."</td>";
                            echo "<td>".$row['purpose']."</td>";
                            break;
                        case 'returned':
                            echo "<td>".$row['return_id']."</td>";
                            echo "<td>".$row['book_id']."</td>";
                            echo "<td>".$row['borrower_id']."</td>";
                            echo "<td>".$row['approved_by']."</td>";
                            echo "<td>".$row['return_date']."</td>";
                            break;
                        default:
                            echo "<td>".$row['transaction_id']."</td>";
                            echo "<td>".$row['reference_id']."</td>";
                            echo "<td>".$row['user_id']."</td>";
                            echo "<td>".$row['tr_date']."</td>";
                            echo "<td>".$row['purpose']."</td>";
                            break;
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No records found</td></tr>";
            }
        ?> 
    </table>
</div>