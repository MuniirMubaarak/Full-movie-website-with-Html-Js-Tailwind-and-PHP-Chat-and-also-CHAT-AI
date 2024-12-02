<?php
session_start();
if (!isset($_SESSION["Username"]) && !isset($_SESSION["Id"])){
    header("Index.php");
    exit();
}
$AId = $_SESSION['Id'];
$AName = $_SESSION['Username'];
include("connection.php");
include("reccom.php");
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $videoId = $_GET['video_id'] ?? null;
    if ($videoId) {
        $query = mysqli_query($conn, "SELECT * FROM Videos WHERE Id = '$videoId'");
        // Fetching the datails of the video
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $VName = $row['Name'];
            $VId = $row['Id'];
            $VCover = $row['Cover'];
            $VPlace = $row['Place'];
            $VCategory = $row['Category'];
            $VAuthor = $row['Author'];
            $VAuthor_Id = $row['Author_Id'];
            $VWatcher = $_SESSION['Username'];
            $Date = $row['Date'];
            $Time = date("Y-m-d H:i:s"); 
            // Check before inserting into the history
            $check = mysqli_query($conn, "SELECT * FROM History WHERE Video_Id = '$VId' AND Watcher = '$VWatcher' AND Date = '$Time'");
            // Getting how many times this video was watched 
            $tiro = mysqli_query($conn, "SELECT * FROM History WHERE Video_Id = '$VId' AND Author_Id = '$VAuthor_Id'");
            $num = mysqli_num_rows($tiro);
            if(mysqli_affected_rows($conn) > 0){
            }else{
                // Insert Now
                $Insert = mysqli_query($conn, "INSERT INTO History (Name, Video_Id,  
                Video_Author, Author_Id, Video_Place, Video_Category, Watcher, Date) VALUES ('$VName','$VId',
                '$VAuthor', '$VAuthor_Id', '$VPlace','$VCategory','$VWatcher', '$Time')");
                if(mysqli_affected_rows($conn)){
                }
            }
            
            // Watching then the video
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
                <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
                <link rel="stylesheet" href="style.css">
                <title>Video || <?php echo $VName ?></title>
                <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.x.x/dist/tailwind.min.css" rel="stylesheet">            </head>
                <style>
                    .max-h-80 {
                        max-height: 25rem /* 320px */;
                    }
                    .h-14 {
                        height: 8.5rem /* 56px */;
                        padding-right: 2rem;
                    }
                    @media (min-width: 1024px) {
                        .lg\:h-14 {
                            height: 5.5rem /* 56px */;
                        }
                    }
                    .h-20 {
                        height: 14rem /* 80px */;
                    }
                    .h-80 {
                        height: 30rem /* 320px */;
                    }
                    .w-\[98\%\] {
                        width: 98%;
                    }
                    @media (min-width: 1024px) {
                        .lg\:max-h-80 {
                            max-height: 30rem /* 320px */;
                        }
                    }
                </style>
            <body>
                <!-- The Header -->
                <?php  include("header.php"); ?>
                <!-- The Tab -->
                <div class="mx-auto  flex flex-col lg:flex-row mt-20">
                    <section id="video" class="flex flex-col pl-5 space-y-4 w-full lg:w-7/12">
                        <div class="player w-full">
                            <video src="<?php echo $VPlace  ?>" class="h-auto lg:max-h-80 max-h-80 w-full" controls autoplay id="videoPlayer"></video>
                            <h1 class="text-blue-600 font-bold text-2xl"><?php echo $VName   ?></h1>
                            <div class="details flex flex-row items-center justify-between text-md text-slate-900">
                                <form action="others.php" method="get">
                                    <input type="hidden" name="data" value="<?php echo  $VAuthor_Id ?>">
                                    <button type="submit" name="pro" class=" text-blue-700 text-left px-3 py-2 -ml-3 text-2xl rounded-lg
                                    transition-all duration-300 hover:text-red-400 hover:text-3xl flex items-center pl-10" >
                                        <?php echo $VAuthor ?>
                                    </button>
                                </form>
                                <h1><?php echo $num. ' Watched' ?>  </h1>
                                <h1><?php echo $Date  ?></h1>
                                <button type="submit" id = "follow" name="Follow" onclick="follow( <?php echo $_SESSION['Id'] ?> 
                                ?>,<?php echo $VAuthor ?>)" class="bg-white text-black px-3 py-2 text-xl rounded-lg hover:bg-blue-600 transition-all duration-300 hover:text-white flex items-center pl-10" 
                                style="background-image: url('user_person_people_6100.ico'); background-size: 1.9rem; background-repeat: 
                                no-repeat; background-position: 0.6rem center;"> Follow </button>
                            
                            </div>  
                        </div>
                        <div class="comments-bar border border-gray-400 rounded-lg p-4 bg-gray-100 flex flex-col space-y-4">
                            <h1 class="text-2xl font-semibold text-blue-600">Comments</h1>
                            <div class="send">
                                <label for="Text" class="text-lg font-medium text-gray-700">Add a comment</label>
                                <textarea name="Text" id="Text" rows="3" class="w-full p-3 rounded-md border bg-gray-900 text-white border-gray-300 focus:ring-2 focus:ring-blue-300 text-lg placeholder-gray-200"
                                placeholder="Write your comment..."></textarea>
                                <button id="postCommentBtn"  class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-500 transition duration-150">
                                    Post Comment
                                </button>
                            </div>
                                
                           
                            <div class="comments space-y-4 mt-4">
                                <?php  
                                    $Comments = mysqli_query($conn, "SELECT * FROM Comments WHERE CVideo_Id = '$VId' ORDER BY Id DESC");

                                    while($com = mysqli_fetch_assoc($Comments)):
                                ?>
                                <div class="comment bg-gray-900 rounded-lg p-3 border border-gray-200 text-white shadow-sm">
                                    <div class="comauth text-xl font-semibold text-blue-600"><?php  echo $com['CAuthor'] ?> </div>
                                    <div class="combody mt-1 "><?php echo $com['CText'] ?></div>
                                </div>
                                <!-- Additional comments go here -->
                                <?php  endwhile; ?>
                            </div>
                        </div>

                        
                    </section>
                    <section id="recom" class="flex flex-col space-y-4 w-full lg:w-5/12">
                        <h1 class="text-center text-3xl text-blue-600">Recommended</h1>
                        <table id="table" class="text-lg  md:text-xl table-auto w-full">
                            <tbody>
                        <?php  
                            while($iska = mysqli_fetch_assoc(result: $queryLovedCategories)):
                                $cover = $iska['Cover'];
                        ?>
                            <tr class="bg-white py-3 text-xl">
                                <td class=" p-2 text-blue-600">
                                    <img  onclick="loadVideo(<?php echo $iska['Id']  ?>)" src="<?php echo $iska['Cover'] ?>" alt="" srcset="" class="w-full hover:text-blue-600 cursor-pointer rounded-lg h-14 lg:h-14">
                                </td>
                                <td class=" p-2">
                                <h1 class="hover:text-blue-600 cursor-pointer" onclick="loadVideo(<?php echo $iska['Id']  ?>)"><?php echo $iska['Name'] ?></h1> 
                                </td>
                                <td class=" hover:text-blue-600 cursor-pointer p-2">
                                    <h1 onclick="loadAuthor(<?php  echo $iska['Author_Id'] ?>)" class=""><?php echo $iska['Author'] ?></h1> 
                                </td>
                            </tr>
                        <?php 
                            endwhile;
                        ?>
                    </tbody>
            </table>
                    </section>
                </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <script>
                    const videoId = <?php echo json_encode($VId); ?>;

                    const VCategory = <?php echo json_encode($VCategory); ?>;

                    const VName = <?php echo json_encode($VName); ?>;
                    document.getElementById("postCommentBtn").addEventListener("click", addComment);

                    function addComment() {
    const commentText = $("textarea[name='Text']").val().trim();

    // Skip if no comment text
    if (commentText === "") {
        return;
    }
    fetch('comet.php', {method: 'POST',headers: {'Content-Type': 'application/json' },
    body: JSON.stringify({
        comment: commentText,
        video_id: videoId,
        VName: VName,
        VCategory: VCategory
    })
})
.then(response => response.text()) // Fetch as text to check if it’s JSON
.then(data => {
    try {
        const jsonData = JSON.parse(data); // Try parsing JSON data
        if (jsonData.error) {
            console.error('Error:', jsonData.error);
        } else {
            // Add the comment to the DOM as before
            const commentDiv = document.createElement("div");
            commentDiv.classList.add("comment", "bg-gray-900", "rounded-lg", "p-3", "border", "border-gray-200", "text-white", "shadow-sm");

            const comAuth = document.createElement("div");
            comAuth.classList.add("comauth", "text-xl", "font-semibold", "text-blue-600");
            comAuth.textContent = jsonData.CAuthor;

            const comBody = document.createElement("div");
            comBody.classList.add("combody", "mt-1");
            comBody.textContent = jsonData.CText;

            commentDiv.appendChild(comAuth);
            commentDiv.appendChild(comBody);
            document.querySelector(".comments").prepend(commentDiv);
            $("textarea[name='Text']").val('');
        }
    } catch (error) {
        console.error("Failed to parse JSON:", data);
    }
})
.catch(error => console.error('Error:', error));

                    }
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

function loadAuthor(userId) {
    window.location.href = `others.php?pro=3&data=${userId}`;
}

function follow() {

}

                </script>


            </body>
            </html>
            <?php
        } else{
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>A Thief Stoled this Page</title>
                <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
                <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
                <script src="index.js" defer></script>
                <link rel="stylesheet" href="style.css">
                <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.x.x/dist/tailwind.min.css" rel="stylesheet">  
            </head>
            <body>
                <?php include("header.php"); ?>
            </body>
            </html>
            
            <?php
        }

    }else{
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>A Thief Stoled this Page</title>
                <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
                <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
                <script src="index.js" defer></script>
                <link rel="stylesheet" href="style.css">
                <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.x.x/dist/tailwind.min.css" rel="stylesheet"> 
        </head>
        <body>
            <?php include("header.php"); ?>
        </body>
        </html>
        
        <?php
    }
}