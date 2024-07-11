<!-- 1. BOOK ID - the Book ID will be
GENERATED from the Book
Details
ex. THFEB102022-FIC00001
TH - First 2 letters from the Book Title
FEB – month (published)
10- day (added to the system)
2022 - year (published)
FIC - category of book ( FIC =
Fiction)
00001 - count of books on the
library

REQUIREMENTS
2. Only 2 BOOKS will be allowed
to be borrowed per student ( 7
days , included week ends)
3. Fine of P 10.00 per day per
book
4. Status of Book - you cannot
borrow an Archived Book and
cannot delete any book
5. Min of 50 books
6. Admin Account (Librarian), User
Account (Student) -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            width: 500px;
            height: 450px;

            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            background-color: #1d1d1f;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .topPart {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .bottomPart {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .topPart img{
            width: 300px;
            margin-top: 30px;
            box-shadow: 0 25px 25px (0, 0, 0, 0.4);
        }

        .buttons {
            display: flex;
            gap: 10px;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button a {
            text-decoration: none;
            color: #fff;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="topPart">
                <img src="./Assets/Images/BigBooksLogo2.png" alt="">
            </div>
            <div class="bottomPart">
                <buttons>
                    
                    <button class="btn btn-secondary">
                        <a href="./Librarian/login.php">Log in as Admin</a>
                    </button>
                    <button class="btn btn-primary">
                        <a href="./student/login.php">Log in as Student</a>
                    </button>
                </buttons>
            </div>
        </div>
    </div>
</body>
</html>