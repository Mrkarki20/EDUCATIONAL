<?php
// Assuming a simple session-based login system
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "uploads/";
    $file_type = $_POST['file_type'];
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is of the correct type
    if ($file_type === "video" && $fileType != "mp4" && $fileType != "avi" && $fileType != "mov") {
        echo "Sorry, only MP4, AVI & MOV files are allowed for videos.";
        $uploadOk = 0;
    } elseif ($file_type === "document" && $fileType != "pdf" && $fileType != "docx") {
        echo "Sorry, only PDF & DOCX files are allowed for documents.";
        $uploadOk = 0;
    } elseif ($file_type === "question" && $fileType != "pdf") {
        echo "Sorry, only PDF files are allowed for question papers.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .dashboard-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .file-upload-form {
            display: flex;
            flex-direction: column;
        }

        input, select {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px;
            background: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background: #4cae4c;
        }

        .uploaded-files {
            margin-top: 20px;
        }

        .uploaded-files h3 {
            margin-bottom: 10px;
        }

        .uploaded-files ul {
            list-style-type: none;
            padding: 0;
        }

        .uploaded-files ul li {
            background: #eee;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h2>Admin Dashboard</h2>
    <form class="file-upload-form" action="" method="POST" enctype="multipart/form-data">
        <label for="file_type">Select File Type:</label>
        <select name="file_type" required>
            <option value="document">Notes</option>
            <option value="video">Video</option>
            <option value="question">Question Paper</option>
        </select>
        <label for="file">Choose File:</label>
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>

    <div class="uploaded-files">
        <h3>Uploaded Files</h3>
        <ul>
            <!-- PHP Code to list uploaded files -->
            <?php
            $files = scandir('uploads');
            foreach ($files as $file) {
                if ($file != "." && $file != "..") {
                    echo "<li>" . $file . "</li>";
                }
            }
            ?>
        </ul>
    </div>
</div>

</body>
</html>
