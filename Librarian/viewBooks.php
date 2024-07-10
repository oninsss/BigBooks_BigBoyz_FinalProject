<?php
    include "../database.php";
    include "BookActions/addBook.php";
?>

<div class="table-wrapper">
    <div class="header">
        <div class="titleBar">
            <span class="material-symbols-outlined" id="_sidebar-toggle">
                menu
            </span>
            <h1>View Books</h1>
        </div>
        <div class="bottom">
            <div class="inner-nav">
                <form method="GET" action="index.php">
                    <input type="hidden" name="page" value="viewBooks">
                    <div class="searchBar">
                        <input 
                            type="text" 
                            name="search" 
                            value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" 
                            placeholder="Search Record">
                        <button type="submit" id="_search">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                    </div>
                    <div class="filter">
                        <select name="status-filter" id="_status-filter">
                            <option value="">All Status</option>
                            <option value="availableBooks" <?php if(isset($_GET['category-filter']) && $_GET['category-filter'] == 'availableBooks') echo 'selected'; ?>>Available</option>
                            <option value="unavailableBooks" <?php if(isset($_GET['category-filter']) && $_GET['category-filter'] == 'unavailableBooks') echo 'selected'; ?>>Unavailable</option>
                            <option value="archivedBooks" <?php if(isset($_GET['category-filter']) && $_GET['category-filter'] == 'archivedBooks') echo 'selected'; ?>>Archived</option>
                        </select>
                        <select name="category-filter" id="_category-filter">
                            <option value="">All Categories</option>
                            <option value="Fiction" <?php if(isset($_GET['status-filter']) && $_GET['status-filter'] == 'Fiction') echo 'selected'; ?>>Fiction</option>
                            <option value="Non-Fiction" <?php if(isset($_GET['status-filter']) && $_GET['status-filter'] == 'Non-Fiction') echo 'selected'; ?>>Non-Fiction</option>
                            <option value="Reference" <?php if(isset($_GET['status-filter']) && $_GET['status-filter'] == 'Reference') echo 'selected'; ?>>Reference</option>
                            <option value="Educational" <?php if(isset($_GET['status-filter']) && $_GET['status-filter'] == 'Educational') echo 'selected'; ?>>Educational</option>
                            <option value="Children" <?php if(isset($_GET['status-filter']) && $_GET['status-filter'] == 'Children') echo 'selected'; ?>>Children</option>
                            <option value="Graphic Novel" <?php if(isset($_GET['status-filter']) && $_GET['status-filter'] == 'Graphic Novel') echo 'selected'; ?>>Graphic Novel</option>
                            <option value="Drama" <?php if(isset($_GET['status-filter']) && $_GET['status-filter'] == 'Drama') echo 'selected'; ?>>Drama</option>
                        </select>
                        <button type="submit" id="_filter-btn">
                            <p>Filter</p>
                        </button>
                    </div>
                </form>
            </div>
            <div class="btnGrp">    
                <button id="_addBook">Add Book</button>
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
            $query = "SELECT * FROM books WHERE 1=1";

            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = mysqli_real_escape_string($conn, $_GET['search']);
                $query .= " AND (title LIKE '%$search%' OR author LIKE '%$search%')";
            }

            if (isset($_GET['status-filter']) && !empty($_GET['status-filter'])) {
                $statusFilter = mysqli_real_escape_string($conn, $_GET['status-filter']);
                if ($statusFilter == 'availableBooks') {
                    $query .= " AND stock > 0 AND status = 'Available'";
                } elseif ($statusFilter == 'unavailableBooks') {
                    $query .= " AND stock = 0 AND status = 'Unavailable'";
                } elseif ($statusFilter == 'archivedBooks') {
                    $query .= " AND status = 'Archived'";
                }
            }

            if (isset($_GET['category-filter']) && !empty($_GET['category-filter'])) {
                $categoryFilter = mysqli_real_escape_string($conn, $_GET['category-filter']);
                $query .= " AND category = '$categoryFilter'";
            }

            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    if ($row['status'] == 'Available') {
                        echo "<td><span class='status-avail'>" . $row['status'] . "</span></td>";
                    } elseif ($row['status'] == 'Unavailable') {
                        echo "<td><span class='status-unavail'>" . $row['status'] . "</span></td>";
                    } else {
                        echo "<td><span class='status-archived'>" . $row['status'] . "</span></td>";
                    }
                    echo "<td>" . $row['stock'] . "</td>";
                    echo "<td><a href='bookDetails.php?book_id=" . $row['book_id'] . "' class='moreBtn'><span class='material-symbols-outlined'>arrow_forward_ios</span></a></td>";
                    echo "</tr>";
                    
                }
            } else {
                echo "<tr><td colspan='6'>No books found</td></tr>";
            }
        ?>
    </table>
</div>

<div class="addBook-modal-bg">
    <div class="addBook-modal">
        <div class="modal-header">
            <h1>Add Book</h1>
            <button class="close-modal">
                <span class="material-symbols-outlined">
                    close
                </span>
            </button>
        </div>


        <form id="_addBook-form" action="index.php?page=viewBooks" method="POST">
            <div class="input-group">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        id="_title" 
                        class="form-control" 
                        placeholder="eg. Goosebumps: The Haunted Mask" 
                        required>
                </div>
                <div class="form-group">
                    <label for="author">Author</label>
                    <input 
                        type="text" 
                        name="author" 
                        id="_author" 
                        class="form-control" 
                        placeholder="eg. R. L. Stine"
                        required>
                </div>
            </div>

            <div class="input-group">
                <div class="form-group">
                    <label for="category">Publish Date</label>
                    <input 
                        type="date" 
                        name="publishDate" 
                        id="_publishDate" 
                        class="form-control"
                        required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="_category">
                        <option value="Fiction">Fiction</option>
                        <option value="Non-Fiction">Non-Fiction</option>
                        <option value="Reference">Reference</option>
                        <option value="Educational">Educational</option>
                        <option value="Children">Children</option>
                        <option value="Graphic Novel">Graphic Novel</option>
                        <option value="Drama">Drama</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="synopsis">Synopsis</label>
                <textarea
                    form ="_addBook-form" 
                    name="synopsis" 
                    id="_synopsis" 
                    wrap="soft"></textarea>
            </div>

            <div class="input-group">
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input 
                        type="number"
                        min="0" 
                        name="stock" 
                        id="_stock" 
                        class="form-control" 
                        required>
                </div>
                <div class="form-group">
                    <label for="image">Upload Image</label>
                    <input type="file" name="image" id="_image">
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add Book</button>
            </div>
        </form>


    </div>
</div>

<div class="success-modal-bg">
    <div class="success-modal">
        <div class="success-modal-content">
            <div class="modal-body">
                <p>Book has been added successfully.</p>
            </div>
            <div class="modal-footer">
                <button class="close-modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
document.getElementById('_addBook').addEventListener('click', function() {
    document.querySelector('.addBook-modal-bg').style.display = 'flex';
});

var closeModalButtons = document.querySelectorAll('.close-modal');
closeModalButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        document.querySelector('.addBook-modal-bg').style.display = 'none';
        document.querySelector('.success-modal-bg').style.display = 'none';
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('_publishDate').setAttribute('max', today);
});

function showSuccessModal() {
    var modal = document.querySelector(".success-modal-bg");
    modal.style.display = "block";
}

<?php if ($addSuccess): ?>
showSuccessModal();
<?php endif; ?>

</script>