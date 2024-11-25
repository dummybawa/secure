<?php
// db.php
$host = 'localhost';
$db = 'rbac_demo';
$user = 'root';
$pass = ''; // Set your MySQL password here

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>
