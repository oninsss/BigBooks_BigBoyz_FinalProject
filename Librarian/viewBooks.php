<?php
include "../database.php";

$books = "SELECT * FROM books";
?>

<style>
.table-wrapper {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: start;
    align-items: center;
}

.header {
    width: 90%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    .titleBar {
        width: 100%;
        display: flex;
        justify-content: start;
        align-items: center;
        padding: 32px 0;
    }

    .bottom {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        
        .inner-nav {
            width: 40%;
            min-width: 300px;

            ul {
                width: 100%;
                display: flex;
                gap: 48px;
                list-style: none;

                li {

                    a {
                        text-decoration: none;
                        color: #333;
                        font-size: 1rem;
                        font-weight: 500;
                        transition: all 0.3s ease;
                    }
                }
            }
        }

        .btnGrp {
            display: flex;
            gap: 16px;

            button {
                padding: 12px 24px;
                border: none;
                border-radius: 8px;
                background-color: #333;
                color: #F4F4F4;
                font-size: 1rem;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.3s ease;
            }
        }
    }
}

.book-list {
    width: 92%;
    border-spacing: 0 20px;
}

th, td {
    padding: 24px;
    text-align: left;
    background-color: #F4F4F4;
}

td:first-child,
th:first-child {
  border-radius: 14px 0 0 14px;
}

td:last-child,
th:last-child {
  border-radius: 0 14px 14px 0;
}

.status-avail {
    color: green;
}

.status-unavail {
    color: red;
}

.status-archived {
    color: blue;
}

.active-subPage {
    color: #333;
    font-weight: 500;
    border-bottom: 2px solid #333;
}

.moreBtn {
    width: 40px;
    height: 40px;
    background-color: transparent;
    border: none;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #333;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    
    &:hover {
        background-color: #EEE;
        transform: scale(1.1);
    }
}
</style>

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
    </div>

    <table class="book-list">
        <tr id="_header">
            <th>Book ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Status</th>
            <th>Stock</th>
            <th>More</th>
        </tr>

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