<?php
include 'auth.php';

if (!is_logged_in()) {
    header("Location: login.php");
    exit();
}
?>

<h1>Dashboard</h1>
<p>Welcome, <?php echo $_SESSION['user_id']; ?>!</p>
<ul>
    <li><a href="admin_page.php">Admin Page</a></li>
</ul>

<form method="post" action="logout.php">
    <button type="submit">Logout</button>
</form>
