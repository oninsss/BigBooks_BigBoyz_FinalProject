<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in (you might uncomment this for actual use)
if (!isset($_SESSION['student_id'])) {
    echo '<script>window.location.href = "../login.php";</script>';
    exit;
}

include_once '../database.php';

function hasPendingRequest($bookId, $conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM borrow_books_transactions WHERE book_id = ? AND b_status = 'Pending' AND borrowed_by = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $bookId, $_SESSION['student_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result) {
            $row = $result->fetch_assoc();
            if ($row && $row['count'] > 0) {
                return 'Pending';
            }
        }
    }
    return false;
}

function bookApproved($bookId, $conn) {
    $stmt = $conn->prepare("SELECT b_status FROM borrow_books_transactions WHERE book_id = ? AND b_status = 'Approved' AND borrowed_by = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $bookId, $_SESSION['student_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result) {
            $row = $result->fetch_assoc();
            if ($row && $row['b_status'] === 'Approved') {
                return 'Approved';
            }
        }
    }
    return false;
}

function canBorrowBook($bookId, $studentId, $conn) {
    // Count approved transactions for this book and user
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM borrow_books_transactions WHERE b_status = 'Approved' AND borrowed_by = ?");
    if ($stmt) {
        $stmt->bind_param("s", $studentId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result) {
            $row = $result->fetch_assoc();
            // Allow borrowing if there are less than 2 approved transactions
            return ($row['count'] < 2);
        }
    }
    return false;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="./Assets/Style/viewBooks.css" />
</head>
<body>

<div class="bookscontainer" id="_bookscontainer">
    <div class="contTopPart">
        <form class="searchBar" id="searchBar" method="get" action="index.php">
            <input type="hidden" name="page" value="viewBooks">
            <input type="hidden" name="page_no" value="1">
            <input class="form" name="search" type="search" placeholder="Search" aria-label="Search">
            <button class="btn success" type="submit">
                <span class="material-symbols-outlined" id="searchBarIcon">
                    search
                </span>
            </button>
        </form>
        <div class="dropdown">
            <form id="categoryForm" method="get" action="index.php">
                <input type="hidden" name="page" value="viewBooks">
                <input type="hidden" name="page_no" value="1">
                <input type="hidden" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <label for="categorySelect" class="visually-hidden">Select a category:</label>
                <select class="form-select" id="categorySelect" name="category" onchange="this.form.submit()">
                    <option value="">Select a category</option>
                    <option value="All" <?php if (isset($_GET['category']) && $_GET['category'] === 'All') echo 'selected'; ?>>All</option>
                    <option value="Fiction" <?php if (isset($_GET['category']) && $_GET['category'] === 'Fiction') echo 'selected'; ?>>Fiction</option>
                    <option value="Science Fiction" <?php if (isset($_GET['category']) && $_GET['category'] === 'Science Fiction') echo 'selected'; ?>>Science Fiction</option>
                    <option value="Fantasy" <?php if (isset($_GET['category']) && $_GET['category'] === 'Fantasy') echo 'selected'; ?>>Fantasy</option>
                    <option value="Mystery" <?php if (isset($_GET['category']) && $_GET['category'] === 'Mystery') echo 'selected'; ?>>Mystery</option>
                    <option value="Horror" <?php if (isset($_GET['category']) && $_GET['category'] === 'Horror') echo 'selected'; ?>>Horror</option>
                    <option value="Romance" <?php if (isset($_GET['category']) && $_GET['category'] === 'Romance') echo 'selected'; ?>>Romance</option>
                    <option value="Dystopian" <?php if (isset($_GET['category']) && $_GET['category'] === 'Dystopian') echo 'selected'; ?>>Dystopian</option>
                    <option value="Adventure" <?php if (isset($_GET['category']) && $_GET['category'] === 'Adventure') echo 'selected'; ?>>Adventure</option>
                    <option value="Historical" <?php if (isset($_GET['category']) && $_GET['category'] === 'Historical') echo 'selected'; ?>>Historical</option>
                    <option value="Non-Fiction" <?php if (isset($_GET['category']) && $_GET['category'] === 'Non-Fiction') echo 'selected'; ?>>Non-Fiction</option>
                </select>
            </form>
        </div>
    </div>
    <div class="contBottomPart">
        <h1>Books</h1>
        <?php
        if (isset($_GET['search'])) {
            if ($_GET['search'] == "") {
                echo '<h6>Showing all books</h6>';
            } else {
                echo '<h6>Search results for "' . $_GET['search'] . '"</h6>';
            }
        }
        ?>
        <div class="books">
            <?php

            // Get page and page number
            $page = isset($_GET['page']) ? $_GET['page'] : '';
            $page_no = isset($_GET['page_no']) && $_GET['page_no'] != "" ? $_GET['page_no'] : 1;
            $search_query = isset($_GET['search']) ? $_GET['search'] : '';
            $category = isset($_GET['category']) ? $_GET['category'] : '';

            if ($category === 'All') {
                $category = '';
            }

            // Total rows
            $total_records_per_page = 5;
            $offset = ($page_no - 1) * $total_records_per_page;

            $previous_page = $page_no - 1;
            $next_page = $page_no + 1;

            $sql = "SELECT * FROM bigbooks.books WHERE book_status = 'Available' AND stock >= 1";
            $result_count_sql = "SELECT COUNT(*) as total_records FROM bigbooks.books WHERE book_status = 'Available' AND stock >= 1";

            // Adjust SQL query based on search and category filters
            $where_clause = [];
            $params = [];

            if ($search_query) {
                $where_clause[] = "(title LIKE ? OR author LIKE ?)";
                $params[] = "%$search_query%";
                $params[] = "%$search_query%";
            }

            if ($category) {
                $where_clause[] = "category = ?";
                $params[] = $category;
            }

            // Combine WHERE conditions if needed
            if (!empty($where_clause)) {
                $sql .= " AND " . implode(" AND ", $where_clause);
                $result_count_sql .= " AND " . implode(" AND ", $where_clause);
            }

            $sql .= " LIMIT $offset, $total_records_per_page";

            // Get total number of pages
            $rstmt = $conn->prepare($result_count_sql);
            if ($rstmt) {
                // Bind parameters if any
                if (!empty($params)) {
                    $rstmt->bind_param(str_repeat('s', count($params)), ...$params);
                }

                // Execute query
                $rstmt->execute();

                // Get results
                $result_count = $rstmt->get_result();
            } else {
                echo "Error: " . $conn->error;
            }
            $records = $result_count->fetch_assoc();
            $total_records = $records['total_records'];

            $total_no_of_pages = ceil($total_records / $total_records_per_page);

            // Prepare and execute the query
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                // Bind parameters if any
                if (!empty($params)) {
                    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
                }

                // Execute query
                $stmt->execute();

                // Get results
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $modalId = 'modal' . $row['book_id']; // Unique modal ID for each book
                    
                        // Check if there is a pending request for this book
                        $isPendingRequest = hasPendingRequest($row['book_id'], $conn);
                        $isApproved = bookApproved($row['book_id'], $conn);
                        $canBorrow = canBorrowBook($row['book_id'], $_SESSION['student_id'], $conn);
                    
                        echo '<div class="book">';
                        echo '<div class="topPart">';
                        echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '">';
                        echo '<div class="book-content">';
                        echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
                        echo '<p><strong>Author:</strong> ' . htmlspecialchars($row['author']) . '</p>';
                        echo '<p><strong>Published:</strong> ' . htmlspecialchars($row['publish_date']) . '</p>';
                        echo '<p><strong>Category:</strong> ' . htmlspecialchars($row['category']) . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="viewMore">';
                    
                        if ($isPendingRequest === 'Pending') {
                            echo '<button type="button" class="btn btn-success" disabled>Borrowed (Pending)</button>';
                        } else if ($isApproved === 'Approved') {
                            echo '<button type="button" class="btn btn-success" disabled>Borrowed (Approved)</button>';
                        } else if (!$canBorrow) {
                            echo '<button type="button" class="btn btn-success" disabled>Maximum Borrowed</button>';
                        } else {
                            echo '<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#' . $modalId . '">Borrow</button>';
                        }
                        echo <<<HTML
                                <div class="modal fade" id="{$modalId}" tabindex="-1" aria-labelledby="{$modalId}Label" aria-hidden="true" data-backdrop="false">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="{$modalId}Label">Book Borrowing Confirmation</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="bookImage">
                                                    <img src="{$row['image']}" alt="{$row['title']}">
                                                    <h2>{$row['title']}</h2>
                                                </div>
                                                <hr>
                                                <p><strong>Author:</strong> {$row['author']}</p>
                                                <p><strong>Published:</strong> {$row['publish_date']}</p>
                                                <p><strong>Category:</strong> {$row['category']}</p>
                                                <form method="post" action="borrowTransaction.php">
                                                    <input type="hidden" name="book_id" value="{$row['book_id']}">
                                                    <input type="hidden" name="title" value="{$row['title']}">
                                                    <input type="hidden" name="author" value="{$row['author']}">
                                                    <div class="form-group">
                                                        <label for="start_date">Start Date:</label>
                                                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="end_date">End Date:</label>
                                                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" id="confirmButton">Confirm</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <script>document.body.appendChild(document.getElementById("{$modalId}"));</script>
                                <a href="index.php?page=viewBooksDetails&book_id={$row['book_id']}">View Details</a>
                            </div>
                        </div>
                        HTML;
                    }
                } else {
                    echo "<p>No results found</p>";
                }

                $stmt->close();
            } else {
                echo "Error: " . $conn->error;
            }

            $conn->close();
            ?>
            <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="successModalLabel">Success</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Your book borrowing request has been successfully submitted. Please proceed to the librarian and present your ID. Thank you!
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>document.body.appendChild(document.getElementById("successModal"))</script>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?php if ($page_no <= 1) echo 'disabled'; ?>">
                    <a class="page-link" <?php if ($page_no > 1) echo 'href="?page=viewBooks&page_no=' . $previous_page . '&search=' . $search_query . '"'; ?>>Previous</a>
                </li>
                <?php if ($search_query == "")  { ?>
                    <?php for ($i = 1; $i <= $total_no_of_pages; $i++) : ?>
                        <li class="page-item <?php if ($page_no == $i) echo 'active'; ?>">
                            <a class="page-link" href="?page=viewBooks&page_no=<?php echo $i; ?>&category=<?php echo $category?> "><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                <?php } else { ?>
                    <?php for ($i = 1; $i <= $total_no_of_pages; $i++) : ?>
                        <li class="page-item <?php if ($page_no == $i) echo 'active'; ?>">
                            <a class="page-link" href="?page=viewBooks&page_no=<?php echo $i; ?>&search=<?php echo $search_query; ?>&category=<?php echo 'category=' . $category?> "><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                <?php } ?>

                <li class="page-item <?php if ($page_no >= $total_no_of_pages) echo 'disabled'; ?>">
                    <a class="page-link" <?php if ($page_no < $total_no_of_pages) echo 'href="?page=viewBooks&page_no=' . $next_page . '&search=' . $search_query . '"'; ?>>Next</a>
                </li>
            </ul>
        </nav>
        <div class="p-10">
            <strong>Page <?php echo $page_no; ?> of <?php echo $total_no_of_pages; ?></strong>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="https://getbootstrap.com/docs/5.3/assets/js/docs.min.js"></script>
<script>
    document.getElementById('searchBar').addEventListener('submit', function(event) {
        console.log('Form submitted');
    });
</script>
<script src="./Assets/Script/validation.js"></script>
<?php if (isset($_SESSION['borrow_success']) && $_SESSION['borrow_success']) { ?>
    <script>
        var successModal = new bootstrap.Modal(document.getElementById('successModal'), {});
        successModal.show();
    </script>
    <?php unset($_SESSION['borrow_success']); ?>
<?php } ?>
</body>
</html>
