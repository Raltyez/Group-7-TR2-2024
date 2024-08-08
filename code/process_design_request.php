<?php
include_once("header.php");

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: sign_in_page.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $description = $_POST['request_description'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["design_photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["design_photo"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["design_photo"]["size"] > 5000000) { // 5MB limit
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" 
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["design_photo"]["tmp_name"], $target_file)) {
            // File uploaded successfully, now save the data to the database
            $servername = "localhost";
            $username = "root";
            $password_db = "";
            $dbname = "users";

            // Create connection
            $conn = new mysqli($servername, $username, $password_db, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO design_requests (user_id, photo_path, request_description) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $user_id, $target_file, $description);

            if ($stmt->execute()) {
                echo "The file ". htmlspecialchars(basename($_FILES["design_photo"]["name"])). " has been uploaded and your request has been submitted.";
            } else {
                echo "Sorry, there was an error submitting your request.";
            }

            $stmt->close();
            $conn->close();

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<?php 
include_once("footer.html");
?>
