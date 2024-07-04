<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "../database.php";

$books = "SELECT * FROM books";
?>

<style>

.wrapper {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: start;
    align-items: center;
}

.header {
    width: 95%;
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

table {
    width: 95%;
    border-spacing: 0 20px;
    overflow-y: scroll;
}

th, td {
    padding: 24px;
    text-align: left;
    background-color: #F4F4F4;
}

tr {
    border: 1px solid #F4F4F4;
}

td:first-child,
th:first-child {
  border-radius: 14px 0 0 14px;
}

td:last-child,
th:last-child {
  border-radius: 0 14px 14px 0;
}

th:last-child,
td:last-child {
    display: flex;
    justify-content: start;
    align-items: center;
    text-align: center;
}

</style>

<div class="wrapper">
    <div class="header">
        <div class="titleBar">
            <h1>View Books</h1>
        </div>
        <div class="bottom">
            <div class="inner-nav">
                <ul>
                    <li><a href="index.php?page=allView">All Books</a></li>
                    <li><a href="index.php?page=availableView">Available</a></li>
                    <li><a href="index.php?page=reservedView">Reserved</a></li>
                </ul>
            </div>
            <div class="btnGrp">
                <button>Add Book</button>
            </div>
        </div>
    </div>

    <table class="bookList">
        <tr id="_header">
            <th>Book ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Publish Date</th>
            <th>Category</th>
            <th>Status</th>
            <th>More</th>
        </tr>

        <?php 
            $result = mysqli_query($conn, $books);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['author'] . "</td>";
                    echo "<td>" . $row['publish_date'] . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>"
                    . '<span class="material-symbols-outlined">arrow_forward_ios</span>' 
                    . "</td>";
                echo "</tr>";
            }
        ?>
    </table>
</div>
