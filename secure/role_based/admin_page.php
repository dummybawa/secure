<?php
// admin_page.php
session_start();
include 'access_control.php';

if (!has_access('admin_page.php')) {
    die("Access denied: You do not have permission to access this page.");
}

echo "Welcome to the admin page!";
?>
