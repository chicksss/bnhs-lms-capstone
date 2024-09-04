<div class="card-body" style="max-height: 490px; overflow-y: auto; text-align:left">
                    <button id="openModalBtn" class="btn" style="background: #dda15e; ">Add new
                    </button>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Fullname</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   
                        $users = $crud->adminList();
                      
                        foreach ($users as $user){ ?>
                            <tr>
                                <td><?php echo $user['admin_Id']; ?></td>
                                <td><?php echo $user['fullname_admin']; ?></td>
                                <td><?php echo $user['admin_role']; ?></td>
                                <td><button class="btn" style="background: #dda15e; "> <a class="a"
                                            href="../ADMIN_LOGIN/admin_validation.php?id=<?php echo $user['admin_Id'];?>"
                                            style="color:black"><i class="bi bi-pen-fill"></i></a>
                                    </button>




                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>



                <div id="modal" class="modal">
            <br> <br> <br> <br>
            <div class="modal-content" style=" width: 70%;">
                <span class="close" id="closeModalBtn">&times;</span>


                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col">

                            <div class="form-group">
                                <label style="font-weight:900" for="formGroupExampleInput">Name</label>
                                <input type="text" class="form-control" name="fullname_admin" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label style="font-weight:900" for="formGroupExampleInput2">Address</label>
                                <input type="text" name="address_admin" class="form-control" placeholder="Address">
                            </div>
                            <div class="form-group">
                                <label style="font-weight:900" for="formGroupExampleInput">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Username">
                            </div>


                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label style="font-weight:900" for="formGroupExampleInput2">Email</label>
                                <input type="email" name="email_admin" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label style="font-weight:900" for="formGroupExampleInput2">Contact</label>
                                <input type="number" name="contact_admin" class="form-control" placeholder="Contact">
                            </div>

                            <div class="form-group">
                                <label style="font-weight:900" for="formGroupExampleInput2">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>

                            <div class="form-group">
                                <label style="font-weight:900" for="formGroupExampleInput2">Role</label>
                                <input type="text" name="admin_role" class="form-control" placeholder="Role">
                            </div>


                        </div>
                        <br>

                        <div class="col">
                            <div class="form-group">
                                <label style="font-weight:900" for="exampleFormControlFile1">Upload Profile</label>
                                <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">

                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn buttonAddNew" style="background: #dda15e; color:black"
                                name="addNew">Create</button>
                        </div>

                    </div>
                </form>


            </div>
        </div>
