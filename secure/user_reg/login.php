<?php
include 'config.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);    
    if (!$username) {
        echo "Please enter a username.";
    } elseif (!$password) {
        echo "Please enter a password.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();        
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $username, $hashed_password);
            $stmt->fetch();            
            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $id;
                header("location: welcome.php");
                exit;
            } else {
                echo "The password you entered was not valid.";
            }
        } else {
            echo "No account found with that username.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Login</h2>
    <form method="post">
        Username: <input type="text" name="username"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
