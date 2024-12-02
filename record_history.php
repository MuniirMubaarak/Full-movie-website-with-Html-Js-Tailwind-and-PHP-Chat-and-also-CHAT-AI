<?php
session_start();
include("connection.php");

// Check if JSON data is received
$data = json_decode(file_get_contents("php://input"), true);

// Extract details from the request
$Id =   $data['video_id'];
$Name = $data['video_name'];
$Author_Id =   $data['author_id'];
$Category =   $data['category'];
$Watcher =   $data['watcher'];
$date =   date("Y-m-d H:i:s");
$Author = $data["author"];
$src  = $data["src"];
$cover = $data["cover"];
$Watched = $data["watched"];


$check = mysqli_query($conn, "SELECT * FROM History WHERE Video_Id = '$Id' AND Watcher = '$Watcher' AND 
 Date = '$date'");
if (mysqli_num_rows($check) == 0) {
    // INsert After
    $query = mysqli_query($conn, "INSERT INTO History (Name, Video_Id, Video_Author, Author_Id, Video_Place,
    Video_Category, Watcher, Date) VALUES ('$Name','$Id','$Author','$Author_Id','$src','$Category', '$Watcher', '$date')");
    if(mysqli_affected_rows( $conn ) > 0) {
        echo "Inserted Succesfully";
    }
}





// // Check if the video is already recorded in history
// $checkQuery = "SELECT * FROM History WHERE Video_Id = '$videoId' AND Watcher = '$watcher'";
// $checkResult = mysqli_query($conn, $checkQuery);

// if (mysqli_num_rows($checkResult) === 0) {
//     // Insert into history table
//     $insertQuery = "INSERT INTO History (Video_Id, Name, Video_Author, Author_Id, Video_Category, Watcher, Date) 
//                     VALUES ('$videoId', '$videoName', '$authorId', '$authorId', '$category', '$watcher', '$timeWatched')";
//     if (mysqli_query($conn, $insertQuery)) {
//         echo "Video added to history.";
//     } else {
//         echo "Error adding video to history: " . mysqli_error($conn);
//     }
// } else {
//     echo "Video already in history.";
// }
