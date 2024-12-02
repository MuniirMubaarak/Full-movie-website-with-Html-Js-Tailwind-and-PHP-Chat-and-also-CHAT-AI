<?php
session_start();
if (!isset($_SESSION['Username']) || !isset($_SESSION['Id'])) {
    header("Location: login.php");
    exit(); // It's good practice to call exit after a header redirection
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("connection.php");
// Following SomeOne
if (isset($_GET['pro'])) {
    $Id = $_GET['data'];
    $UId = $_SESSION['Id'];
    if($Id == $UId){
        header('Location: profile.php');
        exit();
    }
    
    $det = mysqli_query($conn, "SELECT * FROM Users WHERE Id = '$Id'");
    if (mysqli_num_rows($det) > 0) {
        $xog = mysqli_fetch_array($det);
        $Magaca = $xog["Username"];
        $Email = $xog["Email"];
        

        if (isset($_POST['Follow'])) {
            $Follower_Id = $UId;
            $Author_Id = $Id;
            $Author_Name = $Magaca;
            $Datey = date("Y-m-d H:i:s");
            // Check before Inserting
            $baadhe = mysqli_query($conn,"SELECT * FROM Follow Where Follower_Id = '$UId' And 
            Author_Id = '$Id'");
            if (mysqli_num_rows($baadhe) > 0) {
                // Deletion
                $xabad = mysqli_fetch_assoc($baadhe);
                $foId = $xabad['Following_Id'];
                $del = mysqli_query($conn, "DELETE FROM Follow WHERE Following_Id = '$foId'");
                if(mysqli_affected_rows($conn) > 0){
                    
                }
                else{
                    echo "Isa Seeg Baa jira";
                }
            }else{
            
            $Insert = mysqli_query($conn,"INSERT INTO Follow (Follower_Id, Author_Id, Author_Name,
             Date) VALUES ('$Follower_Id','$Author_Id','$Author_Name','$Datey')");
            if(mysqli_affected_rows($conn) > 0){
                 
                 $haye = "Followed";
            }
        }
        }
        $tir = mysqli_query($conn, "SELECT * FROM Videos WHERE Author ='$Magaca'
         AND Author_Id = '$Id' ");
        $num = mysqli_num_rows($tir);
        $Videos = mysqli_query($conn, "SELECT * FROM Videos WHERE Author ='$Magaca'
         AND Author_Id = '$Id' ");
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Profile || <?php echo $Magaca; ?></title>
            <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <script src="index.js" defer></script>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.x.x/dist/tailwind.min.css" rel="stylesheet">
        </head>
        <body>
            <!-- The Header -->
            <nav class="bg-slate-900">
                <div class="container mx-auto py-2 flex flex-row justify-between items-center">
                    <div class="logo text-left text-3xl text-blue-600 font-semibold">
                        <h1>Shawfah</h1>
                    </div>
                    <div class="navs hidden lg:flex flex-row space-x-3 items-center text-white text-md">
                    <a href="Authors.php" class="hover:underline hover:text-orange-400">Subscribed Ones</a>
                    <a href="#" class="hover:underline hover:text-orange-400">About</a>
                        <a href="Index.php" class="bg-blue-600 text-white px-3 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Return to the Home</a>
                        <a href="Upload.php" class="bg-blue-600 text-white px-3 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Upload</a>
                        <a href="Dheh/" class="bg-blue-600 text-white px-3 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Dheh</a>
                        <a  onclick="chat(<?php  echo $Id; ?>)" class=" text-white bg-blue-600 cursor-pointer px-5 py-2 text-xl rounded-xl hover:bg-blue-800 transition-all duration-500">Chat</a>
                        <div class="profile flex flex-row justify-between space-x-4">
                            <form action="" method="post">
                                <button type="submit" name="Follow" class="bg-white text-black px-3 py-2 text-xl rounded-lg hover:bg-blue-600 transition-all duration-300 hover:text-white flex items-center pl-10" 
                                style="background-image: url('user_person_people_6100.ico'); background-size: 1.9rem; background-repeat: 
                                no-repeat; background-position: 0.6rem center;">  <?php 
                                
                               
        $daye = mysqli_query($conn,"SELECT * FROM Follow Where Follower_Id = '$UId' And 
        Author_Id = '$Id'");
        if(mysqli_num_rows($daye) > 0){
            $haye = "Followed";
        }
        else{
            $haye = "Follow";
        }
                                
                               echo $haye ?></button>
                            </form>
                        </div>
                    </div>
                    <div class="mobile-btn block lg:hidden text-blue-600 mx-5 mt-2">
                        <i class="ri-menu-line text-4xl cursor-pointer hover:text-yellow-400"></i>
                    </div>
                </div>

                <div class="mobile-menu hidden  bg-blue-400 w-full rounded-lg text-2xl py-50 absolute mt-5 text-black flex flex-col space-y-3  justify-center">
                <a href="Authors.php" class="hover:underline hover:text-orange-400">Subscribed Ones</a>
                <a href="#" class="hover:underline hover:text-slate-900">About</a>
                    <a href="Index.php" class="bg-blue-600 text-white px-3 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Return to the Home</a>
                    <a href="Upload.php" class="bg-slate-900 text-white px-5 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Upload</a>
                    <a href="Dheh/" class="bg-slate-900 text-white px-5 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Dheh</a>
                    <a  onclick="chat(<?php  echo $Id; ?>)" class=" text-white bg-blue-600 cursor-pointer px-5 py-2 text-xl rounded-xl hover:bg-blue-800 transition-all duration-500">Chat</a>
                    <form action="" method="post">
                                <button type="submit" name="Follow" class="bg-white text-black px-3 py-2 text-xl rounded-lg hover:bg-blue-600 transition-all duration-300 hover:text-white flex items-center pl-10" 
                                style="background-image: url('user_person_people_6100.ico'); background-size: 1.9rem; background-repeat: 
                                no-repeat; background-position: 0.6rem center;">  <?php 
                                
                               
        $daye = mysqli_query($conn,"SELECT * FROM Follow Where Follower_Id = '$UId' And 
        Author_Id = '$Id'");
        if(mysqli_num_rows($daye) > 0){
            $haye = "Followed";
        }
        else{
            $haye = "Follow";
        }
                                
                               echo $haye ?></button>
                            </form>
                </div>
            </nav>

            <section id="Details" class="border-gray-600 border-2">
    <div class="container mx-auto flex flex-col">
        <div class="magac flex pt-7 justify-center items-center flex-col space-y-3 ">
        <h1 class="text-5xl text-center text-blue-600 font-semibold"><?php echo $Magaca  ?></h1>
        <h2 class="text-3xl text-center text-slate-900 italic"> <?php echo $Email ?> </h2>
        </div>

        <div class="magac flex mt-3 justify-center items-center flex-row space-x-3 ">
        <h2 class="text-2xl text-center text-yellow-900 font-bold "> Has a 
            <?php echo  $num ?>   Videos  </h2> 
        </div>
        
    </div>
    
  
    </section>

    <div class="videos m-4 mt-5 grid grid-rows-1 lg:grid-cols-3  gap-4 ">
        <?php 
            while ($vid = mysqli_fetch_array($Videos)):
        ?>
            <div class="video overflow-hidden whitespace-nowrap rounded-lg flex flex-col space-y-1  text-left  duration-300 transition-all">
                <img  src="<?php  echo $vid['Cover'] ?>" class="w-full h-64 border border-collapse rounded-none bg-slate-900" alt="" />  
                <button class="text-left text-yellow-500 text-2xl hover:text-3xl hover:text-slate-900 hover:font-bold cursor-pointer"
                            onclick="loadVideo(<?php echo $vid['Id']; ?>)">
                        <?php echo $vid['Name']; ?>
                    </button>                   
            </div>
        <?php  endwhile ?>
             
    </div>
            <script>
             
    index = 1;

function loadVideo(videoId) {
    window.location.href = `watch_video.php?video_id=${videoId}`;
}
function chat(userId) {
    window.location.href = `Chat/index.php?Id=${userId}`;
}

    

const mobile_btn = document.querySelector('.mobile-btn');
const mobile_menu = document.querySelector('.mobile-menu');

mobile_btn.addEventListener('click', () => {
    mobile_menu.classList.toggle("hidden");
})

var currentPagePath = window.location.pathname;
console.log("User is on page: " + currentPagePath);
if (currentPagePath != "/shawfah/index.php" && currentPagePath != "/shawfah/" && currentPagePath != "/shawfah") {
    <?php echo "Maaha"; ?>
}
</script>
        </body>
        </html>
        <?php
    }
}
