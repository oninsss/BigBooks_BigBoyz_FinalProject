<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
.topbar {
    position:sticky;
    top: 0;
    background-color: #F3F2ED;
    width: 100%;
    height: 96px;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2;
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.topbar .nav {
    width: 95%;
    height: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.topbar .nav a {
    display: flex;
    align-items: end;
    gap: 16px;
    text-decoration: none;
    color: #333;
}

.topbar .nav a img {
    width: 40px;

}

h1 {
    text-align: left;
    font-size: 1.5rem;
}

.topbar .nav .profileBx {
    border: 1px solid #333;
    border-radius: 12px;
    width: 160px;
    height: 48px;
    display: flex;
    align-items: center;
    gap: 16px;
}

.toggle-sidebar-btn {
    display: none;
    color: #333;
    padding: 6px;
    border: 1px solid #333;
    border-radius: 6px;
    cursor: pointer;
    z-index: 1;

    span {
        font-size: 2rem;
    }
}
</style>

<div class="topbar">
    <div class="nav">
        
        <button id="_toggle-sidebar" class="toggle-sidebar-btn">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <a href="index.php" class="logo">
            <img src="../Assets/Images/library-logo.png" alt="Logo">
            <h1>Lorem Ipsum</h1>
        </a>
        

        <div class="profileBx">
            <!-- <img src="../Assets/Images/user.png" alt="Profile Picture">
            <span><?php echo $_SESSION['username']; ?></span> -->
        </div>
    </div>
</div>