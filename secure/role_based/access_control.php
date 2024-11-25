<?php
// access_control.php
include 'db.php';

function has_access($page) {
    if (!isset($_SESSION['role_id'])) {
        return false;
    }

    $role_id = $_SESSION['role_id'];

    global $pdo;
    $stmt = $pdo->prepare("SELECT has_access FROM permissions WHERE role_id = ? AND page = ?");
    $stmt->execute([$role_id, $page]);
    $permission = $stmt->fetchColumn();

    return $permission == 1;
}
?>
