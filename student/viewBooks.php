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
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .bookscontainer {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
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
        .viewMore{
            display: flex;
            justify-content: space-around;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="bookscontainer">
        <h1>Books</h1>
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

                // Total rows 
                $total_records_per_page = 5;
                $offset = ($page_no - 1) * $total_records_per_page;
                
                $previous_page = $page_no - 1;
                $next_page = $page_no + 1;

                $result_count = $conn->query("SELECT COUNT(*) as total_records FROM bigbooks.books") or die($conn->error);
                $records = $result_count->fetch_assoc();
                $total_records = $records['total_records'];

                $total_no_of_pages = ceil($total_records / $total_records_per_page);

                $sql = "SELECT * FROM bigbooks.books LIMIT $offset, $total_records_per_page";
                $result = $conn->query($sql) or die($conn->error);

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
                $conn->close();
            ?>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?php if ($page_no <= 1) echo 'disabled'; ?>">
                    <a class="page-link" <?php if ($page_no > 1) echo 'href="?page=viewBooks&page_no=' . $previous_page . '"'; ?>>Previous</a>
                </li>
                <?php for ($i = 1; $i <= $total_no_of_pages; $i++) : ?>
                    <li class="page-item <?php if ($page_no == $i) echo 'active'; ?>">
                        <a class="page-link" href="?page=viewBooks&page_no=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($page_no >= $total_no_of_pages) echo 'disabled'; ?>">
                    <a class="page-link" <?php if ($page_no < $total_no_of_pages) echo 'href="?page=viewBooks&page_no=' . $next_page . '"'; ?>>Next</a>
                </li>
            </ul>
        </nav>
        <div class="p-10">
            <strong>Page <?php echo $page_no; ?> of <?php echo $total_no_of_pages; ?></strong>
        </div>
    </div>
</body>
</html>
