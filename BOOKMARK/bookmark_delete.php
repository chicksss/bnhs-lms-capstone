<?php

// require "../END_USER/end_user_db.php";
// require "../database_book_catalog/book_catalog_db.php";
 
require_once "bookmark_engine.php";
require_once "bookmark_db.php";

session_start();
 $userbookmark = new BOOKMARK();

 if(isset($_GET['bookmark_id'])){
    $bookmark_id = $_GET['bookmark_id'];
    // $stmt = $bookmark_pdo->prepare('SELECT * FROM bookmark_db.bookmarks WHERE bookmark_id = :bookmark_id');
    // $stmt->bindParam(':bookmark_id', $bookmark_id);
    // $stmt->execute();
    // $deleteBookmark = $stmt->fetch(PDO::FETCH_ASSOC);

    $delete_bookmark = $userbookmark->getBookmarkToDelete($bookmark_id);
 }


if($_SERVER['REQUEST_METHOD'] === 'POST'){
 if(isset($_POST['bookmark_id'])){
    $delete_bookmark = $_POST['bookmark_id'];
    $stmt = $userbookmark->bookmarkDelete($delete_bookmark);
    echo "<script> alert('Deleted'); location.replace('../HOMEPAGE/homepage_catalog.php') </script>";
 }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../NAVIGATION/my.css" />
    <link rel="stylesheet" href="../NAVIGATION/end_user_sidebar.css">

    <!-- MODAL -->

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/6122121193.js" crossorigin="anonymous"></script>


    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- ICONS AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>DELETE BOOKMARK</title>
</head>



<body class="bg-[#f5ebe0]">


    <br><br><br><br>
    <div class="container" style="text-align:center">
        <h1 style="color:black">Delete your bookmark?</h1>

        <form action="bookmark_delete.php" method="POST">
            <input type="hidden" name="bookmark_id" value="<?php echo $delete_bookmark['bookmark_id']; ?>" id="">
            <!-- <input type="submit" class="btn btn-danger" value="Yes"> -->
            <button type="submit" class="btn btn-danger"> Yes</button>
        </form>
        <br>

    </div>



</body>

</html>