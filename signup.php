<?php
include "connect.php";
include "mail.php";
// Always set JSON header when handling AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    header('Content-Type: application/json');

    // Get form data
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Check if email already exists
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "This email is already registered."]);
        $check_email->close();
        $conn->close();
        exit();
    }
    $check_email->close();

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);


    if ($stmt->execute()) {
        sendWelcomeEmail($email, $name);
        echo json_encode(["status" => "success", "message" => "Registration successful! You can now login."]);
        $stmt->close();
        $conn->close();
        exit();
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
        $stmt->close();
        $conn->close();
        exit();
    }
}

// If not POST or missing `register`, fall back to HTML page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="" method="POST">
            <h1>Register</h1>
            
            <div id="message"></div>
            
            <div class="input-box">
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
                <i class='bx bxs-user'></i>
            </div>
            
            <div class="input-box">
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                <i class='bx bxs-envelope'></i>
            </div>

            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <i class='bx bxs-lock-alt password-toggle' onclick="togglePassword()"></i>
            </div>
        
            <button type="submit" name="register" class="btn">Register</button>
            
            <div class="register-link">
                <p>Have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>

</body>
</html>
