<?php

require_once 'end_user_db.php';


if(isset($_POST['signup'])){
  
    $user_password = $_POST['user_password'];
    $user_fullname = $_POST['user_fullname'];
    $user_address = $_POST['user_address'];
    $user_birth = $_POST['user_birth'];
    $user_contact = $_POST['user_contact'];
    $user_email = $_POST['user_email'];
    $user_gender = $_POST['user_gender'];

    $stmt = $pdo->prepare('INSERT INTO personal_user (user_password , user_fullname, user_address, user_birth, user_contact, user_email, user_gender) VALUES(?,?,?,?,?,?,?)');
    $stmt ->execute([$user_password,$user_fullname,$user_address,$user_birth,$user_contact,$user_email,$user_gender]);
    if($stmt-> rowCount()>0){
        // echo "Successfully Registered";
    
        // header ("Location: ../USER/user_books_cattalog.php");
        echo "<script> alert('Succesfully Registered'); location.replace('../USER/user_books_cattalog.php') </script>";
        // echo"<script>alert('Succesfully Registered')</script>";
    }
    else{
        echo "There is an error please try again";
    }
    

}

?>

<script>

</script>