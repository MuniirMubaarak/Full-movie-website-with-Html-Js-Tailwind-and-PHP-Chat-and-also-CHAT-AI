<?php
    session_start();
    if (!isset($_SESSION['Username']) || !isset($_SESSION['Id'])) {
        header("Location: login.php");
        exit(); // It's good practice to call exit after a header redirection
    }

    include("connection.php");

    $Id = $_SESSION['Id'];
    $fullName =  $_SESSION['Username'];
    if(isset($_POST['search'])){
        $search = $_POST['search'];
        $query = mysqli_query($conn, "SELECT * FROM Videos 
        WHERE Name LIKE '%$search%' OR 
        Author LIKE '%$search%' OR 
        Author_Id LIKE '%$search%' OR 
        Category LIKE '%$search%'");
    
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Search  <?php echo $search;  ?></title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <script src="index.js" defer></script>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.x.x/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body>
        <!-- The Header -->
         <?php  include("header.php")  ?>

        <section id="sare " class="mt-14">
            <div class="container mx-auto">
                <div class="sheeg">
                   <h1 class="text-center text-4xl font-bold text-blue-600"><?php echo $search  ?></h1>
                </div>
                <div class="videos m-4 mt-20 grid grid-rows-1 lg:grid-cols-3  gap-7 ">
                   <?php 
                        while ($row = mysqli_fetch_assoc($query)):
                    ?>
                    <div class="video rounded-lg cursor-pointer flex flex-col space-y-1  duration-300 transition-colors">
                        <img  src="<?php  echo $row['Cover'] ?>" class="w-full h-64 border border-collapse rounded-none bg-slate-900" alt="" />
                        <button class="text-left text-yellow-500 text-2xl hover:text-3xl hover:text-slate-900 hover:font-bold cursor-pointer"
                            onclick="loadVideo(<?php echo $row['Id']; ?>)">
                        <?php echo $row['Name']; ?>
                        </button>
                        <div class="details flex flex-row justify-between space-x-5">
                        <form action="others.php" method="get">
                            <input type="hidden" name="data" value="<?php echo $row['Author_Id']  ?>">
                            <button type="submit" name="pro" class=" text-blue-700 text-left px-3 py-2 -ml-3 text-2xl rounded-lg
                            transition-all duration-300 hover:text-red-400 hover:text-3xl flex items-center pl-10" >
                                <?php echo $row['Author'] ?>
                            </button>
                        </form>
                        <p class="text-xl text-blue-600"><?php echo $row['Date'] ?></p>
                        </div>                          
                    </div>
                <?php  endwhile ?>
                    
            </div>
            </div>
        </section>
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

<?php
    }

    
    