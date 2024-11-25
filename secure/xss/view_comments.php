<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $comment = trim($_POST['comment']);

    if (empty($username) || empty($comment)) {
        echo "Username and comment are required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO comments (username, comment) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $comment);

        if ($stmt->execute()) {
            echo "Comment submitted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Comment (Secure)</title>
</head>
<body>
    <h2>View Comment</h2>
    <form method="post">
        Username: <input type="text" name="username"><br>
        Comment: <textarea name="comment"></textarea><br>
        <input type="submit" value="Submit">
    </form>

    <h2>Comments</h2>
    <?php
    include 'config.php';
    $sql = "SELECT username, comment, created_at FROM comments ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<p><strong>" . htmlspecialchars($row['username']) . ":</strong> " . htmlspecialchars($row['comment']) . " <em>at " . $row['created_at'] . "</em></p>";
        }
    } else {
        echo "No comments yet.";
    }
    $conn->close();
    ?>
</body>
</html>
