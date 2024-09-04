<?php


require_once "end_user_db.php";

class END_USERS extends End_UsersDB {
    public function EndUserRegister($user_LRN, $user_email, $user_password, $user_fullname,$user_MiddleName, $user_LastName, $user_address, $user_birth, $user_contact, $user_gender, $user_status, $user_grade){
        $stmt = $this->connect()->prepare('INSERT INTO users (user_LRN,user_email,user_password,user_fullname, user_MiddleName, user_LastName, user_address,user_birth,user_contact,user_gender,user_status,user_grade) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)');
        $stmt ->execute([$user_LRN, $user_email, $user_password, $user_fullname, $user_MiddleName, $user_LastName, $user_address, $user_birth,$user_contact, $user_gender, $user_status, $user_grade]);
        return $stmt;
    }

   public function EndUserLogin($user_email, $user_password) {
    $sql = "SELECT user_id, user_fullname, user_MiddleName, user_LastName, user_status, user_address, user_password, user_LRN, user_contact FROM users WHERE user_email = :user_email AND user_password = :user_password";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':user_email', $user_email,PDO::PARAM_STR);
    $stmt->bindParam(':user_password', $user_password,PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function GetUserStatus($user_email){
    $sql = "SELECT user_status FROM users WHERE user_email = :user_email";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['user_email' => $user_email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['user_status']: null;

}


    public function UserSessioninBook($user_id){
        $sql = 'SELECT * FROM users WHERE user_id = :user_id';
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':user_id', $user_id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEndUser_Id($user_id){
        $statement = $this->connect()->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $statement->execute(['user_id'=> $user_id]);
        return $statement->fetch(PDO::FETCH_ASSOC); 
    }

  public function bannedUser($user_id, $user_status) {
    $sql = "UPDATE users SET user_status = :user_status WHERE user_id = :user_id";
    try {
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_status', $user_status, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        // Handle any potential exceptions
        echo "Error: " . $e->getMessage();
        return false;  // Return false to indicate failure
    }
}


public function updateUserProfile($user_id, $user_LRN, $user_fullname, $user_MiddleName, $user_LastName, $user_email,$user_address,$user_birth,$user_contact,$user_gender,$user_grade){
    $sql = "UPDATE users SET user_fullname = :user_fullname, user_LRN = :user_LRN, user_MiddleName = :user_MiddleName, user_LastName = :user_LastName, user_email = :user_email, user_address = :user_address, user_birth = :user_birth, user_contact = :user_contact, user_gender = :user_gender, user_grade = :user_grade WHERE user_id = :user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        
        $stmt->bindParam(':user_fullname', $user_fullname, PDO::PARAM_STR);
        
        $stmt->bindParam(':user_LRN', $user_LRN, PDO::PARAM_INT);

        $stmt->bindParam(':user_MiddleName', $user_MiddleName, PDO::PARAM_STR);

        $stmt->bindParam(':user_LastName', $user_LastName, PDO::PARAM_STR);
        
        $stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
        $stmt->bindParam(':user_address', $user_address, PDO::PARAM_STR);
        $stmt->bindParam(':user_birth', $user_birth, PDO::PARAM_STR);
        $stmt->bindParam(':user_contact', $user_contact, PDO::PARAM_INT);
        $stmt->bindParam(':user_gender', $user_gender, PDO::PARAM_STR);
        $stmt->bindParam(':user_grade', $user_grade, PDO::PARAM_STR);
       
        
        return $stmt->execute();
}

// public function getAllUser(){
//     $sql = 'SELECT users.*, 
//                    SUM(CASE WHEN borrowings.status = \'Penalty\' THEN 1 ELSE 0 END) as penaltyCount
//             FROM users 
//             LEFT JOIN borrowings ON users.user_id = borrowings.user_id 
//             GROUP BY users.user_id
//             ORDER BY users.user_id ASC';
//     $stmt = $this->connect()->query($sql);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

public function getAllUser(){
    $sql = 'SELECT users.*, 
             SUM(borrowings.penaltyCount) as AllpenaltyCount
    FROM users
    LEFT JOIN borrowings ON users.user_id = borrowings.user_id
    GROUP BY users.user_id
    ORDER BY users.user_id ASC';

    $stmt = $this->connect()->query($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// total students
public function getAllUserTOTAL(){
    $sql = 'SELECT COUNT(user_id) as total_users FROM users';
    $stmt = $this->connect()->query($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_users'];
}






public function checkLRnUser($user_LRN){
    $sql = "SELECT user_LRN FROM users WHERE user_LRN = :user_LRN";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':user_LRN', $user_LRN, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result !== false;
}


public function selectAllStudentsinAccount($result_per_page, $offset){

  

    $sql = 'SELECT users.*, SUM(borrowings.penaltyCount) as AllpenaltyCount, borrowings.status
    FROM users
    LEFT JOIN borrowings ON users.user_id = borrowings.user_id AND borrowings.status = "Penalty"
    GROUP BY users.user_id
    ORDER BY users.user_id ASC
    LIMIT :limit OFFSET :offset';
  
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindValue(':limit',$result_per_page,PDO::PARAM_INT);
    $stmt->bindValue(':offset',$offset,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


     public function CountgetAllUser() {
    try {
        $sql = 'SELECT COUNT(user_id) AS TOTALuser FROM users';
        $stmt = $this->connect()->query($sql);

        // Fetch the result as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle any exceptions
        die("Error: " . $e->getMessage());
    }
}



public function SeegetUser($user_id){
    $sql = 'SELECT * FROM users WHERE user_id = :user_id';
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



 public function getUserBorrowedBooks($user_id){
    $sql = 'SELECT users.*, borrowings.*, borrowings.book_Id, borrowings.status
            FROM users 
            INNER JOIN borrowings ON users.user_id = borrowings.user_id 
            WHERE users.user_id = :user_id 
            ORDER BY borrowings.appointment_Id DESC';
    
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
 


    public function SelectgetUserBorrowedBooks($user_id, $results_per_page, $offset){
    $sql = 'SELECT users.*, borrowings.*, borrowings.book_Id, borrowings.status
            FROM users 
            INNER JOIN borrowings ON users.user_id = borrowings.user_id 
            WHERE users.user_id = :user_id 
            ORDER BY borrowings.appointment_Id DESC
            LIMIT :offset, :results_per_page';
    
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




// public function getPagination($user_id, $offSet, $perPage) {
//     $sql = 'SELECT users.*, borrowings.*, borrowings.book_Id
//             FROM users 
//             INNER JOIN borrowings ON users.user_id = borrowings.user_id 
//             WHERE users.user_id = :user_id 
//             ORDER BY borrowings.appointment_Id DESC
//             LIMIT :offset, :perPage';

//     $stmt = $this->connect()->prepare($sql);
//     $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
//     $stmt->bindParam(':offset', $offSet, PDO::PARAM_INT);
//     $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
//     $stmt->execute();

//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

// Function to get total number of records
public function getTotalRecords($user_id) {
    $sql = 'SELECT COUNT(*) as total_records
            FROM users 
            INNER JOIN borrowings ON users.user_id = borrowings.user_id 
            WHERE users.user_id = :user_id';

    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total_records'];
}








    public function deleteUser($user_id){
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute(['user_id'=>$user_id]);
    }


   

}

?>