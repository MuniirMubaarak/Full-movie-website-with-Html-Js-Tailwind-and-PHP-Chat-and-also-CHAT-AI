<?php
$fullName = $_SESSION['Username'];
$firstName = explode(" ", $fullName)[0];






$currentPage = basename($_SERVER['PHP_SELF']);
// echo $currentPage;
if ($currentPage == "Index.php" || $currentPage == "index.php"  ):  // Check if the current page is "Index.php"

    
?>
<!-- Home Page Navigation -->
<nav class="bg-gray-900 fixed w-full z-50 top-0">
    <div class="container mx-auto py-2 flex flex-row justify-between items-center">
        <div class="logo text-left text-3xl text-blue-600 font-semibold">
            <h1>Shawfah </h1>
        </div>
        <div class="search w-1/4">
            <form action="search.php" method="post">
                <input type="search" name="search" id="" placeholder="Search" class="rounded-xl w-full h-10">
            </form>
        </div>
        <div class="navs hidden lg:flex flex-row space-x-3 items-center text-white text-md">
        <a href="Authors.php" class="hover:underline hover:text-orange-400">Subscribed Ones</a>
        <a href="" class="hover:underline hover:text-orange-400">About</a>
        <a href="dheh/" class="hover:underline hover:text-orange-400">Dheh</a>
        <a href="chatmnr/" class="bg-blue-600 text-white px-3 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Chat Our AI</a>

        <a href="Upload.php" class="bg-blue-600 text-white px-3 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Upload</a>
            <div class="profile flex flex-row justify-between space-x-4">
                <a href="Profile.php" class="bg-white text-black px-3 py-2 text-xl rounded-lg hover:bg-blue-600 transition-all duration-300 hover:text-white flex items-center pl-10" style="background-image: url('user_person_people_6100.ico'); background-size: 1.9rem; background-repeat: no-repeat; background-position: 0.6rem center;">
                    <?php echo $firstName; ?>
                </a>
            </div>
        </div>
        <div class="mobile-btn block lg:hidden text-blue-600 mx-5 mt-2">
            <i class="ri-menu-line text-4xl cursor-pointer hover:text-yellow-400"></i>
        </div>
    </div>

    <aside class="mobile-menu hidden  bg-blue-400 w-3/12 rounded-lg text-2xl absolute right-0 h-screen  text-black ">
    <div class="items flex flex-col space-y-3 ">
        <a href="Authors.php" class="hover:underline w-full my-3 hover:text-orange-400">Subscribed Ones</a>
        <a href="chatmnr/" class="hover:underline hover:text-slate-900 w-full my-3">Chat Our AI</a>
        <a href="#" class="hover:underline hover:text-slate-900 w-full my-3">About</a>
        <a href="Dheh/" class="hover:underline hover:text-slate-900 w-full my-3">Dheh</a>
            <a href="Upload.php" class="bg-slate-900 text-white px-5 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Upload</a>
            <a href="Profile.php" class="bg-white text-black px-3 py-2 text-xl rounded-lg hover:bg-blue-600 transition-all duration-300 hover:text-white flex items-center pl-10" style="background-image: url('user_person_people_6100.ico'); background-size: 1.9rem; background-repeat: no-repeat; background-position: 0.6rem center;">
                <?php echo $firstName; ?>
        </a>
    </div>

    </aside>
</nav>

<?php
else:  // The else block if not on Index.php
    
?>
<!-- Other Pages Navigation -->
<nav class="bg-gray-900 fixed w-full z-50 top-0">
    <div class="container mx-auto py-2 flex flex-row  justify-between items-center">
        <div class="logo text-left text-3xl text-blue-600 font-semibold">
            <h1>Shawfah </h1>
        </div>
        <div class="search w-1/4">
            <form action="search.php" method="post">
                <input type="search" name="search" id="" placeholder="Search" class="rounded-xl w-full h-10">
            </form>
        </div>
        <div class="navs hidden lg:flex flex-row space-x-3 items-center text-white text-md">
        <a href="Authors.php" class="hover:underline hover:text-orange-400">Subscribed Ones</a>
        <a href="#" class="hover:underline hover:text-orange-400">About</a>
        <a href="dheh/" class="hover:underline hover:text-orange-400">Dheh</a>
            <a href="chatmnr/" class="bg-blue-600 text-white px-3 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Chat Our AI</a>
            <a href="Index.php" class="bg-blue-600 text-white px-3 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Return to the Home</a>
            <a href="Upload.php" class="bg-blue-600 text-white px-3 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Upload</a>
            <div class="profile flex flex-row justify-between space-x-4">
                <a href="Profile.php" class="bg-white text-black px-3 py-2 text-xl rounded-lg hover:bg-blue-600 transition-all duration-300 hover:text-white flex items-center pl-10" style="background-image: url('user_person_people_6100.ico'); background-size: 1.9rem; background-repeat: no-repeat; background-position: 0.6rem center;">
                    <?php echo $firstName; ?>
                </a>
            </div>
        </div>
        <div class="mobile-btn block lg:hidden text-blue-600 mx-5 mt-2">
            <i class="ri-menu-line text-4xl cursor-pointer hover:text-yellow-400"></i>
        </div>
    </div>

    <div class="mobile-menu hidden lg:hidden bg-blue-400 w-full rounded-lg text-2xl py-50 absolute mt-5 text-black flex flex-col space-y-3 items-center justify-center">
    <a href="Authors.php" class="hover:underline hover:text-orange-400">Subscribed Ones</a>
    <a href="ChatMNR/" class="hover:underline hover:text-slate-900 w-full my-3">Chat Our AI</a>
    <a href="#" class="hover:underline hover:text-slate-900">About</a>
        <a href="Index.php" class="bg-blue-600 text-white px-3 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Return to the Home</a>
        <a href="Upload.php" class="bg-slate-900 text-white px-5 py-2 text-xl rounded-lg hover:bg-blue-800 transition-all duration-300">Upload</a>
        <a href="Profile.php" class="bg-white text-black px-3 py-2 text-xl rounded-lg hover:bg-blue-600 transition-all duration-300 hover:text-white flex items-center pl-10" style="background-image: url('user_person_people_6100.ico'); background-size: 1.9rem; background-repeat: no-repeat; background-position: 0.6rem center;">
            <?php echo $firstName; ?>
        </a>
    </div>
</nav>

<?php
endif;
?>




<script>
const mobile_btn = document.querySelector('.mobile-btn');
const mobile_menu = document.querySelector('.mobile-menu');

mobile_btn.addEventListener('click', () => {
    mobile_menu.classList.toggle("hidden");
})

</script>