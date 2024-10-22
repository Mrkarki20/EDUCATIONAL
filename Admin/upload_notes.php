<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "uploads/notes/";
    $target_file = $target_dir . basename($_FILES["notes_file"]["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check file type
    if ($fileType != "pdf" && $fileType != "docx" && $fileType != "txt") {
        echo "Sorry, only PDF, DOCX, and TXT files are allowed.";
        exit;
    }

    // Upload file
    if (move_uploaded_file($_FILES["notes_file"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars(basename($_FILES["notes_file"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
