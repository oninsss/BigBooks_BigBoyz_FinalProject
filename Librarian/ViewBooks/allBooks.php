<?php 
    $result = mysqli_query($conn, $books);
    while ($row = mysqli_fetch_assoc($result)) { 
        echo "<tr>";
            echo "<td>" . $row['book_id'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['author'] . "</td>";
            echo "<td>" . $row['category'] . "</td>";
            if ($row['status'] == 'Available') {
                echo "<td><span class='status-avail'>" . $row['status'] . "</span></td>";
            } elseif ($row['status'] == 'Unavailable') {
                echo "<td><span class='status-unavail'>" . $row['status'] . "</span></td>";
            } else {
                echo "<td><span class='status-archived'>" . $row['status'] . "</span></td>";
            }
            echo "<td>" . $row['stock'] . "</td>";
            echo "<td>" . 
                '<a href="bookDetails.php?book_id=' . $row['book_id'] . '" class="moreBtn">
                    <span class="material-symbols-outlined">
                        arrow_forward_ios
                    </span> 
                </a>' . 
            "</td>";

        echo "</tr>";
    }
?>
