<?php
include "../database.php";

$users = "SELECT * FROM users";
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

.status-reserved {
    color: red;
}

.status-archived {
    color: blue;
}
</style>

<div class="table-wrapper">
    <div class="header">
        <div class="titleBar">
            <h1>View Users</h1>
        </div>
        <div class="bottom">
            <div class="inner-nav">
                <ul>
                    <li><a href="index.php?page=viewUsers&subPage=allUsers">All Users</a></li>
                </ul>
            </div>
        </div>
    </div>

    <table class="book-list">
        <tr id="_header">
            <th>User ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Contact no.</th>
            <th>Email</th>
            <th>More</th>
        </tr>

        <?php
        $subPage = isset($_GET['subPage']) ? filter_input(INPUT_GET, 'subPage', FILTER_SANITIZE_STRING) : '';

        switch ($subPage) {
            case 'allUsers':
                include 'ViewUsers/allUsers.php'; 
                break;
            default:
                echo '<tr><td colspan="6">No users to view.</td></tr>';
                break;
        }
        ?> 
    </table>
</div>