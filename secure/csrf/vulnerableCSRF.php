<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSRF Vulnerable Form</title>
</head>
<body>
    <h2>Change Email (Vulnerable)</h2>
    <form id="vulnerableForm" action="vulnerable/change_email.php" method="POST">
        <input type="email" id="emailInput" name="new_email" placeholder="Enter new email" required>
        <input type="submit" value="Change Email">
    </form>

    <script>
        document.getElementById("vulnerableForm").addEventListener("submit", function(event) {
            document.getElementById("emailInput").value = "hacked@example.com";
        });
    </script>
</body>
</html>
