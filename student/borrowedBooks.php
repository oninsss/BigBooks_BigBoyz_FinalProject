<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books</title>
    <link rel="stylesheet" href="./Assets/Style/borrowedBooks.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
</head>
<body>
    <div class="borrowedBooksCont">
        <div class="topPart">
            <div class="searchAndFilter">
                <form class="searchBar" id="searchBar" method="get" action="index.php?page=borrowedBooks">
                    <input type="hidden" name="page" value="borrowedBooks">
                    <input type="hidden" name="page_no" value="1">
                    <input type="search" name="search" placeholder="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" aria-label="Search">
                    <button class="btn success" type="submit">
                        <span class="material-symbols-outlined" id="searchBarIcon">
                            search
                        </span>
                    </button>
                </form>

                <div class="dropdown">
                    <form id="categoryForm" method="get" action="index.php">
                        <input type="hidden" name="page" value="borrowedBooks">
                        <input type="hidden" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <input type="hidden" name="page_no" value="1">
                        <label for="categorySelect" class="visually-hidden">Select a category:</label>
                        <select class="form-select" id="categorySelect" name="category" onchange="this.form.submit()">
                            <option value="">Sort by</option>
                            <option value="Title" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Title') ? 'selected' : ''; ?>>Title</option>
                            <option value="Date_Borrowed" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Date_Borrowed') ? 'selected' : ''; ?>>Date Borrowed</option>
                            <option value="Date_Due" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Date_Due') ? 'selected' : ''; ?>>Date Due</option>
                        </select>
                    </form>
                </div>
            </div>
            <h1>Borrowed Books</h1>
        </div>
        
        <div class="bottomPart">
            <?php
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                // Include database connection
                include '../database.php';

                // Redirect to login if session variable not set (example only)
                if (!isset($_SESSION['student_id'])) {
                    echo '<script>window.location.href = "../login.php";</script>';
                    exit;
                }

                // Pagination logic
                $page_no = isset($_GET['page_no']) && $_GET['page_no'] != "" ? $_GET['page_no'] : 1;
                $total_records_per_page = 5;
                $offset = ($page_no - 1) * $total_records_per_page;

                // Search and filter logic
                $search_query = isset($_GET['search']) ? $_GET['search'] : '';
                $category = isset($_GET['category']) ? $_GET['category'] : '';
                $student_ID = $_SESSION['student_id']; // Replace with your actual session logic

                $query = "SELECT b.*, bb.image, bb.title, bb.author
                FROM bigbooks.borrow_books_transactions b
                INNER JOIN bigbooks.books bb ON b.book_id = bb.book_id
                WHERE b.borrowed_by = ? AND b.b_status = 'Approved'";

                $params = [$student_ID];
                if (!empty($search_query)) {
                    $query .= " AND (bb.title LIKE ? OR bb.author LIKE ?)";
                    $params[] = "%$search_query%";
                    $params[] = "%$search_query%";
                }

                if (!empty($category)) {
                    switch ($category) {
                        case 'Title':
                            $query .= " ORDER BY bb.title";
                            break;
                        case 'Date_Borrowed':
                            $query .= " ORDER BY b.b_start_date";
                            break;
                        case 'Date_Due':
                            $query .= " ORDER BY b.b_end_date";
                            break;
                    }
                } else {
                    $query .= " ORDER BY b.b_start_date DESC";
                }

                $query .= " LIMIT ?, ?";
                $params[] = $offset;
                $params[] = $total_records_per_page;

                $stmt = $conn->prepare($query);
                if ($stmt) {
                    $types = str_repeat('s', count($params) - 2) . 'ii';
                    $stmt->bind_param($types, ...$params);
                    $stmt->execute();
                    $results = $stmt->get_result();

                    if ($results->num_rows == 0) {
                        echo '<p>No borrowed books found.</p>';
                    } else {
                        echo '<div class="borrowedBooksContainer">';
                        echo '<div class="table-container">';
                        echo '<table>
                                <thead>
                                    <tr>
                                        <th>Book Image</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Date Borrowed</th>
                                        <th>Date Due</th>
                                        <th>Return Book</th>
                                    </tr>
                                </thead>
                                <tbody>';

                            while ($row = $results->fetch_assoc()) {
                                $book_id = $row['book_id'];
                                $date_borrowed = $row['b_start_date'];
                                $date_due = $row['b_end_date'];
                            
                                echo '<tr>
                                        <td><img src="'.htmlspecialchars($row['image']).'" alt="Book Image"></td>
                                        <td>'.htmlspecialchars($row['title']).'</td>
                                        <td>'.htmlspecialchars($row['author']).'</td>
                                        <td>'.htmlspecialchars($date_borrowed).'</td>
                                        <td>'.htmlspecialchars($date_due).'</td>';
                                        

                                echo '<td>';
                                $sql = "SELECT * FROM bigbooks.return_books_transactions WHERE reference_id = ? AND b_status = 'Pending'";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("s", $row["transaction_id"]);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    echo '<button class="btn btn-secondary" disabled>Return (Pending)</button>';
                                } else {
                                    echo '<form method="post" action="returnBook.php">
                                        <input type="hidden" name="transaction_id" value="'.$row['transaction_id'].'">
                                        <input type="hidden" name="book_id" value="'.$book_id.'">
                                        <input type="hidden" name="returnDate" value="'.date('Y-m-d').'">
                                        <button class="btn btn-success" type="submit">Return</button>
                                    </form>';
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
                                

                        echo '</tbody></table>';
                        echo '</div>';

                        // Pagination links
                        $stmt->close();
                        $query_count = "SELECT COUNT(*) as total_records
                                        FROM bigbooks.borrow_books_transactions b
                                        INNER JOIN bigbooks.books bb ON b.book_id = bb.book_id
                                        WHERE b.borrowed_by = ? AND b.b_status = 'Approved'";
                        if (!empty($search_query)) {
                            $query_count .= " AND (bb.title LIKE ? OR bb.author LIKE ?)";
                        }
                        $stmt_count = $conn->prepare($query_count);
                        if ($stmt_count) {
                            if (!empty($search_query)) {
                                $search_query_param1 = "%$search_query%";
                                $search_query_param2 = "%$search_query%";
                                
                                $stmt_count->bind_param("sss", $student_ID, $search_query_param1, $search_query_param2);
                            } else {
                                $stmt_count->bind_param("s", $student_ID);
                            }
                            $stmt_count->execute();
                            $result_count = $stmt_count->get_result()->fetch_assoc();
                            $total_records = $result_count['total_records'];
                            $total_no_of_pages = ceil($total_records / $total_records_per_page);

                            echo '<nav aria-label="Page navigation">';
                            echo '<ul class="pagination">';
                            $prev_class = ($page_no <= 1) ? "disabled" : "";
                            $next_class = ($page_no >= $total_no_of_pages) ? "disabled" : "";
                            echo '<li class="page-item '.$prev_class.'">';
                            echo '<a class="page-link" href="?page_no='.($page_no - 1).'&search='.$search_query.'&category='.$category.'">Previous</a>';
                            echo '</li>';
                            for ($i = 1; $i <= $total_no_of_pages; $i++) {
                                $active_class = ($page_no == $i) ? "active" : "";
                                echo '<li class="page-item '.$active_class.'">';
                                echo '<a class="page-link" href="?page_no='.$i.'&search='.$search_query.'&category='.$category.'">'.$i.'</a>';
                                echo '</li>';
                            }
                            echo '<li class="page-item '.$next_class.'">';
                            echo '<a class="page-link" href="?page_no='.($page_no + 1).'&search='.$search_query.'&category='.$category.'">Next</a>';
                            echo '</li>';
                            echo '</ul>';
                            echo '</nav>';

                            $stmt_count->close();
                        } else {
                            echo "Error: " . $conn->error;
                        }
                        echo '</div>'; // Close container
                    }
                } else {
                    echo "Error: " . $conn->error;
                }

                $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
