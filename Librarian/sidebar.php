<div id="_sidebar" class="sidebar">
    <a href="index.php" class="logo">
        <img src="../Assets/Images/library-logo.png" alt="Logo">
    </a>

    <nav class="nav">
        <ul>     
            <a href="index.php?page=viewBooks">
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'viewBooks') ? 'active-page' : ''; ?>">
                    <span class="material-symbols-outlined">
                        library_books
                    </span>
                    <span class="icon-text">Books</span>
                </li>
            </a>        
            <a href="index.php?page=viewUsers">
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'viewUsers') ? 'active-page' : ''; ?>">
                    <span class="material-symbols-outlined">
                        person
                    </span>
                    <span class="icon-text">Students</span>
                </li>
            </a>
            <a href="index.php?page=viewRequests">
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'viewRequests') ? 'active-page' : ''; ?>">
                    <span class="material-symbols-outlined">
                        sms
                    </span>
                    <span class="icon-text">Requests</span>
                </li>     
            <a href="index.php?page=viewTransactions">
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'viewTransactions') ? 'active-page' : ''; ?>">
                    <span class="material-symbols-outlined">
                        history
                    </span>
                    <span class="icon-text">Transactions</span>
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
    const toggleSidebar = document.getElementById('_toggle-sidebar');
    const sidebar = document.getElementById('_sidebar');

    toggleSidebar.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 1024) {
            sidebar.classList.remove('active');
        }
    });
</script>
