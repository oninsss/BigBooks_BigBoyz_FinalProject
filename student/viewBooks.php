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
            justify-content: space-between;
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
            color: #333;
            margin: 10px;
        }
        .book p {
            color: #666;
            font-size: 14px;
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
        .book a:nth-child(1) {
            background-color: #28a745;
        }
        .book a:hover {
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
            justify-content: space-around;
            width: 100%;
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

    </style>
</head>
<body>

    <div class="bookscontainer">

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
                            echo '<a href="#" target="_blank">Borrow</a>';
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
                        <?php for ($i = 1; $i <= $total_no_of_pages; $i++) : ?>
                            <li class="page-item <?php if ($page_no == $i) echo 'active'; ?>">
                                <a class="page-link" href="?page=viewBooks&page_no=<?php echo $i; ?>&search=<?php echo $search_query; ?>&category=<?php echo 'category=' . $category?> "><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
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
    <script>
        document.getElementById('searchBar').addEventListener('submit', function(event) {
            console.log('Form submitted');
        });
    </script>
</body>
</html>