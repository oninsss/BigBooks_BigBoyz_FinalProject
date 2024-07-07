<?php 
    $result = mysqli_query($conn, $users);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['last_name'] . "</td>";
            echo "<td>" . $row['first_name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . 
                '<a href="userDetails.php?user_id=' . $row['user_id'] . '" class="moreBtn">
                    <span class="material-symbols-outlined">
                        arrow_forward_ios
                    </span> 
                </a>' . 
            "</td>";

        echo "</tr>";
    }
?>