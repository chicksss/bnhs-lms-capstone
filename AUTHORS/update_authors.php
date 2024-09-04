<?php
   ob_start();
session_start();
 include "../dashdesign.php";
require "author_db.php";
require "authors_engine.php";
$myAuthors = new authorsBook();
 


if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $myAuthors->SelectedUpdateAuthor($id);
}

 

if (isset($_POST['adbook'])) {
    $id = $_POST['id'];
    $author_name  = $_POST['author_name'];
    $myAuthors->updateAuthor($id, $author_name);
}

 ob_end_flush();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../src/output.css" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>

    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>

    <div class="ml-52 p-2">
        <div class="absolute mt-[-50px]">
            <h1 class="text-2xl font-bold px-3">UDPATE AUTHORS</h1>
        </div>
        <div class="grid justify-center">

            <?php if($result){ ?>
            <form method="POST" action="update_authors.php">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                <div class="form-group">
                    <label for="author" class="font-bold" style="color:black">Author</label> <br>
                    <input type="text" class="rounded-lg p-2" placeholder="Enter Book Author" name="author_name"
                        id="author_name" value="<?php echo $result['author_name'] ?>" required>
                    <input type="submit" class="rounded-lg px-6 p-2" style="background: #dda15e" name="adbook"
                        value="Update">
                </div>

            </form>

            <?php } ?>
        </div>


    </div>

</body>

</html>