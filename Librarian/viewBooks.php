<?php
    include "../database.php";
    $books = "SELECT * FROM books";
?>

<div class="table-wrapper">
    <div class="header">
        <div class="titleBar">
            <h1>View Books</h1>
        </div>
        <div class="bottom">
            <div class="inner-nav">
                <ul>
                    <li class="<?php echo (isset($_GET['subPage']) && $_GET['subPage'] == 'allBooks') ? 'active-subPage' : ''; ?>">
                        <a href="index.php?page=viewBooks&subPage=allBooks">All Books</a>
                    </li>
                    <li class="<?php echo (isset($_GET['subPage']) && $_GET['subPage'] == 'availableBooks') ? 'active-subPage' : ''; ?>">
                        <a href="index.php?page=viewBooks&subPage=availableBooks">Available</a>
                    </li>
                    <li class="<?php echo (isset($_GET['subPage']) && $_GET['subPage'] == 'reservedBooks') ? 'active-subPage' : ''; ?>">
                        <a href="index.php?page=viewBooks&subPage=reservedBooks">Reserved</a>
                    </li>
                </ul>
            </div>
            <div class="btnGrp">
                <button>Add Book</button>
            </div>
        </div>

        <table class="book-list-header">
            <tr id="_header">
                <th>Book ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Stock</th>
                <th>More</th>
            </tr>
        </table>
    </div>

    <table class="book-list">
        <?php
        switch ($subPage) {
            case 'allBooks':
                include 'ViewBooks/allBooks.php'; 
                break;
            case 'availableBooks':
                include 'ViewBooks/availBooks.php'; 
                break;
            case 'reservedBooks':
                include 'ViewBooks/reservedBooks.php'; 
                break;
            default:
                echo '<tr><td colspan="7">Select a category to view books.</td></tr>';
                break;
        }
        ?> 
    </table>


</div>