<?php

session_start();
include("connection.php");

if (isset($_POST["Register"])) {
    // Get user inputs
    $Name = $_POST["Name"];
    $Email = $_POST["Email"];
    $Password = $_POST["Password"]; // Hash the password

    // Check if the email already exists in the database
    $checkStmt = $conn->prepare("SELECT * FROM Users WHERE Email = ?");
    $checkStmt->bind_param("s", $Email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "Please Log in";
        $checkStmt->close();
        $conn->close();
    } else {
        // Insert the new user into the database
        $insertStmt = $conn->prepare("INSERT INTO Users (Username, Email, Password) VALUES (?, ?, ?)");
        $insertStmt->bind_param("sss", $Name, $Email, $Password);

        if ($insertStmt->execute()) {
            echo "Inserted Successfully";
            $geting = mysqli_query($conn , "SELECT * FROM Users Where Username
            = '$Name' AND Email = '$Email ' And Password = '$Password'");
            $mid = mysqli_fetch_array($geting);
            $_SESSION['Username'] = $Name;
            $_SESSION['Id'] = $mid['Id'];
            header("location: index.php");
            exit;
        } else {
            echo "Error";
        }

        $insertStmt->close();
    }

    // Close the check statement and database connection
    $checkStmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <title>Shawfah|| Register </title>
</head>
<body class="max-w-screen bg-slate-200 ">
<section id="register" class=" flex justify-center items-center h-screen">
        <div class="mx-auto bg-white  flex flex-col space-y-3 w-6/12">
            <h1 class="text-yellow-400 font-bold text-5xl text-center">Register</h1>

            <form action="" method="post" class="w-full flex flex-col space-y-3">
                <div class="form-item flex flex-col space-y-2  ml-2 text-slate-950">
                    <label for="Name" class="text-xl text-blue-600">Username</label>
                    <input type="text" name="Name" id="" class="w-full h-14 text-xl" placeholder="Username">
                </div>
                <div class="form-item flex flex-col space-y-2  ml-2 text-slate-950">
                    <label for="Email" class="text-xl text-blue-600">Email</label>
                    <input type="email" name="Email" id="" class="w-full h-14 text-xl" placeholder="Email">
                </div>

                <div class="form-item flex flex-col space-y-2  ml-2">
                    <label for="Password" class="text-xl text-blue-600">Password</label>
                    <input type="password" name="Password" id="" class="w-full h-14 text-xl" placeholder="Password">
                </div>

                <div class="form-item flex flex-col space-y-2  ml-2">
                    <input type="submit" name="Register" id="" class="w-full h-14 text-md text-blue-700 bg-slate-950 hover:bg-yellow-400 hover:text-white text-xl px-3 py-2  cursor-pointer rounded-md duration-300 transition-all" value="Register" >
                </div>

                <div class="form-item flex flex-col md:flex-row space-y-1 md:justify-between  ml-2">
                    <span class="text-blue-600 text-md ">I have an account </span>
                    <a href="login.php" id="log" class="text-blue-700 font-bold text-md underline ">Welcome again To Place you loved it</a>
                </div>
            </form>
        </div>
    </section>
</body>
</html>