<style>
.sidebar {
    position: sticky;
    top: 0;
    left: 0;
    background-color: #F3F2ED;
    width: 240px;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: start;
    align-items: center;
    gap: 72px;
    transition: all 0.3s ease;
    overflow-x: hidden;
    overflow-y: auto;
}

.sidebar > a {
    margin-top: 32px;
}

.sidebar > a img {
    height: 50px;
}

.sidebar .nav {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.sidebar .nav ul {
    display: flex;
    flex-direction: column;
    gap: 18px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar .nav ul a {
    width: 100%;
    border-radius: 8px;
    transition: all 0.3s ease;
    text-decoration: none;

    &:hover {
        background-color: rgba(0, 0, 0, 0.1);

    }
}

.sidebar .nav ul a li {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 16px;
    color: #333;
    font-size: 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
    padding: 12px 24px;
}

.sidebar .nav ul a li .icon-text {
    display: inline;
}

.active-page {
    background-color: #333;
    border-radius: 8px;

    span {
        color: #F3F2ED;
    }

}

@media (max-width: 768px) {
    .sidebar {
        width: 0;
    }

    .toggle-sidebar-btn {
        display: block;
    }
}
</style>

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
                    <span class="icon-text">View Books</span>
                </li>
            </a>        
            <a href="index.php?page=viewUsers">
                <li class="nav-item <?php echo ($_GET['page'] == 'viewUsers') ? 'active-page' : ''; ?>">
                    <span class="material-symbols-outlined">
                        person
                    </span>
                    <span class="icon-text">View Users</span>
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
            <a href="logout.php">
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
