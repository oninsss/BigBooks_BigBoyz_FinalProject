<?php
    include "../database.php";
?>

<div class="table-wrapper">
    <div class="header">
        <div class="titleBar">
            <span class="material-symbols-outlined" id="_sidebar-toggle">
                menu
            </span>
            <h1>View Students</h1>
        </div>
        <div class="bottom">
            <div class="inner-nav">
                <form method="GET" action="index.php">
                <input type="hidden" name="page" value="viewUsers">
                    <div class="searchBar">
                        <input 
                            type="text" 
                            name="search" 
                            value="<?php if(isset($_GET['search'])){echo htmlspecialchars($_GET['search']); } ?>" 
                            placeholder="Search Student">
                        <button type="submit" id="_search">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <table class="student-list-header">
            <tr id="_header">
                <th>Student ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Email</th>
                <th>More</th>
            </tr>
        </table>
    </div>

    <table class="student-list">
        <?php
            $query = "SELECT * FROM user WHERE 1=1";

            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = mysqli_real_escape_string($conn, $_GET['search']);
                $query .= " AND (user_id LIKE '%$search%' OR lastname LIKE '%$search%' OR firstname LIKE '%$search%' OR email LIKE '%$search%')";
            }

            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . 
                            '<a href="userDetails.php?user_id=' . htmlspecialchars($row['user_id']) . '" class="moreBtn">
                                <span class="material-symbols-outlined">
                                    arrow_forward_ios
                                </span> 
                            </a>' . 
                        "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No users found</td></tr>";
            }
        ?>
    </table>
</div>
