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
        <a href="index.php?page=welcomePage" class="logo">
            <img src="../Assets/Images/BigBooksLogo2.png" alt="Logo">
            <h1>Big Books</h1>
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
                <a href="index.php?page=borrowedBooks">
                    <span class="material-symbols-outlined">
                        pending_actions
                    </span>
                    <span class="icon-text">Borrowed Book</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=viewPayments">
                    <span class="material-symbols-outlined">
                        payments
                    </span>
                    <span class="icon-text">Payments</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=viewHistory">
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
