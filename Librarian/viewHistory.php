<?php
    include "../database.php";
    $users = "SELECT * FROM transactions";
?>

<div class="table-wrapper">
    <div class="header">
        <div class="titleBar">
            <h1>View History</h1>
        </div>
        <div class="bottom">
            <div class="inner-nav">
                <ul>
                    <li class="<?php echo (isset($_GET['subPage']) && $_GET['subPage'] == 'allUsers') ? 'active-subPage' : ''; ?>">
                        <a href="index.php?page=viewUsers&subPage=allUsers">All Users</a>
                    </li>
                </ul>
            </div>
        </div>

        <table class="history-list-header">
            <tr id="_header">
                <th>Student ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Email</th>
                <th>More</th>
            </tr>
        </table>
    </div>

    <table class="history-list">
        <?php
        switch ($subPage) {
            case 'allUsers':
                include 'ViewUsers/allUsers.php'; 
                break;
            default:
                echo '<tr><td colspan="5">No users to view.</td></tr>';
                break;
        }
        ?> 
    </table>
</div>