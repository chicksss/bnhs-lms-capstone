<?php


require_once "bookmark_db.php";

class BOOKMARK extends BookmarkDB {

 
//   public function checkBookmarked($user_id, $selectedTable, $book_id) {
//     $bookmark_sql = "SELECT COUNT(*) FROM bookmarks WHERE user_id = ? AND table_name = ? AND book_id = ?";
//     $bookmark_stmt = $this->connect()->prepare($bookmark_sql);
//     $bookmark_stmt->execute([$user_id, $selectedTable, $book_id,]);
//     return $bookmark_stmt->fetchColumn() > 0;
// }

public function checkBookmarked($user_id, $selectedTable, $book_id) {
    $bookmark_sql = "SELECT COUNT(*) FROM bookmarks WHERE user_id = ? AND table_name = ? AND book_id = ?";
    $bookmark_stmt = $this->connect()->prepare($bookmark_sql);
    $bookmark_stmt->execute([$user_id, $selectedTable, $book_id]);
    return $bookmark_stmt->fetchColumn() > 0;
}

 

public function checkBookmarkedAll($user_id,  $book_id) {
    $bookmark_sql = "SELECT COUNT(*) FROM bookmarks WHERE user_id = ? AND book_id = ?";
    $bookmark_stmt = $this->connect()->prepare($bookmark_sql);
    $bookmark_stmt->execute([$user_id, $book_id]);
    return $bookmark_stmt->fetchColumn() > 0;
}





    public function InsertBookmark($selectedTable, $book_id, $user_id)
{
    try {
        $sql = "INSERT INTO bookmarks (user_id, table_name, book_id) VALUES (?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $selectedTable);
        $stmt->bindParam(3, $book_id);
        $stmt->execute();
        header("Location: ../HOMEPAGE/homepage_catalog.php?table=" . $selectedTable);
        
        return true; // Indicate success
    } catch (PDOException $e) {
        // Handle the error. You might want to log it or display a user-friendly message.
        error_log("Error inserting bookmark: " . $e->getMessage());
        return false; // Indicate failure
    }
}

  public function InsertBookmarkAll($book_id, $user_id)
{
    try {
        $sql = "INSERT INTO bookmarks (user_id, book_id) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $book_id);
        $stmt->execute();
        header("Location: ../HOMEPAGE/homepage_catalog.php");
        
        return true; // Indicate success
    } catch (PDOException $e) {
        // Handle the error. You might want to log it or display a user-friendly message.
        error_log("Error inserting bookmark: " . $e->getMessage());
        return false; // Indicate failure
    }
}
 







// public function getAllBookmark($user_id){
//     $sql = "SELECT b.bookmark_id, u.user_id  
//     FROM bookmarks b
//     INNER JOIN users u ON b.bookmark_id = u.user_id";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

// public function getAllBookmark($user_id){
//     $sql = "SELECT * FROM bookmarks WHERE user_id = user_id";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

public function getAllBookmark($user_id){
    $sql = "SELECT * FROM bookmarks WHERE user_id = :user_id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}











// bookmark Notification
public function bookmarkNotification($user_id){
    $sql = "SELECT * FROM bookmarks WHERE user_id = :user_id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//getBookmarktoDelete
public function getBookmarkToDelete($bookmark_id){
     
    $stmt = $this->connect()->prepare('SELECT * FROM bookmarks WHERE bookmark_id = :bookmark_id');
    $stmt->bindParam(':bookmark_id', $bookmark_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//bookmarkDelete

public function bookmarkDelete($delete_bookmark){
    $stmt = $this->connect()->prepare('DELETE FROM bookmarks WHERE bookmark_id = :bookmark_id');
    $stmt->bindParam(':bookmark_id', $delete_bookmark);
    $stmt->execute();
    return $stmt;
}


//getEndUserProfile
public function getEndUserProfile($user_id){

    $sql = "SELECT * FROM bookmarks WHERE user_id = :user_id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}



 
}


?>