<?php
    include "../database.php";
    include "BookActions/addBook.php";
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
                    <li class="<?php echo (isset($_GET['subPage']) && $_GET['subPage'] == 'unavailableBooks') ? 'active-subPage' : ''; ?>">
                        <a href="index.php?page=viewBooks&subPage=unavailableBooks">Unavailable</a>
                    </li>
                    <li class="<?php echo (isset($_GET['subPage']) && $_GET['subPage'] == 'archivedBooks') ? 'active-subPage' : ''; ?>">
                        <a href="index.php?page=viewBooks&subPage=archivedBooks">Archived</a>
                    </li>
                </ul>
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
        switch ($subPage) {
            case 'allBooks':
                include 'ViewBooks/allBooks.php'; 
                break;
            case 'availableBooks':
                include 'ViewBooks/availBooks.php'; 
                break;
            case 'unavailableBooks':
                include 'ViewBooks/unavailBooks.php'; 
                break;
            case 'archivedBooks':
                include 'ViewBooks/archivedBooks.php'; 
                break;
            default:
                echo '<tr><td colspan="7">Select a category to view books.</td></tr>';
                break;
        }
        ?> 
    </table>
</div>

<!-- <div class="pagination">
    <ul>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
    </ul>
</div> -->

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


        <form id="_addBook-form" action="index.php?page=viewBooks&subPage=allBooks" method="POST">
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

    document.querySelector('.close-modal').addEventListener('click', function() {
        document.querySelector('.addBook-modal-bg').style.display = 'none';
    });

    <?php if ($result):
    echo "
        showSuccessModal();
    ";
    endif; ?>

    function showSuccessModal() {
        var modal = document.getElementById("success-modal-bg");
        var span = document.querySelector(".close-modal");

        modal.style.display = "block";

        span.onclick = function() {
            modal.style.display = "none";
        }
    }
</script>