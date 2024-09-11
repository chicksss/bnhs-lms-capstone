<?php

require_once "admin_login_engine.php";
require_once "admin_login_db.php";
$crud = new CRUDADMIN();

session_start();
  include "../dashdesign.php";

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
            <h1 class="text-2xl font-bold px-3">PROFILE</h1>
        </div>

        <div class="main-container">

       


            <?php        
                   
                if (isset($_SESSION['admin_Id'])) {
                $admin_Id = $_SESSION['admin_Id'];

               
                $user = $crud->adminProfile($admin_Id);

                ?>
            <?php
            $password = $user['password'];
            $maskedPassword = str_repeat('*', strlen($password));
            if ($user) {  ?>



            <section>
                <div class="px-10">
                    <div class="flex justify-start gap-20 py-20">
                        <div class="">
                            <div class="card mb-4">
                                <div class="grid justify-center text-center">
                                    <img class="w-[300px]" src="../admin_profiles/<?php echo $user['image']; ?>"
                                        title="<?php echo $user['image']; ?>">
                                    <h5 class="my-3"><?php echo $user['fullname_admin']; ?></h5>


                                </div>
                            </div>

                        </div>
                        <div class="flex justify-bertween gap-20">
                            <div>
                                <div class="">
                                    <div class="py-3">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Full Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $user['fullname_admin']; ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="py-3">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Email</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $user['email_admin']; ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="py-3">
                                        <?php if (isset($_SESSION['admin_Id'])): ?>
                                        <button class="bg-[#d5bdaf] px-6 py-2 rounded-lg">
                                            <a href="admin_update.php?<?php echo $_SESSION['admin_Id']; ?>">Update</a>
                                        </button>
                                        <?php endif; ?>

                                         
                                        <button onclick="goBack()" class="btn-back bg-[#d5bdaf] p-2 rounded-lg px-10">Back</button>
                                            <script>
                                            function goBack() {
                                                window.history.back();
                                            }
                                    </script>
        
                                    </div>


                                </div>
                            </div>

                            <div>
                                <div class="">

                                    <div class="py-3">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Phone</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"> <?php echo $user['contact_admin']; ?></p>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="py-3">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Address</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php echo $user['address_admin']; ?></p>
                                        </div>
                                    </div>
                                    <hr>



                                </div>


                            </div>

                        </div>
                        <div>



                            <div class="py-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">Role</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"> <?php echo $user['admin_role']; ?></p>
                                </div>
                            </div>

                            <div class="py-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">Password</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"> <?php echo $maskedPassword; ?></p>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </section>







            <?php }?>

            <?php   } ?>



        </div>


    </div>

</body>

</html>