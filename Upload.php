<?php 
session_start();
if (!isset($_SESSION['Username']) || !isset($_SESSION['Id'])) {
    header("Location: login.php");
    exit(); // It's good practice to call exit after a header redirection
}
include"connection.php";
// Searching Users Videos
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Handle search query

   

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
    <title>Profile || <?php echo $_SESSION['Username']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.x.x/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="0">
    <!-- The Header -->
<?php include('header.php');  ?>
<div class="hare  h-screen w-full mt-0 flex justify-center items-center">
<section class="w-6/12  bg-slate-900 rounded-xl mx-auto px-10 pb-20 pt-10 text-xl">
        <h1 class="text-3xl text-blue-600 text-center font-bold">Upload Your Videos</h1>
        <div class="container mx-auto text-white">
            <div id="progressContainer" style="display:none;">
                <progress id="progressBar" value="0" max="100" style="width:100%;"></progress>
                <span id="progressText">0%</span>
            </div>
            <form id="uploadForm" action="Uploading.php" method="post" class=" flex flex-col  space-y-3" enctype="multipart/form-data">
                <div class="form-item flex flex-col space-y-2">
                    <label for="Name">Name of the Video</label>
                    <input type="text" name="Name" class="h-10  text-black text-4xl rounded-2xl" id="" required>
                </div>  
                <div class="form-item flex flex-col space-y-2">
                <label for="Category">Category</label>
                <div class="relative">
                    <input type="text" id="categorySearch" name="category" class="rounded-xl h-10 bg-gray-200 text-black w-full" placeholder="Search for category..." autocomplete="on">
                    <ul id="categoryList" class="absolute w-full bg-white text-black border rounded-xl mt-1 max-h-60 overflow-y-auto hidden">
                        <li><span class="category-option">Technology</span></li>
                        <li><span class="category-option">Music</span></li>
                        <li><span class="category-option">Sports</span></li>
                        <li><span class="category-option">Movies</span></li>
                        <li><span class="category-option">Stories</span></li>
                        <li><span class="category-option">Adventure</span></li>
                        <li><span class="category-option">Islamic</span></li>
                        <li><span class="category-option">Christanic</span></li>
                        <li><span class="category-option">Jewishic</span></li>
                        <li><span class="category-option">Relegious</span></li>
                        <li><span class="category-option">Study</span></li>
                        <li><span class="category-option">Self Introducing</span></li>
                        <li><span class="category-option">Skills</span></li>
                        <li><span class="category-option">Money</span></li>
                        <li><span class="category-option">Web Development</span></li>
                        <li><span class="category-option">Horor</span></li>
                        <li><span class="category-option">Network</span></li>
                        <li><span class="category-option">Memoir</span></li>
                        <li><span class="category-option">Self Study</span></li>
                        <li><span class="category-option">Countries</span></li>
                        <li><span class="category-option">War</span></li>


                    </ul>
                </div>
                                </div>  
                <div class="form-item flex flex-col space-y-2">
                    <label for="Thumbnail" class="block text-white">Upload Video Cover</label>
                    <input type="file" name="Thumbnail" id="Thumbnail" class="mt-1 block w-full text-white p-2 border border-gray-300 rounded-2xl" required>
                </div>  
                <div class="form-item flex flex-col space-y-2">
                    <label for="video" class="block text-white">Upload The Video</label>
                    <input type="file" name="video" id="video" class="mt-1 block w-full text-white p-2 border border-gray-300 rounded-2xl" required>
                </div>  
                <div class="form-item flex flex-col space-y-2">
                    <input type="submit" value="Upload" name="Upload" class="cursor-pointer text-white bg-blue-600 rounded-2xl px-3 py-2 hover:bg-blue-800 hover:text-black  transition-all duration-500  text-xl" placeholder="File" id="">
                </div>  
                
            </form>
        </div>
    </section>
</div>
    
<script>
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    var xhr = new XMLHttpRequest();

    // Show the progress bar
    document.getElementById('progressContainer').style.display = 'block';

    xhr.open('POST', 'Uploading.php', true);

    // Update progress bar during the upload
    xhr.upload.onprogress = function(event) {
        if (event.lengthComputable) {
            var percent = (event.loaded / event.total) * 100;
            document.getElementById('progressBar').value = percent;
            document.getElementById('progressText').textContent = Math.round(percent) + '%';
        }
    };

    // Handle successful upload
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Upload successful!');
            document.getElementById('progressContainer').style.display = 'none';  // Hide progress bar
            window.location.href = "index.php";
            location.reload(); 

        } else {
            alert('Error during upload!');
        }
    };

    formData.append("Upload", "true");
    xhr.send(formData);

});
</script>








<script>
    const searchInput = document.getElementById('categorySearch');
const categoryList = document.getElementById('categoryList');
const categoryOptions = document.querySelectorAll('.category-option');

searchInput.addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    categoryList.classList.remove('hidden');
    
    categoryOptions.forEach(option => {
        const text = option.textContent.toLowerCase();
        if (text.includes(searchText)) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });

    if (!searchText) {
        categoryList.classList.add('hidden');
    }
});

categoryOptions.forEach(option => {
    option.addEventListener('click', function() {
        // Set the input value to the clicked category
        searchInput.value = this.textContent;

        // Hide the category list
        categoryList.classList.add('hidden');
    });
});

document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
        categoryList.classList.add('hidden');
    }
});

</script>
</body>
</html>