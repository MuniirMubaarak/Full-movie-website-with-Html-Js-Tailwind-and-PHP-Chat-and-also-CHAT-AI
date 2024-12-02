<?php
    session_start();
    if (!isset($_SESSION['Username']) || !isset($_SESSION['Id'])) {
        header("Location: login.php");
        exit(); // It's good practice to call exit after a header redirection
    }

    include("connection.php");

    $Id = $_SESSION['Id'];
    $fullName =  $_SESSION['Username'];
    $select = mysqli_query($conn, "SELECT * FROM History WHERE Watcher = '$fullName'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="index.js" defer></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.x.x/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <!-- The Header -->
     <?php   include("header.php");   ?>
     <div class="container mx-auto mt-14">
        <div class="videos grid grid-rows-1 lg:grid-cols-3  gap-7">
            <?php
                if(mysqli_num_rows($select) > 0){
                while($row = mysqli_fetch_assoc($select)):
                    $VId = $row['Video_Id'];
                    $videos = mysqli_query($conn, "SELECT * FROM Videos WHERE Id = '$VId'");
                    $Vid = mysqli_fetch_assoc( $videos );
            ?>
            <div class="video flex flex-col space-y-2">
                <img onclick="loadVideo(<?php echo $Vid['Id']; ?>)" class="w-full h-64 border border-collapse rounded-lg bg-slate-900" src="<?php  echo $Vid['Cover'] ?>" alt="" srcset="">
                <button class="text-left text-blue-600 text-2xl hover:text-3xl hover:text-slate-900 hover:font-bold cursor-pointer"
                            onclick="loadVideo(<?php echo $Vid['Id']; ?>)">
                        <?php echo $Vid['Name']; ?>
                </button>
            </div>
            <?php
                endwhile;
            }else{
                ?>
                <div class="container mx-auto">
                    <h1 class="text-center text-xl text-blue-600 font-semibold">
                        Please you don't watched yet any video!!!, search and then come back -):
                    </h1>
                </div>
                <?php
            }
            ?>
        </div>
     </div>
     <script>
    index = 1;
    const VideoPlayer = document.getElementById('videoPlayer');
    VideoPlayer.addEventListener('ended', () =>{
        loadVideo(Muuqaalo[index].VId);
        index++;
    }    
    )
    function loadVideo(videoId) {
        window.location.href = `watch_video.php?video_id=${videoId}`;
    }
     </script>
</body>
</html>