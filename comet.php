<?php
session_start();
include("connection.php");

$data = json_decode(file_get_contents("php://input"), true);
// Set character encoding for the connection to UTF-8
$conn->set_charset("utf8");

// Your existing POST request logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['comment'], $data['video_id'])) {
    // Sanitize and prepare data
    $comment = trim($data['comment']);  // Clean up any extra spaces
    $videoId = intval($data['video_id']);  // Integer cast for safety
    $VName = $data['VName'];
    $VCategory = $data['VCategory'];
    $AID = $_SESSION['Id'];
    $date = date("Y-m-d H:i:s");
    $AName = $_SESSION['Username'];

    // Prepare the SQL query
    $query = $conn->prepare("INSERT INTO Comments (CVideo, CVideo_Id, CAuthor_Id, CAuthor, CText, CCategory, CDate) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Check if the query was prepared successfully
    if ($query === false) {
        // Output the error message if the query preparation failed
        echo json_encode(["error" => "Error preparing the query: " . $conn->error]);
        exit; // Stop further execution
    }

    // Bind parameters to the prepared statement
    $query->bind_param("sssssss", $VName, $videoId, $AID, $AName, $comment, $VCategory, $date);

    // Execute the query
    if ($query->execute()) {
        // If successful, send back the inserted comment data
        $newComment = [
            'CAuthor' => $AName,
            'CText' => $comment
        ];
        echo json_encode($newComment); // Return the new comment as JSON
    } else {
        // Handle any error in query execution
        echo json_encode(["error" => "Error: " . $query->error]);  // Return error as JSON
    }
}
