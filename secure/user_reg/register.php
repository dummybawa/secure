<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);    
    if (!$username) {
        echo "Please enter a username.";
    } elseif (!$password) {
        echo "Please enter a password.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();        
        if ($stmt->num_rows) {
            echo "This username is already taken.";
        } else {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("ss", $username, $hashedPassword);            
            echo $stmt->execute() ? "Registration successful." : "Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Register</h2>
    <form method="post">
        Username: <input type="text" name="username"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
