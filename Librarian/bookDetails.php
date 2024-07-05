<?php
    include "../database.php";

    $book_id = mysqli_real_escape_string($conn, $_GET['book_id']);
    $query = "SELECT * FROM books WHERE book_id = '$book_id'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
    $book = mysqli_fetch_assoc($result);

    mysqli_close($conn);
?>

<style>
* {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
}

.details-modal {
    position: fixed;
    top: 45%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60%;
    min-width: 520px;
    height: auto;
    background-color: #E7E5D9;
    border-radius: 24px;
    padding: 64px 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.details-modal .left{
    width: 50%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.details-modal .left .imgBx {
    border-radius: 16px;
    overflow: hidden;
    filter: drop-shadow(0 0 0.75rem #333);
}

.details-modal .left img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.details-modal .right {
    width: 50%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: start;
}

.details-modal .right .textBx {
    width: 100%;
    padding: 16px;
}

.details-modal .right h1 {
    font-size: 3rem;
}

.details-modal .right p {
    font-size: 1.2rem;
}

.details-modal .right .btnGrp {
    width: 100%;
    display: flex;
    gap: 16px;
}

.details-modal .right .btnGrp button {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    background-color: #333;
    font-size: 1rem;
    color: #fff;
    cursor: pointer;
}

.details-modal .right .btnGrp button:hover {
    background-color: #555;
}

.details-modal .right .btnGrp button:active {
    background-color: #777;
}
</style>

<div class="details-modal">
    <div class="left">
        <div class="imgBx">
            <img src="<?php echo $book['image']; ?>" alt="Book Image">
        </div>
    </div>

    <div class="right">
        <div class="textBx">
            <?php
                echo "<h1>" . $book['title'] . "</h1>";
                echo "<p>Author: " . $book['author'] . "</p>";
                echo "<p>Publish Date: " . $book['publish_date'] . "</p>";
                echo "<p>Category: " . $book['category'] . "</p>";
                echo "<p>Status: " . $book['status'] . "</p>";
                echo "<p>Stock: " . $book['stock'] . "</p>";
                echo "<p>Synopsis: " . $book['synopsis'] . "</p>";
            ?>
        </div>
        <div class="btnGrp">
            <a href="#"><button>Archive</button></a>
            <a href="#"><button>Edit</button></a>
            <a href="#"><button>Delete</button></a>
        </div>
    </div>
</div>