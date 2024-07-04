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
include("books.json");

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

$retrieved = "SELECT * FROM books";
$result = mysqli_query($conn, $retrieved);

if ($result->num_rows > 0) {
    $titles = [];
    $authors = [];
    $publication_dates = [];
    $categories = [];
    $links = [];
    $image_links = [];

    while($row = $result->fetch_assoc()) {
        $titles[] = $row['title'];
        $authors[] = $row['author'];
        $publication_dates[] = $row['publish_date'];
        $categories[] = $row['category'];
        $links[] = $row['link'];
        $image_links[] = $row['image'];
    }

    echo "Titles:\n";
    print_r($titles);
    echo "\nAuthors:\n";
    print_r($authors);
    echo "\nPublication Dates:\n";
    print_r($publication_dates);
    echo "\nCategories:\n";
    print_r($categories);
    echo "\nLinks:\n";
    print_r($links);
    echo "\nImage Links:\n";
    print_r($image_links);
} else {
    echo "0 results";
}

$conn->close();
?>