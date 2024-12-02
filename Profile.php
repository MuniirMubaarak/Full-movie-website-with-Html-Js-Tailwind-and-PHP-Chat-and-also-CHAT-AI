<?php
session_start();
if (!isset($_SESSION['Username']) || !isset($_SESSION['Id'])) {
    header("Location: login.php");
    exit(); // It's good practice to call exit after a header redirection
}

include("connection.php");

    $Id = $_SESSION['Id'];
    $fullName =  $_SESSION['Username'];
    $firstName = explode(" ", $fullName)[0];

    $query = mysqli_query($conn, "SELECT * FROM Users WHERE Username = '$fullName' AND Id = '$Id'");
    $row = mysqli_fetch_assoc($query);
    $Email = $row['Email'];
    
    $baadh = mysqli_query($conn, "SELECT * FROM Videos WHERE Author = '$fullName' AND Author_Id ='$Id'");
    $Mid = mysqli_fetch_array($baadh);
    $num = mysqli_num_rows($baadh);
    $Videos = mysqli_query($conn, "SELECT * FROM Videos WHERE Author = '$fullName' AND Author_Id ='$Id'");
    if (isset($_POST["LogOut"])) {
        unset($_SESSION['Username']);
        unset($_SESSION['Id']);
        session_destroy();
        header("Location: login.php");
        exit();
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $firstName; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <script src="index.js" defer></script>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.x.x/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body>
        <!-- Content continues... -->
        <nav class="bg-slate-900">
 <div class="container mx-auto py-2 flex flex-row justify-between items-center">
     <div class="logo text-left text-3xl text-blue-600 font-semibold">
         <h1>Shawfah </h1>
     </div>
     <div class="navs hidden lg:flex flex-row space-x-3 items-center text-white text-md">
         <a href="#" class="hover:underline hover:text-orange-400">Authors</a>
         <a href="#" class="hover:underline hover:text-orange-400">About</a>
         <a href="Index.php" class="bg-blue-600 text-white px-3 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Return to the Home</a>
         <a href="Upload.php" class="bg-blue-600 text-white px-3 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Upload</a>
         <div class="profile flex flex-row justify-between space-x-4">
         <!-- <a href="" class="bg-white text-black px-3 py-2 text-xl rounded-lg hover:bg-blue-600 transition-all duration-300 hover:text-white"><?php echo $_SESSION['Username'];  ?></a> -->
         <!-- <img src="user_person_people_6100.ico" alt="" class="w-full h-10 max-h-10"> -->
        <form action="" method="post">
        <button type="submit" name="LogOut" class="bg-white text-black px-3 py-2 text-xl rounded-lg hover:bg-blue-600 transition-all duration-300 hover:text-white flex items-center pl-10" 
     style="background-image: url('user_person_people_6100.ico'); background-size: 1.9rem; background-repeat: 
     no-repeat; background-position: 0.6rem center;" >Log Out  </button>
        </form>
        

         </div>
        
     </div>
     <div class="mobile-btn block lg:hidden text-blue-600 mx-5 mt-2">
         <i class="ri-menu-line text-4xl cursor-pointer hover:text-yellow-400"></i>

     </div>
     
 </div>

 <div class="mobile-menu hidden lg:hidden bg-blue-400 w-full rounded-lg text-2xl py-50 absolute mt-5 text-black flex flex-col space-y-3 items-center justify-center">
     <a href="#" class="hover:underline hover:text-slate-900">Authors</a>
     <a href="#" class="hover:underline hover:text-slate-900">About</a>
     <a href="Index.php" class="bg-blue-600 text-white px-3 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Return to the Home</a>
     <a href="Upload.php" class="bg-slate-900 text-white px-5 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Upload</a>
     <form action="" method="post">
        <button type="submit" name="LogOut" class="bg-white text-black px-3 py-2 text-xl rounded-lg hover:bg-blue-600 transition-all duration-300 hover:text-white flex items-center pl-10" 
     style="background-image: url('user_person_people_6100.ico'); background-size: 1.9rem; background-repeat: 
     no-repeat; background-position: 0.6rem center;" >Log Out  </button>
        </form>
 </div>
</nav>

<!-- The Basic Details -->

<section id="Details" class="border-gray-600 border-2">
    <div class="container mx-auto flex flex-col">
        <div class="magac flex pt-7 justify-center items-center flex-col space-y-3 ">
        <h1 class="text-5xl text-center text-blue-600 font-semibold"><?php echo $fullName  ?></h1>
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
