<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

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
    gap: 48px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar .nav ul li {
    width: 100%;
}

.sidebar .nav ul li a {
    display: flex;
    align-items: center;
    gap: 16px;
    text-decoration: none;
    color: #333;
    font-size: 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.sidebar .nav ul li a .icon-text {
    display: inline;
}

@media (max-width: 768px) {
    .sidebar {
        display: none;
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
            <li class="nav-item">
                <a href="index.php?page=viewBooks">
                    <span class="material-symbols-outlined">
                        library_books
                    </span>
                    <span class="icon-text">View Books</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=borrowBook">
                    <span class="material-symbols-outlined">
                        add_circle
                    </span>
                    <span class="icon-text">Borrowed Book</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=viewRequests">
                    <span class="material-symbols-outlined">
                        pending_actions
                    </span>
                    <span class="icon-text">View your requests</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=history">
                    <span class="material-symbols-outlined">
                        history
                    </span>
                    <span class="icon-text">View History</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="logout.php">
                    <span class="material-symbols-outlined">
                        logout
                    </span>
                    <span class="icon-text">Logout</span>
                </a>
            </li>
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
