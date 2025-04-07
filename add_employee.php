<?php include('assets/includes/header.php'); ?>
<?php include('./connect.php'); ?>

<?php
    $showError = false;
    $showAlert = false;
    //     if(isset($_POST['add_vendor'])){
    //     if(isset($_POST['code']) && ($_POST['name'])  && trim($_POST['code']) !=='' && trim($_POST['name']) !=='' ){
    //         $vendor_code = $_POST['code'];
    //         $endor_name = $_POST['name'];
    //         $exist_code = mysqli_query($conn, "SELECT * FROM vendor WHERE vendor_code ='$vendor_code' LIMIT 1 ")
    //         or die(mysqli_error($conn));
    //         if($row_code = mysqli_fetch_assoc($exist_code)) {
    //             echo 0;
    //         }else{
    //             $sql = "INSERT INTO `vendor` (`vendor_code`, `vendor_name`) VALUES ('$vendor_code','$endor_name')";

    //             $result = mysqli_query($conn, $sql);
    //         }            
    //     }
    // }

    // if (isset($_POST['register_new_deptt'])) {
    //     if (isset($_POST['user_name'], $_POST['pass'], $_POST['user_role']) && trim($_POST['user_name']) !== '' && trim($_POST['pass']) !== '' && trim($_POST['user_role']) !=='')  {
    
    //         $username = $_POST['user_name'];
    //         $password = $_POST['pass'];
    //         $cpassword = $_POST['conpass'];
    //         $user_role = $_POST['user_role'];
    //         // var_dump($dept_name);
    
    //         $exist_user = mysqli_query($conn, "SELECT * FROM `signup` WHERE `user_name` ='$username' LIMIT 1 ")
    //         or die(mysqli_error($conn));
    
    //         if ($row_user = mysqli_fetch_assoc($exist_user)) {
    //             $showError = "Department  already exists";
    //         } else {
    //             if ($password == $cpassword) {
    //                 $hash_pass = password_hash($password, PASSWORD_DEFAULT);
    //                 $sql = "INSERT INTO `signup` (`user_name`, `password`, `role_as`) VALUES ('$username', '$hash_pass','$user_role')";
    //                 $result = mysqli_query($conn, $sql);
    
    //                 if ($result) {
    //                     $showAlert = true;
    //                 } else {
    //                     $showError = "Error while creating account";
    //                 }
    //             } else {
    //                 $showError = "Passwords do not match";
    //             }
    //         }
    //     } else {
    //         $showError = "Username and Password fields cannot be empty!";
    //     }
    // }

    if (isset($_POST['register_new_deptt'])) {
        if (isset($_POST['user_name'], $_POST['pass'], $_POST['role_as']) && trim($_POST['user_name']) !== '' && trim($_POST['pass']) !== '' && trim($_POST['role_as']) !== '') {
    
            $username = $_POST['user_name'];
            $password = $_POST['pass'];
            $cpassword = $_POST['conpass'];
            $role_as = $_POST['role_as'];
            // $user_role = $_POST['user_role'];
            var_dump($username);
    
            $exist_user = mysqli_query($conn, "SELECT * FROM `signup` WHERE `user_name` ='$username' LIMIT 1 ")
                or die(mysqli_error($conn));
    
            if ($row_user = mysqli_fetch_assoc($exist_user)) {
                $showError = "Username already exists";
            } else {
                if ($password == $cpassword) {
                    $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO `signup` (`user_name`, `password`, `role_as`) VALUES ('$username', '$hash_pass','$role_as')";
                    $result = mysqli_query($conn, $sql);
    
                    if ($result) {
                        $showAlert = true;
                    } else {
                        $showError = "Error while creating account";
                    }
                } else {
                    $showError = "Passwords do not match";
                }
            }
        } else {
            $showError = "Username and Password fields cannot be empty!";
        }
    }

    
?>


<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Production Employee </h4>
                <h6>All Employees of Production Unit</h6>
            </div>

            <div class="page-btn">
                <!-- modal initializing button -->
                <button type="button" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#myModal"> <img
                        src="assets/img/icons/plus.svg" class="me-1" alt="img">
                    Add Department
                </button>
            </div>
        </div>

        <!-- modal start -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <div class="modal-title page-header">
                            <div class="page-title">
                                <h4>Add Department</h4>
                                <h6>New Department/Unit</h6>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                <!-- onsubmit="return validation()" -->
                                    <form method="POST" id="employee_form"
                                        style="display: flex; flex-wrap: wrap;" onsubmit="return validation()">
                                        <!-- USERNAME -->
                                        <div class="col-lg-6 col-sm-6 col-12">
                                            <label>Department Name</label>
                                            <div class="form-group">
                                                <input type="text" name="user_name" placeholder="Department Name"
                                                    id="d_name" required>
                                                <!-- <img src="assets/img/icons/users1.svg" alt="img"> -->
                                                <span id="d_nameErr"></span>
                                            </div>
                                        </div>
                                        <!-- password -->
                                        <div class="col-lg-6 col-sm-6 col-12">
                                            <label>Password</label>
                                            <div class="form-group mx-2">
                                                <input type="password" name="pass" id="pass"
                                                    placeholder="Enter your password" autocomplete="off" min="10"
                                                    max="11" required value="12345">
                                                <!-- <span class="fas toggle-password fa-eye-slash"></span> -->
                                                <span id="passErr" style="color:red;"></span>
                                            </div>
                                        </div>
                                        <!-- confirm password -->
                                        <div class="col-lg-6 col-sm-6 col-12">
                                            <label>Confirm Password</label>
                                            <div class="form-group mx-2">
                                                <input type="password" name="conpass" id="conpass"
                                                    placeholder="Confirm your password" autocomplete="off"
                                                    value="12345">
                                                <!-- <span class="fas toggle-password fa-eye-slash"></span> -->
                                                <span id="conpassErr" style="color:red;"></span>
                                            </div>
                                        </div>
                                        <!-- confirm password -->
                                        <div class="col-lg-6 col-sm-6 col-12">
                                            <label>Role As</label>
                                            <div class="form-group mx-2">
                                                <select id="role_as" name="role_as">
                                                    <option value="User" selected>User</option>
                                                    <option value="Admin">Admin</option>
                                                </select> 
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-12" style="margin-top: 1.6rem;">
                                            <input type="submit" class="btn btn-submit" name="register_new_deptt"
                                                value="Register" class="submit-btn" style="width: 100%; padding: 10px 10px;">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="success_message"></div>
                            <div id="error_message"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- modal end -->

        <!-- raw material categorywise detail list -->
        <div class="card">
            <div class="card-body">
                <?php
                if ($showAlert) {
                    echo '
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Department Registered Successfully.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                }

                if ($showError) {
                    echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> ' . $showError . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                }
                ?>

                <div class="table_responsive" id="add_employee">
                    <table id="myTable" class="table  datanew">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Date</th>
                                <th>Dept Name</th>
                                <th>User Rola</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                 $sql = "SELECT * FROM signup";
                                 $query_run = mysqli_query($conn, $sql);
                                 $total_rows = mysqli_num_rows($query_run);

                                 if($total_rows != 0){
                                    $number = 1;
                                    while($result = mysqli_fetch_assoc($query_run)){
                                        // var_dump($result);
                                        echo "
                                                <tr>
                                                    <td class='td_style'>".$number."</td>
                                                    <td class='td_style'>".$result['created_at']."</td>
                                                    <td class='td_style'>".$result['user_name']."</td>
                                                    <td class='td_style'>".$result['role_as']."</td>
                                                    <td>
                                                        <button type='button' class='btn btn-danger delete_btn' style='background:transparent; border:none;' value=".($result['id'])." ><img src='assets/img/icons/delete.svg' alt='img'></button>
                                                    </td>
                                                </tr>
                                            ";
                                        $number++;
                                    }
                                 }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
$(document).ready(function() {
            document.getElementById("employee_form").onsubmit = function(event) {
                let isValid = true;

                var d_name = document.getElementById("d_name").value;
                // var phoneNumber = document.getElementById("phone").value;
                var pass = document.getElementById("pass").value;
                var conPass = document.getElementById("conpass").value;

                isValid = validate_d_name(d_name) && isValid;
                // isValid = validatePhoneNumber(phoneNumber) && isValid;
                isValid = validate_pass(pass) && isValid;
                isValid = validate_conPass(pass, conPass) && isValid;

                if (!isValid) {
                    event.preventDefault(); // Stop form submission if validation fails
                }
            }

            function validate_d_name(d_name) {
                var d_nameErr = document.getElementById("d_nameErr");
                if (d_name.trim() === "") {
                    d_nameErr.innerHTML = "Please enter the Department Name";
                    return false;
                }
                if (!/^[a-zA-Z0-9 ]+$/.test(d_name)) {
                    d_nameErr.innerHTML = "Only letters & numbers allowed";
                    return false;
                }
                d_nameErr.innerHTML = "";
                return true;
            }

            // function validatePhoneNumber(phoneNumber) {
            //     const phoneRegex = /^0\d{10}$/;
            //     const phoneErr = document.getElementById("phoneErr");

            //     if (phoneRegex.test(phoneNumber)) {
            //         phoneErr.innerHTML = "";
            //         return true;
            //     } else {
            //         phoneErr.innerHTML = "Invalid phone number. Must start with 0 and be exactly 10 digits.";
            //         return false;
            //     }
            // }

            function validate_pass(pass) {
                var passErr = document.getElementById("passErr");
                if (pass.length < 5) {
                    passErr.innerHTML = "Password must be at least 5 characters.";
                    return false;
                }
                passErr.innerHTML = "";
                return true;
            }

            function validate_conPass(pass, conPass) {
                var conpassErr = document.getElementById("conpassErr");
                if (conPass !== pass) {
                    conpassErr.innerHTML = "Passwords do not match";
                    return false;
                }
                conpassErr.innerHTML = "";
                return true;
            }
            // $(document).ready(function() {   

                // var exit_emp_code = false;

                // $('#employee_form').submit(function(e) {
                //     var codeValue = $('#code').val().trim();
                //     var name = $('#name').val().trim();

                //     if (codeValue === '' || codeValue === '0' || name === '' || name === '0' ||
                //         exit_emp_code === true) {
                //         e.preventDefault(); // Prevent form submission
                //         $('#error_message').html('Fields cannot be empty / Already this code exist / 0')
                //             .slideDown();

                //     } else {
                //         // Form will submit if yard field is not empty
                //         $('#error_message').html('').slideUp(); // Clear any previous error message
                //     }
                // });


                // //ajax call on keyup to get already exist code of a employee
                // $("#code").keyup(function(e) {
                //     e.preventDefault();
                //     var code = $(this).val().trim();

                //     if (code != "") {
                //         $.ajax({
                //             url: "core.php",
                //             method: "POST",
                //             data: {
                //                 action: "fetch_employee_code",
                //                 search_code: code
                //             },
                //             success: function(data) {
                //                 if (data == 1) {
                //                     exit_emp_code = true;
                //                     $("#error_message").html("Employee Code Already Exist")
                //                         .slideDown();

                //                 } else {
                //                     exit_emp_code = false;
                //                     $("#error_message").slideUp();
                //                 }
                //             }
                //         });
                //     } else {
                //         $("#error_message").slideUp();
                //     }
                // });



                // delete employee from employee table through sweetalert ajax
                $('.table_responsive').on('click', '.delete_btn', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    // console.log(id);

                    swal({
                            title: "Are you sure?",
                            text: "Once deleted, you will not be able to recover!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {

                                $.ajax({
                                    method: "POST",
                                    url: "core.php",
                                    data: {
                                        action: "delete_dept",
                                        stitch_btn: id,
                                    },
                                    success: function(response) {
                                        if (response == 200) {
                                            swal("Success",
                                                "Record Deleted Successfully!",
                                                "success");
                                            // Destroy the DataTable instance
                                            // $('#myTable').DataTable().destroy();
                                            // Reload the content and reinitialize DataTable
                                            $("#add_employee").load(location.href +
                                                " #add_employee",
                                                function() {
                                                    $('#myTable').DataTable();
                                                });
                                        } else if (response == 500) {
                                            swal("Error!", "Record Not Deleted!",
                                                "error");
                                        }
                                    }
                                });
                            }
                        });
                });



                // Data Table load through .load funtion, if Previous & Next button for paginaiton doesn't appear use this load method and if shows warning that can't reintialize datatable, use it.   

                $("#add_employee").load(location.href + " #add_employee", function() {
                    $('#myTable').DataTable();
                });



            });
</script>

<?php include('assets/includes/footer.php'); ?>