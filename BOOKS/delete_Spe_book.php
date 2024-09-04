<?php
ob_start();
require_once "../DATABASE/book_catalog_db.php";
require_once "book_catalog_engine.php";
require_once "../AUTHORS/author_db.php";
require_once "../AUTHORS/authors_engine.php";
 

$myAuthors = new authorsBook();
$tables = [];

session_start();
$crud = new CRUD();
include "../dashdesign.php";
 

// if (isset($_POST['delete'])) {
//     $id = $_POST['id'];
//     $results = $myAuthors->deleteBook_authors_Spe($id); 
//     header ("Location: add_more_authors.php?=".$id);
//     exit();
// }


//this is the book in other page hwo can i combine this two to redirectly return id book id


if (isset($_POST['delete'])) {
    $book_id = $_GET['id'];
    $id = $_POST['id'];
    $results = $myAuthors->deleteBook_authors_Spe($id); 

  
// Redirect back to the add_more_authors page with the book_id
header("Location: add_more_authors.php?book_id=$book_id");
exit;
   
}
  




if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $myAuthors->SelectbookAtoDelete($id);

}

ob_end_flush();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="ml-52 p-2">



        <div class="grid justify-center py-24">
            <?php if($result) { ?>
            <h2 class="text-xl font-semibold mb-4 text-center">Confirm Deletion</h2>
            <!-- <?php echo $result['author_name'] ?> -->
            <form action="delete_Spe_book.php" class="flex justify-center" method="post">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                <button type="submit" class="rounded-lg px-3 py-2 bg-red-500 text-white" name="delete">Delete</button>
            </form>

            <?php } ?>

        </div>


    </div>
</body>

</html>