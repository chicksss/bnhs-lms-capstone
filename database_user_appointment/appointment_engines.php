<?php

require_once "user_appointment.php";
require_once "../BOOKS/book_catalog_db.php";


// require_once "../database_book_catalog/appointment_engine.php";


class CRUD_appoint extends Appointment_DB {

//LINE CHART
    public function appointmentLineChart(){
        $sql = "SELECT DATE_FORMAT(borrowing_date, '%Y-%m-%d') AS borrowing_date, COUNT(*) AS count FROM borrowings GROUP BY borrowing_date ORDER BY borrowing_date ASC";
        $stmt =  $this->connect()->query($sql);
        return $stmt;

    }

    //FILTER DATE
    public function filterDate($start_date,$end_date){
         $sql = "SELECT DATE_FORMAT(borrowing_date, '%Y-%m-%d') AS borrowing_date, COUNT(*) AS count
                FROM borrowings
                WHERE borrowing_date BETWEEN :start_date AND :end_date
                GROUP BY borrowing_date
                ORDER BY borrowing_date ASC";

        $stmt = $this->connect()->prepare($sql);
        return $stmt;   
    } 


 
 
//  public function appointmentResult($seletedCategory) {
//         $otherDatabase = 'books';   
//         $sql = "SELECT appointments.borrowings.appointment_Id,appointments.borrowings.generateId, appointments.borrowings.borrower_name, appointments.borrowings.borrowing_date, appointments.borrowings.borrower_contact,appointments.borrowings.appointmentDate, $otherDatabase.$seletedCategory.title, $otherDatabase.$seletedCategory.status FROM appointments.borrowings INNER JOIN $otherDatabase.$seletedCategory ON appointments.borrowings.book_number = $otherDatabase.$seletedCategory.book_Id ORDER BY appointments.borrowings.appointment_Id DESC";
//         $stmt = $this->connect()->prepare($sql);
//         $stmt->execute();
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }

// public function appointmentResult() {
        
//         $sql = "SELECT * FROM borrowings ORDER BY appointment_Id DESC";
//         $stmt = $this->connect()->prepare($sql);
//         $stmt->execute();
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }


    


public function user_get_id($appointment_Id) {
    $sql = "SELECT * FROM borrowings WHERE appointment_Id = :appointment_Id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':appointment_Id', $appointment_Id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function deleteAppoointment($appointment_Id){
    $sql = "DELETE FROM borrowings WHERE appointment_Id = :appointment_Id";
    $stmt = $this->connect()->prepare($sql);
    return $stmt->execute(['appointment_Id'=>$appointment_Id]);

}

public function insert_user_borrow($borrow_name,$borrow_book_title,$borrow_user_id,$borrow_date){
     $sql = 'INSERT INTO user_borrowed (borrow_name,borrow_book_title,borrow_user_id,borrow_date) VALUES (:borrow_name,:borrow_book_title,:borrow_user_id,:borrow_date)';
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute(['borrow_name' => $borrow_name, 'borrow_book_title' => $borrow_book_title, 'borrow_user_id' => $borrow_user_id, 'borrow_date' => $borrow_date]);
}

public function get_user_borrowed() {
    $sql = "SELECT * FROM user_borrowed";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function get_one_user_borrowed($borrow_id) {
    $sql = "SELECT * FROM user_borrowed WHERE borrow_id = :borrow_id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':borrow_id', $borrow_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

  


public function appointmentResult($seletedCategory) {
    $otherDatabase = 'books';   





    $sql = "SELECT 
                appointments.borrowings.appointment_Id,
                appointments.borrowings.generateId, 
                appointments.borrowings.borrower_name, 
                appointments.borrowings.borrowing_date, 
                appointments.borrowings.borrower_contact,
                appointments.borrowings.appointmentDate,
                appointments.borrowings.user_id,
                $otherDatabase.$seletedCategory.book_Id, 
                $otherDatabase.$seletedCategory.title, 
                $otherDatabase.$seletedCategory.book_call_number,
                $otherDatabase.$seletedCategory.status 

            FROM 
                appointments.borrowings 
            INNER JOIN 
                $otherDatabase.$seletedCategory ON appointments.borrowings.book_number = $otherDatabase.$seletedCategory.book_Id 
            ORDER BY 
                appointments.borrowings.appointment_Id DESC";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}





// public function appointmentResult($seletedCategory) {
//     $otherDatabase = 'books';   
//     $sql = "SELECT 
//                 appointments.borrowings.generateId, 
//                 appointments.borrowings.borrower_name, 
//                 appointments.borrowings.borrowing_date, 
//                 appointments.borrowings.borrower_contact,
//                 FLOOR((UNIX_TIMESTAMP(appointments.borrowings.appointmentDate) - UNIX_TIMESTAMP(DATE_SUB(appointments.borrowings.appointmentDate, INTERVAL 1 DAY))) / (24 * 3600)) AS differenceInDays,
//                 $otherDatabase.$seletedCategory.title, 
//                 $otherDatabase.$seletedCategory.status 
//             FROM 
//                 appointments.borrowings 
//             INNER JOIN 
//                 $otherDatabase.$seletedCategory ON appointments.borrowings.book_number = $otherDatabase.$seletedCategory.book_Id 
//             ORDER BY 
//                 appointments.borrowings.appointment_Id DESC";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }




    
public function getAllAppointmentList($user_id){
    $sql = "SELECT * FROM appointments.borrowings WHERE user_id = :user_id ORDER BY user_id DESC";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// public function getAllBorrowedList($user_id){
//     $sql = "SELECT borrow_user_id FROM appointments.user_borrowed WHERE user_id = :user_id ORDER BY user_id DESC";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

public function getAllBorrowedList($user_id) {
    $sql = "SELECT borrow_user_id,borrow_name,borrow_book_title,borrow_date  FROM appointments.user_borrowed WHERE borrow_user_id = :borrow_user_id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':borrow_user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

 

//  public function getUserAppointments($user_id) {
//         $sql = "SELECT * FROM appointments.borrowings WHERE appointment_Id = :appointment_Id";
//         $stmt = $this->connect()->prepare($sql);
//         $stmt->bindParam(':appointment_Id', $user_id, PDO::PARAM_INT);
//         $stmt->execute();
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }


 public function getUserAppointments() {
        $sql = "SELECT * FROM borrowings";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   

}

?>