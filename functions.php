<?php
/* REQUIREMENTS
1. BOOK ID - the Book ID will be
GENERATED from the Book
Details
ex. THFEB102022-FIC00001
TH - First 2 letters from the Book Title
FEB – month (published)
10- day (added to the system)
2022 - year (published)
FIC - category of book ( FIC =
Fiction)
00001 - count of books on the
library

REQUIREMENTS
2. Only 2 BOOKS will be allowed
to be borrowed per student ( 7
days , included week ends)
3. Fine of P 10.00 per day per
book
4. Status of Book - you cannot
borrow an Archived Book and
cannot delete any book
5. Min of 50 books
6. Admin Account (Librarian), User
Account (Student)
*/
include("database.php");

function format_Id($name, $publish_date, $category, $count, $added_date) {
    $id = substr($name, 0, 2)                                               # First 2 letters from the Book Title
        . strtoupper(date('M', strtotime($publish_date)))                   # Month (published)
        . date('d', strtotime($added_date))                                 # Day (added to the system)
        . date('Y', strtotime($publish_date))                               # Year (published)
        . "-"                                                               # Separator                                     
        . strtoupper(substr($category, 0, 3))                               # Category of book ( FIC = Fiction)
        . str_pad($count, 5, "0", STR_PAD_LEFT);                            # Count of books on the library
    
    return $id;
}

function addBook($name, $author, $category, $status, $stock, $publish_date, $added_date) {
    global $conn;
    $count = 0;
    $query = "SELECT * FROM books";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);
    $count++;
    $book_id = format_Id($name, $publish_date, $category, $count, $added_date);
    $query = "INSERT INTO books (book_id, title, author, category, status, stock, publish_date, added_date) VALUES ('$book_id', '$name', '$author', '$category', '$status', '$stock', '$publish_date', '$added_date')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function editBook($id, $name, $author, $category, $status, $stock, $publish_date, $added_date) {
    global $conn;
    $query = "UPDATE books SET title = '$name', author = '$author', category = '$category', status = '$status', stock = '$stock', publish_date = '$publish_date', added_date = '$added_date' WHERE book_id = '$id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function archiveBook($id) {
    global $conn;
    $query = "UPDATE books SET status = 'Archived' WHERE book_id = '$id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function deleteBook($id) {
    global $conn;
    $query = "DELETE FROM books WHERE book_id = '$id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

?>