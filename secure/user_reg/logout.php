<?php
session_start();
if(!isset($_SESSION['username'])){
    header("location: login.php");
    exit;
}
echo "Welcome " . $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Welcome</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! You have successfully logged in.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
    