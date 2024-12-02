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
    $daye = mysqli_query($conn, "SELECT * FROM Follow WHERE Follower_Id = '$Id'");
    $tiriye = mysqli_query($conn, "SELECT * FROM Follow WHERE Follower_Id = '$Id'");
    $tiro = mysqli_num_rows($tiriye);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribed Ones</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <script src="index.js" defer></script>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.x.x/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <?php
    include("header.php");
    ?>

    <section id="xog" class="mt-20">
        <div class="container mx-auto flex flex-col space-y-4">
            <div class="det flex flex-col space-y-3">
                <h1 class="text-3xl text-blue-600 text-center font-bold"><?php echo $fullName; ?></h1>
                <h1 class="text-xl  italic text-center text-yellow-600">You Followed <?php echo $tiro  ?>  Great Person(s)</h1>
            </div>

     <div class="Authors m-4 mt-5 grid grid-rows-1   gap-4 container mx-auto">
        
        <table id="table" class="text-lg md:text-xl table-auto w-full border border-gray-300">
            <thead class="bg-gray-200">
                <tr class="font-mono text-orange-400">
                    <th class="border border-gray-300 p-2 text-left">Name</th>
                    <th class="border border-gray-300 p-2 text-left">Videos</th>
                    <th class="border border-gray-300 p-2 text-left">Followers</th>
                </tr>
            </thead>
            <tbody>
            <?php while($mid = mysqli_fetch_assoc($daye)):
                $name = $mid["Author_Name"];
                $Id = $mid["Author_Id"];
                $Videos = mysqli_query($conn, "SELECT * FROM Videos WHERE Author_Id = '$Id'");
                $imisa = mysqli_num_rows($Videos);
                $followers = mysqli_query($conn, "SELECT * FROM Follow WHERE Author_Id = '$Id'");
                $meeqee = mysqli_num_rows($followers);
            ?>
                <tr class="bg-white">
                    <td class="border border-gray-300 p-2 text-blue-600"><h1  class="hover:text-yellow-400 hover:font-bold" onclick="loadAuthor(<?php echo $Id  ?>)"><?php echo $name ?> </h1> </td> 
                    <td class="border border-gray-300 p-2"><h1 class="hover:text-yellow-400 hover:font-bold"  onclick="loadAuthor(<?php echo $Id  ?>)"><?php echo $imisa ?> Video(s) </h1> </td> 
                    <td class="border border-gray-300 p-2"> <h1 class="hover:text-yellow-400 hover:font-bold"  onclick="loadAuthor(<?php echo $Id  ?>)"><?php echo $meeqee ?> Follower(s) </h1></td>
                </tr>
            <?php endwhile;  ?>
            </tbody>
    </table>
           
             
    </div>

            
        </div>
    </section>
    <script>
        function loadAuthor(userId) {
            window.location.href = `others.php?pro=3&data=${userId}`;
        }

    </script>
</body>
</html>