<?php
require_once "admin_login_db.php";



class CRUDADMIN extends adminLogin {

    

    public function adminLog($username, $password){
    $sql = "SELECT * FROM staffs WHERE username = :username AND password = :password";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['username' => $username, 'password' => $password]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    
    }



    //adminList
    public function adminList(){
        $stmt = $this->connect()->prepare("SELECT * FROM staffs");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function totalActiveAdmin(){
    $sql = "SELECT COUNT(admin_id) as total_active_admins FROM staffs WHERE admin_status = 'active'";
    $stmt = $this->connect()->query($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_active_admins'];
}


    //admin validation

    public function adminValidation($username, $password,$userId){
        $statement = $this->connect()->prepare("SELECT * FROM staffs WHERE admin_Id = :admin_Id");
        $statement->bindParam(':admin_Id', $userId);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);

    }


    //admin manage

    public function adminManage($admin_Id){
        $statement = $this->connect()->prepare("SELECT * FROM staffs WHERE admin_Id = :admin_Id");
        $statement->bindParam(':admin_Id', $admin_Id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC); 
    }


    //adminProfile
    public function adminProfile($admin_Id){
        $statement = $this->connect()->prepare("SELECT * FROM staffs WHERE admin_Id = :admin_Id");
        $statement->bindParam(':admin_Id', $admin_Id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);

    }


    //updateProfile

    public function updateProfile($admin_Id,$username,$password,$fullname_admin,$contact_admin,$address_admin,$email_admin,$admin_role){
        $sql = "UPDATE staffs SET username = :username, password = :password, fullname_admin = :fullname_admin,contact_admin = :contact_admin, address_admin = :address_admin, email_admin = :email_admin, admin_role = :admin_role WHERE admin_Id = :admin_Id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute(['admin_Id' => $admin_Id, 'username' => $username, 'password' => $password , 'fullname_admin' => $fullname_admin, 'contact_admin' => $contact_admin, 'address_admin'=> $address_admin, 'email_admin' => $email_admin, 'admin_role' => $admin_role]);
    }


     public function SuperupdateProfile($admin_Id,$username,$password,$fullname_admin,$contact_admin,$address_admin,$email_admin,$admin_role,$admin_status){
        $sql = "UPDATE staffs SET username = :username, password = :password, fullname_admin = :fullname_admin,contact_admin = :contact_admin, address_admin = :address_admin, email_admin = :email_admin, admin_role = :admin_role, admin_status = :admin_status WHERE admin_Id = :admin_Id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute(['admin_Id' => $admin_Id, 'username' => $username, 'password' => $password , 'fullname_admin' => $fullname_admin, 'contact_admin' => $contact_admin, 'address_admin'=> $address_admin, 'email_admin' => $email_admin, 'admin_role' => $admin_role, 'admin_status' => $admin_status]);
    }
    



    //selectAdminUpdate
    public function selectAdminUpdate($admin_Id){
        $query = "SELECT * FROM staffs WHERE admin_Id = ?";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute([$admin_Id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //updateProfile
    public function updatedImage($admin_Id,$image){
            $sql = "UPDATE staffs SET image = :image WHERE admin_Id = :admin_Id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":image",$image);
            $stmt->bindParam(":admin_Id",$admin_Id);
            $stmt->execute();
            return $stmt;
        
    }

      public function SuperupdatedImage($admin_Id,$image){
            $sql = "UPDATE staffs SET image = :image WHERE admin_Id = :admin_Id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":image",$image);
            $stmt->bindParam(":admin_Id",$admin_Id);
            $stmt->execute();
            return $stmt;
        
    }

 
   public function AddNewAdmin($username, $password, $fullname_admin, $contact_admin, $address_admin, $email_admin, $admin_role)
{
    try {
        if ($_FILES["image"]["error"] === 4) {
            throw new Exception("Image does not exist");
        } else {
            $fileName = $_FILES["image"]["name"];
            $fileSize = $_FILES["image"]["size"];
            $tmpName = $_FILES["image"]["tmp_name"];

            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));

            if (!in_array($imageExtension, $validImageExtension)) {
                throw new Exception("Invalid image file extension");
            } elseif ($fileSize > 1000000) {
                throw new Exception("Image is too large");
            } else {
                $newImageName = uniqid();
                $newImageName .= '.' . $imageExtension;

                move_uploaded_file($tmpName, '../admin_profiles/' . $newImageName);

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO staffs (username, password, fullname_admin, contact_admin, address_admin, email_admin, image, admin_role) VALUES (:username, :password, :fullname_admin, :contact_admin, :address_admin, :email_admin, :image, :admin_role)";
                $stmt = $this->connect()->prepare($sql);
                $result = $stmt->execute([
                    'username' => $username,
                    'password' => $hashedPassword,
                    'fullname_admin' => htmlspecialchars($fullname_admin),
                    'contact_admin' => htmlspecialchars($contact_admin),
                    'address_admin' => htmlspecialchars($address_admin),
                    'email_admin' => htmlspecialchars($email_admin),
                    'image' => $newImageName,
                    'admin_role' => htmlspecialchars($admin_role),
                ]);

                if ($result) {
                    // Successful insertion
                    echo '<script>alert("Admin added successfully")</script>';
                } else {
                    // Error during insertion
                    echo '<script>alert("Error adding admin")</script>';
                }
            }
        }
    } catch (Exception $e) {
        // Handle exceptions
        echo '<script>alert("' . $e->getMessage() . '")</script>';
    }
}





    //get id to forgot password
    public function getUserById($admin_Id){
        $sql = "SELECT * FROM staffs WHERE admin_Id = :admin_Id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['admin_Id' => $admin_Id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   
    //new password
    public function updatePassword($admin_Id,$password){
        $sql = "UPDATE staffs SET password = :password WHERE admin_Id = :admin_Id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute(['admin_Id' => $admin_Id, 'password'=>$password]);
    }

 
}

?>