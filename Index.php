<?php
    session_start();
    if (!isset($_SESSION['Username']) || !isset($_SESSION['Id'])) {
        header("Location: login.php");
        exit(); // It's good practice to call exit after a header redirection
    }
    include("connection.php");

    $userId = $_SESSION['Id'];
    $name =   $_SESSION['Username'];

    // Step 1: Get top categories the user has watched recently from the `History` table.
    $categoryQuery = "
        SELECT Video_Category, COUNT(*) AS category_count 
        FROM History 
        WHERE Watcher = '$name' 
        GROUP BY Video_Category 
        ORDER BY category_count DESC 
    ";

    // Fetch top categories
    $categoryResult = mysqli_query($conn, $categoryQuery);
    $categories = [];
    while ($row = mysqli_fetch_assoc($categoryResult)) {
        $categories[] = $row['Video_Category'];
    }

    // Step 2: Fetch videos from the loved categories (the ones the user has watched).
    $videoQueryLovedCategories = "
        SELECT * FROM Videos 
        WHERE Category IN ('" . implode("','", $categories) . "') 
        AND Id NOT IN (
            SELECT Video_Id 
            FROM History 
            WHERE Watcher = '$name'
        ) 
    ";

    // Get videos for loved categories
    $queryLovedCategories = mysqli_query($conn, $videoQueryLovedCategories);
  
    // If no videos are found in the loved categories, show a message
    $imisaLoved = mysqli_num_rows($queryLovedCategories);
    if($imisaLoved < 1){
        
    }

    // Step 3: Fetch videos from other categories (those the user hasn't watched yet).
    $videoQueryOtherCategories = "
        SELECT * FROM Videos 
        WHERE Category NOT IN ('" . implode("','", $categories) . "')
        AND Id NOT IN (
            SELECT Video_Id 
            FROM History 
            WHERE Watcher = '$name'
        ) 
    ";

    // Get videos for other categories
    $queryOtherCategories = mysqli_query($conn, $videoQueryOtherCategories);
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="index.js" defer></script>
    <link rel="stylesheet" href="style.css">
    <title>Shawfah</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.x.x/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <!-- The Header -->
   <?php include('header.php'); ?>

   <!-- The videos -->
    <section>
        <div class="books m-4 mt-20 grid grid-rows-1 lg:grid-cols-3 gap-7">
<?php 
    $meeqee = mysqli_query($conn, "SELECT * FROM History WHERE Watcher = '$name'");
    if(mysqli_num_rows($meeqee) > 0){

?>
            <!-- Videos from loved categories -->
            <?php while ($row = mysqli_fetch_assoc($queryLovedCategories)): ?>
                <div class="book rounded-lg cursor-pointer flex flex-col space-y-1 duration-300 transition-colors">
                    <img onclick="loadvideo(<?php echo $row['Id']  ?>)" src="<?php echo $row['Cover'] ?>" class="w-full h-64 border border-collapse rounded-none bg-slate-900" alt="" />
                    <button class="text-left text-yellow-500 text-2xl hover:text-3xl hover:text-slate-900 hover:font-bold cursor-pointer"
                            onclick="loadVideo(<?php echo $row['Id']; ?>)">
                        <?php echo $row['Name']; ?>
                    </button>
                    <!-- JavaScript will handle displaying video details -->
                </div>
            <?php endwhile ?>

            <!-- Videos from other categories -->
            <?php while ($row = mysqli_fetch_assoc($queryOtherCategories)): ?>
                <div class="book rounded-lg cursor-pointer flex flex-col space-y-1 duration-300 transition-colors">
                    <img src="<?php echo $row['Cover'] ?>" class="w-full h-64 border border-collapse rounded-none bg-slate-900" alt="" />
                    <button class="text-left text-yellow-500 text-2xl hover:text-3xl hover:text-slate-900 hover:font-bold cursor-pointer"
                            onclick="loadVideo(<?php echo $row['Id']; ?>)">
                        <?php echo $row['Name']; ?>
                    </button>
                    <!-- JavaScript will handle displaying video details -->
                </div>
            <?php endwhile ?>
<?php  }
else{
    ?> 
    <style>
        @media (min-width: 1024px) {
    .lg\:left-\[20\%\] {
        left: 20%;
    }
}
    </style>
    <div class=" mx-auto h-screen flex justify-center  lg:absolute lg:left-[20%]">
        <h1 class="text-blue-600 text-center text-5xl">Please first search some videos and watch</h1>
    </div>
    
    
    <?php
}

?>
        </div>
    </section>
   <script>
    function loadVideo(videoId) {
        window.location.href = `watch_video.php?video_id=${videoId}`;
}

   </script>
</body>
</html>
