<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $allowedTypes = ["image/jpeg", "image/png", "application/pdf"];
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
        $fileName = basename($_FILES["fileToUpload"]["name"]);
        $fileType = $_FILES["fileToUpload"]["type"];
        $fileTempPath = $_FILES["fileToUpload"]["tmp_name"];
        if (!in_array($fileType, $allowedTypes)) {
            die("Error: Unsupported file type.");
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $actualType = finfo_file($finfo, $fileTempPath);
        finfo_close($finfo);
        if ($actualType !== $fileType) {
            die("Error: File content does not match declared type.");
        }
        $storagePath = __DIR__ . '/secure_uploads/';
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0700, true); 
        }
        $targetFilePath = $storagePath . $fileName;
        if (move_uploaded_file($fileTempPath, $targetFilePath)) {
            $stmt = $conn->prepare("INSERT INTO files (filename, mime_type) VALUES (?, ?)");
            $stmt->bind_param("ss", $fileName, $fileType);
            if ($stmt->execute()) {
                echo "File uploaded and saved securely.";
            } else {
                echo "Failed to save file information.";
            }
            $stmt->close();
        } else {
            echo "Error: File upload failed.";
        }
    } else {
        echo "No file uploaded or file too large.";
    }
}
$conn->close();
?>
