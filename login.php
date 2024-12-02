<?php
session_start();
include("connection.php");

if (isset($_POST["Login"])) {
    $email = $_POST["Name"];
    $password = $_POST["Password"];
    // Sanitize inputs
    $email = stripslashes($email);
    $password = stripslashes($password);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    // Perform the query and check for errors
    $query = "SELECT * FROM Users WHERE Username = '$email' AND Password = '$password'";
    $result = mysqli_query($conn, $query);
   
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $Id = $row["Id"];
            // Uncomment to start a session if needed
            $_SESSION['Id'] = $Id;
            $_SESSION['Username'] = $email;
            mysqli_close( $conn );
            $to = "asaddiinpage@gmail.com"; // Recipient's email address
            $subject = "Welcome to Our Website"; // Subject of the email
            $message = "Hello, thank you for registering!"; // Message body
            $headers = "From: your-email@example.com"; // Sender's email address
            mail($to, $subject, $message, $headers);
             header('Location: index.php');
            exit();
        } else {
            echo '<h1 class="text-6xl text-red-500 ">Incorrect</h1>';
        }
    
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <title>Shawfah|| Login </title>
</head>
<body class="max-w-screen bg-slate-200 ">

    <section id="login" class="flex justify-center items-center w-full h-screen">
        <div class="px-14 bg-white  flex flex-col space-y-3 ">
            <h1 class="text-yellow-400 font-bold text-5xl text-center">Login</h1>
            <form action="" method="post" class="w-full flex flex-col space-y-3">
                <div class="form-item flex flex-col space-y-2  ml-2 text-slate-950">
                    <label for="Name" class="text-xl text-blue-600">Username</label>
                    <input type="text" name="Name" id="" class="w-full h-14 text-xl" placeholder="Username">
                </div>

                <div class="form-item flex flex-col space-y-2  ml-2">
                    <label for="Name" class="text-xl text-blue-600">Password</label>
                    <input type="password" name="Password" id="" class="w-full h-14 text-xl" placeholder="Password">
                </div>

                <div class="form-item flex flex-col space-y-2  ml-2">
                    <input type="submit" name="Login" id="" class="w-full h-14 text-md text-blue-700 bg-slate-950 hover:bg-yellow-400 hover:text-white text-xl px-3 py-2  cursor-pointer rounded-md duration-300 transition-all" value="Login" >
                </div>

                <div class="form-item flex flex-col md:flex-row space-y-3 lg:justify-between  ml-2">
                    <span class="text-yellow-600 text-md ">I'm new to here </span>
                    <a href="register.php" id="reg" class="text-yellow-700 font-bold text-md underline ">Welcome To People who love You</a>
                </div>
            </form>
        </div>
    </section>

  

 


  
</body>
</html>