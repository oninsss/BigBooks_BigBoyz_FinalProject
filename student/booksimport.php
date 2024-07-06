<?php
    require '../database.php';
    $jsonfile = file_get_contents('../books.json');
    $data = json_decode($jsonfile, true);

    foreach ($data as $row){
        $title = $conn->real_escape_string($row['title']);
        $author = $conn->real_escape_string($row['author']);
        $publication_date = $conn->real_escape_string($row['publication_date']);
        $category = $conn->real_escape_string($row['category']);
        $link = $conn->real_escape_string($row['link']);
        $image_link = $conn->real_escape_string($row['image_link']);

        // <!-- 1. BOOK ID - the Book ID will be
        // GENERATED from the Book
        // Details
        // ex. THFEB102022-FIC00001
        // TH - First 2 letters from the Book Title
        // FEB – month (published)
        // 10- day (added to the system)
        // 2022 - year (published)
        // FIC - category of book ( FIC =
        // Fiction)
        // 00001 - count of books on the
        // library -->

        $sql = "SELECT COUNT(*) as count FROM books";
        $result = $conn->query($sql);
        $count = $result->fetch_assoc()['count'];


        $bookid = strtoupper(substr($title, 0, 2)) . strtoupper(date('M', strtotime($publication_date))) . date('d', strtotime($publication_date)) . date('Y', strtotime($publication_date)) . '-' . strtoupper(substr($category, 0, 3)) . sprintf("%05d", $count + 1);

        $sql = "INSERT INTO books (id, title, author, publication_date, category, link, image_link) 
                VALUES ('$bookid','$title', '$author', '$publication_date', '$category', '$link', '$image_link')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully\n";
        } else {
            echo "Error: " . $sql . "\n" . $conn->error;
        }
    }

    $conn->close();

?>