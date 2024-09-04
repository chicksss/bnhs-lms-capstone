<?php
session_start();
include "../dashdesign.php";

// require_once "../database_user_appointment/user_appointment.php";
// require_once "../database_user_appointment/appointment_engine.php";
// require_once "admin_login_engine.php";
// require_once "admin_login_db.php";
 require_once "../ADMIN_LOGIN/admin_login_engine.php";
 require_once "../ADMIN_LOGIN/admin_login_db.php";
 $crud = new CRUDADMIN();


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullname_admin = $_POST['fullname_admin'];
    $contact_admin = $_POST['contact_admin'];
    $address_admin = $_POST['address_admin'];
    $email_admin = $_POST['email_admin'];
    $admin_role = $_POST['admin_role'];

    $stmt = $crud->AddNewAdmin($username,$password,$fullname_admin,$contact_admin,$address_admin,$email_admin,$admin_role);
}
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
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


</head>


<body>


    <div class="ml-52">
        <div class="absolute mt-[-40px]">
            <h1 class="text-2xl font-bold px-3">ADMIN</h1>
        </div>


        <div class="px-6 py-10">
            <button data-modal-target="default-modal" data-modal-toggle="default-modal"
                class="block text-black font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                style="background: #d4a373" type="button">
                Add new
            </button>
            <br>
            <table class="w-full text-xl px-5 text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-lg py-3">
                        <th scope="col">ID</th>
                        <th scope="col">Fullname</th>
                        <th scope="col">Role</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php   
                        $users = $crud->adminList();
                      
                        foreach ($users as $user){ ?>
                    <tr>
                        <td class="py-3"><?php echo $user['admin_Id']; ?></td>
                        <td><?php echo $user['fullname_admin']; ?></td>
                        <td><?php echo $user['admin_role']; ?></td>
                        <td><?php echo $user['admin_status']; ?></td>
                        <td><button> <a class="a"
                                    href="../ADMIN_LOGIN/admin_validation.php?id=<?php echo $user['admin_Id'];?>"
                                    style="color:black"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="currentColor" class="size-6">
                                        <path
                                            d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                                    </svg>
                                </a>
                            </button>




                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 py-10 flex justify-center px-96">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="flex justify-between gap-10">

                        <div class="col">

                            <div class="form-group">
                                <label style="font-weight:900" for="formGroupExampleInput">Name</label>
                                <input type="text" class="rounded-lg px-4 py-2" name="fullname_admin"
                                    placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label style="font-weight:900" for="formGroupExampleInput2">Address</label>
                                <input type="text" name="address_admin" class="rounded-lg px-4 py-2"
                                    placeholder="Address">
                            </div>
                            <div class="form-group">
                                <label style="font-weight:900" for="formGroupExampleInput">Username</label>
                                <input type="text" class="rounded-lg px-4 py-2" name="username" placeholder="Username">
                            </div>

                            <div class="form-group">
                                <label style="font-weight:900" for="formGroupExampleInput2">Email</label>
                                <input type="email" name="email_admin" class="rounded-lg px-4 py-2" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label style="font-weight:900" for="formGroupExampleInput2">Contact</label>
                                <input type="number" name="contact_admin" class="rounded-lg px-4 py-2"
                                    placeholder="Contact">
                            </div>

                            <div class="form-group">
                                <label style="font-weight:900" for="formGroupExampleInput2">Password</label>
                                <input type="password" name="password" class="rounded-lg px-4 py-2"
                                    placeholder="Password">
                            </div>


                            <div class="form-group">
                                <label style="font-weight:900" for="formGroupExampleInput2">Role</label>
                                <input type="text" name="admin_role" class="rounded-lg px-4 py-2" placeholder="Role">
                            </div>
                        </div>


                        <div class="flex justify-center">
                            <div class="form-group">
                                <label style="font-weight:900" for="exampleFormControlFile1">Upload Profile</label>
                                <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">

                            </div>

                        </div>



                    </div>

                    <br>
                    <div class="flex justify-center">

                        <button class="btn buttonAddNew rounded-lg px-5 py-1" style="background: #dda15e; color:black"
                            name="addNew">Create</button>
                    </div>


                </form>

            </div>
        </div>
    </div>





</body>





</html>