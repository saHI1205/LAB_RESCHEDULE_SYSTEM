<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('db_connection.php');

    // Get form input values
    $student_name = $_POST['student_name'];
    $student_email = $_POST['student_email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate that the username is unique
    $check_user_sql = "SELECT * FROM students WHERE username = ?";
    $stmt = $conn->prepare($check_user_sql);
    $stmt->bind_param("s", $username); // Bind the username parameter to the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User already exists
        $message = "Username already exists. Please choose a different one.";
    } else {
        // Insert the new user into the students table
        $insert_sql = "INSERT INTO students (student_name, student_email, username, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssss", $student_name, $student_email, $username, $password); // Bind the parameters to prevent SQL injection
        $stmt->execute();

        // Redirect to the login page after successful registration
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* General body styling */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, rgba(98, 163, 255, 1) 0%, rgba(77, 143, 255, 1) 100%);
        }

        .register-container {
            background: #fff;
            border-radius: 12px;
            padding: 40px 30px;
            width: 350px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #4e9ef1;
            outline: none;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #4e9ef1;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #3c8cd3;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #999;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Register</h2>

        <form method="POST" action="">
            <!-- Student Name input -->
            <input type="text" name="student_name" placeholder="Student Name" required><br>

            <!-- Student Email input -->
            <input type="email" name="student_email" placeholder="Student Email" required><br>

            <!-- Username input -->
            <input type="text" name="username" placeholder="Username" required><br>

            <!-- Password input -->
            <input type="password" name="password" placeholder="Password" required><br>

            <!-- Submit button -->
            <button type="submit">Register</button>
        </form>

        <div class="footer">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>

</body>
</html>
