<?php
// Start session and connect to the database
session_start();
include 'DataBase.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    // Collect form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birthdate = $_POST['birthdate'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Check if the email already exists in the database
        $stmt = $conn->prepare("SELECT * FROM signup WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Email is already taken!');</script>";
        } else {
            // Hash the password before saving it to the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into the database
            $stmt = $conn->prepare("INSERT INTO signup (email, password, first_name, last_name, birthdate, confirm_password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $email, $hashed_password, $first_name, $last_name, $birthdate, $confirm_password);

            if ($stmt->execute()) {
                echo "<script>alert('Sign up successful!'); window.location.href = 'SignIn.php';</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://mirror.pia.gov.ph/uploads/2024/02/ec0e7115fc6129c8804fb8108b955535-800-1200.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            width: 700px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #444;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            width: 100%;
        }

        input[type="email"], input[type="password"], input[type="text"], input[type="date"] {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        input:focus {
            border-color: #00aaff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #00aaff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            grid-column: span 2;
        }

        button:hover {
            background: #00aaff;
        }

        .switch-link {
            color: #4CAF50;
            margin-top: 10px;
            display: inline-block;
            font-size: 14px;
            grid-column: span 2;
        }

        .switch-link a {
            color: #4CAF50;
            text-decoration: none;
        }

        .switch-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="post">
            <div class="form-grid">
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <input type="date" name="birthdate" placeholder="Date of Birth" required>
                <button type="submit" name="signup">Finish Sign Up</button>
            </div>
        </form>
        <p class="switch-link">Already have an account? <a href="SignIn.php">Sign In</a></p>
    </div>
</body>
</html>