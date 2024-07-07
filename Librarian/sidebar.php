<div id="_sidebar" class="sidebar">
    <a href="index.php" class="logo">
        <img src="../Assets/Images/library-logo.png" alt="Logo">
    </a>

    <nav class="nav">
        <ul>     
            <a href="index.php?page=viewBooks">
                <li class="nav-item <?php echo ($_GET['page'] == 'viewBooks') ? 'active-page' : ''; ?>">
                    <span class="material-symbols-outlined">
                        library_books
                    </span>
                    <span class="icon-text">Books</span>
                </li>
            </a>        
            <a href="index.php?page=viewUsers">
                <li class="nav-item <?php echo ($_GET['page'] == 'viewUsers') ? 'active-page' : ''; ?>">
                    <span class="material-symbols-outlined">
                        person
                    </span>
                    <span class="icon-text">Students</span>
                </li>
            </a>       
            <a href="index.php?page=history">
                <li class="nav-item <?php echo ($_GET['page'] == 'history') ? 'active-page' : ''; ?>">
                    <span class="material-symbols-outlined">
                        history
                    </span>
                    <span class="icon-text">View History</span>
                </li>
            </a>   
            <a href="../logout.php">
                <li class="nav-item">
                    <span class="material-symbols-outlined">
                        logout
                    </span>
                    <span class="icon-text">Logout</span>
                </li>
            </a>
        </ul>
    </nav>
</div>

<script>
    document.getElementById('_toggle-sidebar').addEventListener('click', function() {
        var sidebar = document.getElementById('_sidebar');
        sidebar.classList.toggle('hidden');
    });

    window.addEventListener('resize', function() {
        var sidebar = document.getElementById('_sidebar');
        if (window.innerWidth > 768) {
            sidebar.classList.remove('hidden');
        } else {
            sidebar.classList.add('hidden');
        }
    });
</script>
