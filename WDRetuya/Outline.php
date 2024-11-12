<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: SignIn.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://img.freepik.com/free-vector/white-minimal-hexagons-background_79603-1452.jpg?semt=ais_hybrid') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .Outline-container {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            width: 400px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #444;
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #333;
        }

        a {
            display: inline-block;
            padding: 12px 24px;
            background: lightgreen;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
            transition: background 0.3s ease;
        }

        a:hover {
            background: lightgreen;
        }
    </style>
    <script>
        function confirmLogout(event) {
            event.preventDefault();
            
            var confirmAction = confirm("Are you sure you want to log out?");
            
            if (confirmAction) {
                window.location.href = 'LogOut.php';
            }
        }
    </script>
</head>
<body>
    <div class="Outline-container">
        <?php
            echo "<h2>Sign In Successful!</h2>";
            echo "<p>Hello, " . $_SESSION['user'] . "</p>";
            echo "<a href='#' onclick='confirmLogout(event)'>Logout</a>";
        ?>
    </div>
</body>
</html>
