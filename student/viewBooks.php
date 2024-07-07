<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            /* font-family: Arial, sans-serif; */
            background-color: #F3F2ED;
            margin: 0;
            padding: 0;
        }
        .bookscontainer {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            font-size: 2rem;
            color: #333;
        }
    
        .contTopPart {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .contBottomPart {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .books {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            overflow-y: auto;
        }
        .book {
            background-color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: ce;
            align-items: center;
            gap: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 20px;
            width: 250px;
            min-height: 550px;
            height: fit-content;
            overflow: hidden;
            transition: transform 0.3s;
        }
        .book img {
            width: 100%;
            max-height: 350px;
            height: auto;
        }
        .book h2 {
            font-size: 18px;
            font-weight: 600;
            text-align: center;
            color: #333;
            margin: 10px;
        }
        .book p {
            color: #666;
            font-size: 12px;
            margin: 10px;
        }
        .book a {
            display: block;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            padding: 10px;
            margin: 10px;
            margin-top: 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .book a:nth-child(1), .book .viewMore button{
            background-color: #28a745;
        }
        .book a:hover, .book .viewMore button:hover{
            background-color: #0056b3;
        }
        .book:hover {
            transform: scale(1.05);
        }
        .book-content {
            margin-top: 20px;
        }
        .pagination {
            display: flex;
            justify-content: center;
            list-style-type: none;
            padding: 0;
        }
        .pagination li {
            margin: 0 5px;
        }
        .pagination a {
            text-decoration: none;
            color: #007BFF;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .pagination a:hover {
            background-color: #0056b3;
            color: #fff;
        }
        .pagination .disabled a {
            color: #999;
            pointer-events: none;
        }

        /* to set the background color of the currently selected pagination */
        .pagination .active a{
            background-color: #1d1d1f;
            color: #fff;
        }

        .viewMore{
            display: flex;
            flex-direction: column;
            gap: 10px;
            justify-content: space-around;
            width: 100%;
            margin-bottom: 10px;
        }

        .viewMore a, .viewMore button{
            margin: 0;
            margin: 0 10px 0 10px;
            text-align: center;
        }


        #searchBar{
            height: 50px;
            width: fit-content;
            display: flex;
            /* background-color: #fff; */
            border-radius: 30px;
            padding: 10px 10px;
            align-items: center;
            transition: all 0.8s ease-in-out;
            
        }

        #searchBar:hover,
        #searchBar:focus-within{
            background-color: #fff;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        #searchBar:hover input{
            width: 400px;
            padding: 10px;
        }

        #searchBar input{
            width: 0;
            outline: none;
            border: none;
            background: transparent;
            transition: all 0.8s ease-in-out;
        }

        #searchBar input:focus,
        #searchBar:focus-within input{
            width: 400px;
            padding: 10px;
        }

        #searchBar input:focus > #searchBar{
            background-color: #fff;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        #searchBarIcon{
            padding: 0;
            transition: all 0.8s ease-in-out;
        }

        .dropdown ul li{
            font-size: 0.75rem;
        }

        .modal-body{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .modal-body .bookImage{
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 30px;
            justify-content: center;
            align-items: center;
        }

        .modal-body img{
            width: 200px;
            object-fit: cover;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.4);
        }

        hr{
            width: 100%;
            border: 2px solid #000;
        }

    </style>
</head>
<body>

    <div class="bookscontainer" id="_bookscontainer">
        

        <div class="contTopPart">
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
        </div>
        <div class="contBottomPart">
            <h1>Books</h1> 
            <?php
                if (isset($_GET['search'])) {
                    echo '<h6>Search results for "' . $_GET['search'] . '"</h6>';
                }
            ?>
            <div class="books">
            <?php
                include_once '../database.php';

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                

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

                // Construct base SQL query
                $sql = "SELECT * FROM bigbooks.books";
                $result_count_sql = "SELECT COUNT(*) as total_records FROM bigbooks.books";

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
                    $sql .= " WHERE " . implode(" AND ", $where_clause);
                    $result_count_sql .= " WHERE " . implode(" AND ", $where_clause);
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
                            $modalId = 'modal' . $row['id']; // Assuming 'id' is a unique identifier for each book
                    
                            echo '<div class="book">';
                            echo '<div class="topPart">';
                            echo '<img src="' . $row['image_link'] . '" alt="' . $row['title'] . '">';
                            echo '<div class="book-content">';
                            echo '<h2>' . $row['title'] . '</h2>';
                            echo '<p><strong>Author:</strong> ' . $row['author'] . '</p>';
                            echo '<p><strong>Published:</strong> ' . $row['publication_date'] . '</p>';
                            echo '<p><strong>Category:</strong> ' . $row['category'] . '</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="viewMore">';
                            echo '<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#' . $modalId . '">Borrow</button>';
                            echo '<div class="modal fade" id="' . $modalId . '" tabindex="-1" aria-labelledby="' . $modalId . 'Label" aria-hidden="true" data-backdrop="false">';
                            echo '<div class="modal-dialog modal-dialog-centered">';
                            echo '<div class="modal-content">';
                            echo '<div class="modal-header">';
                            echo '<h1 class="modal-title fs-5" id="' . $modalId . 'Label">Book Borrowing Confirmation</h1>';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                            echo '</div>';
                            echo '<div class="modal-body">';
                            echo '<div class="bookImage">';
                            echo '<img src="' . $row['image_link'] . '" alt="' . $row['title'] . '">'; 
                            echo '<h2>' . $row['title'] . '</h2>';
                            echo '</div>';
                            echo '<hr>';
                            echo '<p><strong>Author:</strong> ' . $row['author'] . '</p>';
                            echo '<p><strong>Published:</strong> ' . $row['publication_date'] . '</p>';
                            echo '<p><strong>Category:</strong> ' . $row['category'] . '</p>';
                            echo '
                            <form method="post" action="confirm_borrow.php">
                                <div class="form-group">
                                    <label for="start_date">Start Date:</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date:</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                </div>';
                            echo '</div>';
                            echo '<div class="modal-footer">';
                            echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
                            echo '<button type="button" class="btn btn-primary">Save changes</button>';
                            echo '</div>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '<script>document.body.appendChild(document.getElementById("' . $modalId . '"));</script>';
                            echo '<a href="' . $row['link'] . '" target="_blank">View more</a>';
                            echo '</div>';
                            echo '</div>';
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

        // JavaScript to handle showing alert in modal based on date inputs
        document.addEventListener('DOMContentLoaded', function() {
            // Select modal elements and date inputs
            var modals = document.querySelectorAll('.modal');
            var startDateInputs = document.querySelectorAll('.modal input#start_date');
            var endDateInputs = document.querySelectorAll('.modal input#end_date');

            // Function to show alert in modal
            function showAlert(modal, message) {
                var modalBody = modal.querySelector('.modal-body');
                var alertMessage = '<div class="alert alert-danger" role="alert">' + message + '</div>';
                modalBody.insertAdjacentHTML('beforeend', alertMessage);
            }

            // Function to remove alert from modal
            function removeAlert(modal) {
                var modalBody = modal.querySelector('.modal-body');
                var alert = modalBody.querySelector('.alert');
                if (alert) {
                    modalBody.removeChild(alert);
                }
            }

            //Function to check if the end date precedes the start date
            function checkDateOrder(startInput, endInput, modal) {
                var startDate = new Date(startInput.value);
                var endDate = new Date(endInput.value);

                if (endDate < startDate) {
                    return true;
                } else {
                    removeAlert(modal); // Remove alert if dates are valid
                    return false;
                }
            }

            // Function to check date difference and show/remove alert
            function checkDateDifference(startInput, endInput, modal) {
                var startDate = new Date(startInput.value);
                var endDate = new Date(endInput.value);

                // Calculate difference in milliseconds
                var difference = endDate.getTime() - startDate.getTime();
                var daysDifference = Math.floor(difference / (1000 * 60 * 60 * 24));

                // Show alert if difference is more than 7 days
                if (daysDifference > 7) {
                    // showAlert(modal, 'The difference between the start date and end date should not be more than 7 days.');
                    return true;
                } else {
                    removeAlert(modal); // Remove alert if dates are valid
                }
            }

            // Function to check if start date and end date are in the past
            function checkDates(startInput, endInput, modal) {
                var startDate = new Date(startInput.value);
                var endDate = new Date(endInput.value);

                // Check if either start date or end date is in the past
                var today = new Date();
                if (startDate < today || endDate < today) {
                    return true;
                } else {
                    removeAlert(modal); // Remove alert if dates are valid
                    return false;
                }
            }

            // Event listeners for date inputs change
            startDateInputs.forEach(function(input) {
                input.addEventListener('change', function() {
                    var modal = input.closest('.modal');
                    removeAlert(modal);
                    var endInput = modal.querySelector('input#end_date');
                    if (endInput.value) {
                        var a = checkDateDifference(input, endInput, modal);
                        var b = checkDates(input, endInput, modal);
                        var c = checkDateOrder(input, endInput, modal);

                        if (a || b || c) {
                            if (a) {
                                removeAlert(modal);
                                showAlert(modal, 'The difference between the start date and end date should not be more than 7 days.');
                            }
                            if (b) {
                                removeAlert(modal);
                                showAlert(modal, 'The start date or end date should not be in the past.');
                            }
                            if (c) {
                                removeAlert(modal);
                                showAlert(modal, 'The end date should not precede the start date.');
                            }
                        } else if (a && b) {
                            removeAlert(modal);
                            showAlert(modal, 'The difference between the start date and end date should not be more than 7 days.');
                            showAlert(modal, 'The start date or end date should not be in the past.');
                        } else if (a && c) {
                            removeAlert(modal);
                            showAlert(modal, 'The difference between the start date and end date should not be more than 7 days.');
                            showAlert(modal, 'The end date should not precede the start date.');
                        } else if (b && c) {
                            removeAlert(modal);
                            showAlert(modal, 'The start date or end date should not be in the past.');
                            showAlert(modal, 'The end date should not precede the start date.');
                        } else {
                            removeAlert(modal);
                        }

                        
                    } else {
                        removeAlert(modal); // Remove alert if end date is empty
                    }
                });
            });

            endDateInputs.forEach(function(input) {
                input.addEventListener('change', function() {
                    var modal = input.closest('.modal');
                    removeAlert(modal);
                    var startInput = modal.querySelector('input#start_date');
                    if (startInput.value) {
                        var a = checkDateDifference(startInput, input, modal);
                        var b = checkDates(startInput, input, modal);
                        var c = checkDateOrder(startInput, input, modal);

                        if (a || b || c) {
                            if (a) {
                                showAlert(modal, 'The difference between the start date and end date should not be more than 7 days.');
                            }
                            if (b) {
                                showAlert(modal, 'The start date or end date should not be in the past.');
                            }
                            if (c) {
                                showAlert(modal, 'The end date should not precede the start date.');
                            }
                        } else if (a && b) {
                            showAlert(modal, 'The difference between the start date and end date should not be more than 7 days.');
                            showAlert(modal, 'The start date or end date should not be in the past.');
                        } else if (a && c) {
                            showAlert(modal, 'The difference between the start date and end date should not be more than 7 days.');
                            showAlert(modal, 'The end date should not precede the start date.');
                        } else if (b && c) {
                            showAlert(modal, 'The start date or end date should not be in the past.');
                            showAlert(modal, 'The end date should not precede the start date.');
                        } else {
                            removeAlert(modal);
                        }
                        
                    } else {
                        removeAlert(modal); // Remove alert if start date is empty
                    }
                });
            });

        });
    </script>
    
</body>
</html>