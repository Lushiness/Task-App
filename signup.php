<?php
// Database configuration
$servername = "localhost";
$username = "root";  
$password = "newpassword"; 
$dbname = "taskapp"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    // Validate and sanitize input data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
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
    
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Registration successful! You can now login."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
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
        <form action="">
            <h1>Register</h1>
            <div class="input-box">
                <input type="text" placeholder="Enter your name" required>
                <i class='bx bxs-user'></i>
            </div>
            
            <div class="input-box">
                <input type="email" placeholder="Enter your email" required>
                <i class='bx bxs-envelope'></i>
            </div>

            <div class="input-box">
                <input type="password" placeholder="Enter your password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
        
           
            <button type="submit" class="btn">Register</button>
            <div class="register-link">
                <p>Have an account? <a href="login.php" target="_blank">Login</a></p>
            </div>


        </form>
    </div>
    
</body>
</html>