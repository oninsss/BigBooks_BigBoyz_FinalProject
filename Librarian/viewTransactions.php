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
                            <option value="borrowed-books" <?php if(isset($_GET['transaction-filter']) && $_GET['transaction-filter'] == 'availableBooks') echo 'selected'; ?>>Borrowed Books</option>
                            <option value="returned" <?php if(isset($_GET['transaction-filter']) && $_GET['transaction-filter'] == 'availableBooks') echo 'selected'; ?>>Returned Books</option>
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
                        echo "<th>More</th>";
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
                        echo "<th>Book ID</th>";
                        echo "<th>Borrowed by</th>";
                        echo "<th>Approved by</th>";
                        echo "<th>Borrow Date</th>";
                        echo "<th>Return Date</th>";
                        break;
                }
            ?>
            </tr>
        </table>
    </div>

    <table class="transaction-list">
        <?php
            switch ($transactionFilter) {
                case 'borrowed':
                    $transactions = "SELECT * FROM borrow_book WHERE status = 'Approved' OR status = 'Rejected'";
                    break;
                case 'returned':
                    $transactions = "SELECT * FROM transactions WHERE status = 'Returned'";
                    break;
                default:
                    $transactions = "SELECT * FROM transactions";
                    break;
            }

            if(isset($_GET['search']) && !empty($_GET['search'])) {
                $search = $_GET['search'];
                $transactions = "SELECT * FROM transactions WHERE transaction_id LIKE '%$search%' OR book_id LIKE '%$search%' OR borrower_id LIKE '%$search%' OR approved_by LIKE '%$search%' OR borrow_date LIKE '%$search%' OR return_date LIKE '%$search%'";
            }

            $result = $conn->query($transactions);

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    switch($transactionFilter) {
                        case 'borrowed':
                            echo "<td>".$row['borrow_id']."</td>";
                            echo "<td>".$row['book_id']."</td>";
                            echo "<td>".$row['borrowed_by']."</td>";
                            echo "<td>".$row['approved_by']."</td>";
                            echo "<td>".$row['borrow_date']."</td>";
                            echo "<td>".$row['status']."</td>";
                            echo "<td><a href='index.php?page=requestInfo&transaction_id=".$row['borrow_id']."'>More</a></td>";
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
                            echo "<td>".$row['librarian_id']."</td>";
                            echo "<td>".$row['student_id']."</td>";
                            echo "<td>".$row['book_id']."</td>";
                            echo "<td>".$row['date_borrowed']."</td>";
                            echo "<td>".$row['date_returned']."</td>";
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