<?php
session_start();
if (!isset($_SESSION['Username']) || !isset($_SESSION['Id'])) {
    header("Location: login.php");
    exit();
}

include("connection.php");

if (isset($_POST['Upload'])) {
    $Name = mysqli_real_escape_string($conn, $_POST['Name']);
    $Category = mysqli_real_escape_string($conn, $_POST['category']);
    $Author = $_SESSION['Username'];
    $Author_Id = $_SESSION['Id'];
    $Time = date("Y-m-d H:i:s");

    $uploadDir = 'Videos/';
    $uploadDir2 = 'Covers/';

    $videoTmpName = $_FILES['video']['tmp_name'];
    $videoName = time() . '_' . $_FILES['video']['name'];
    $thumbnailTmpName = $_FILES['Thumbnail']['tmp_name'];
    $thumbnailName = time() . '_' . $_FILES['Thumbnail']['name'];

    $videoName = mysqli_real_escape_string($conn, $videoName);
    $thumbnailName = mysqli_real_escape_string($conn, $thumbnailName);

    $uploadFilePath = $uploadDir . $videoName;
    $uploadThumbPath = $uploadDir2 . $thumbnailName;

    if ($_FILES['video']['error'] === UPLOAD_ERR_OK && $_FILES['Thumbnail']['error'] === UPLOAD_ERR_OK) {
        if (move_uploaded_file($videoTmpName, $uploadFilePath) && move_uploaded_file($thumbnailTmpName, $uploadThumbPath)) {
            // FFmpeg conversion

            $convertedVideoPath = $uploadDir . 'converted_' . $videoName;

            // Set FFmpeg path
            // $ffmpegPath = "M:\\Xampp\\htdocs\\Shawfah\\ffmpeg-7.1-essentials_build\\bin\\ffmpeg.exe";

            // Ensure paths with spaces are properly quoted
            $command = "\"$ffmpegPath\" -i \"$uploadFilePath\" -vf scale=854:480 -c:v libx264 -crf 23 -preset fast -c:a aac \"$convertedVideoPath\"";
            
            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                // FFmpeg conversion was successful
                $relativeVideoPath = 'Videos/converted_' . $videoName;
            } else {
                // FFmpeg failed, fallback to original video
                echo "Error processing video quality:\n";
                echo implode("\n", $output);  // Display FFmpeg error message
                $relativeVideoPath = 'Videos/' . $videoName;
            }

            $relativeThumbnailPath = 'Covers/' . $thumbnailName;

            // Insert video information into the database
            $query = "INSERT INTO Videos (Name, Place, Cover, Author, Author_Id, Category, Likes, Date) 
                      VALUES ('$Name', '$relativeVideoPath', '$relativeThumbnailPath', '$Author', '$Author_Id', '$Category', 0, '$Time')";

            if (mysqli_query($conn, $query)) {
                header("Location: Index.php");
                exit();
            } else {
                echo "Error inserting into database: " . mysqli_error($conn);
            }
        } else {
            echo "Error uploading the video or thumbnail. Please try again.";
        }
    } else {
        echo "There was an error with the file upload.";
        if ($_FILES['video']['error'] !== UPLOAD_ERR_OK) {
            echo " Video error: " . $_FILES['video']['error'];
        }
        if ($_FILES['Thumbnail']['error'] !== UPLOAD_ERR_OK) {
            echo " Thumbnail error: " . $_FILES['Thumbnail']['error'];
        }
    }
}else{
    echo "no";
    header("Location: index.php");
}
?>
