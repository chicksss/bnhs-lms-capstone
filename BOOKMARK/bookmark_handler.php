<?php
require '../DATABASE/book_catalog_db.php';
require '../BOOKS/book_catalog_engine.php';
require_once 'bookmark_db.php';
require_once 'bookmark_engine.php';
session_start();

$bookmark = new BOOKMARK();

if (isset($_SESSION['user_id']) && isset($_GET['id'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = $_GET['id'];

    if (isset($_GET['table'])) {
        $selectedTable = $_GET['table'];

        if ($bookmark->InsertBookmark($selectedTable, $book_id, $user_id)) {
            echo "Success";
        } else {
            echo "Bookmark insertion failed.";
        }
    } else {
        if ($bookmark->InsertBookmarkAll($book_id, $user_id)) {
            echo "Success";
        } else {
            echo "Bookmark insertion failed in all books.";
        }
    }
} else {
    echo "User ID or book ID not provided.";
}
?>