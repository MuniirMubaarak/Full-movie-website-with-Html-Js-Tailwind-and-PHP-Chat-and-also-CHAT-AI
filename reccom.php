<?php
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
    $queryFetch = mysqli_query($conn, $videoQueryLovedCategories);
    // Extract the other video details
    $Muuqaalo[] = "";
    while ($row = mysqli_fetch_assoc($queryFetch)) {
        $Muuqaalo[] = [
            'VId' => $row['Id'],
            'VName'=> $row['Name'],
            'VAuthor'=> $row['Author'],
            'VAuthor_Id'=> $row['Author_Id'],
            'VCover'=> $row['Cover'],
            'VPlace' => $row['Place'],
            'VCategory'=> $row['Category'],
            'VDate'=> $row['Date'],
        ];
    }
    echo '<script>const Muuqaalo = ' . json_encode($Muuqaalo) . ';</script>';
