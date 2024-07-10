<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<head>
    <link rel="stylesheet" href="./Assets/Style/sidebar.css" />
</head>

<div id="_sidebar" class="sidebar">
    <nav class="nav">
        <a href="index.php" class="logo">
            <img src="../Assets/Images/library-logo.png" alt="Logo">
            <h1>Lorem Ipsum</h1>
        </a>
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
