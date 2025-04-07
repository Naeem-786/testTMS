<?php include('./connect.php'); ?>
<?php
session_start();
$showError = false;
$login = false;
// if(isset($_POST['login_useraccount_form_submit'])){
//     if(isset($_POST['user_name'], $_POST['pass']) && trim($_POST['user_name']) !=='' && $_POST['pass'] !== ''){

//         $username = $_POST['user_name'];
//         $password = $_POST['pass'];
//             // $sql = "SELECT * FROM 'signup' where userName = ' $username' AND password = '$password' ";
//             // $sql = "SELECT * FROM `signup` WHERE userName='$username' AND password='$password' ";
//             $sql = "SELECT * FROM `signup` WHERE user_name='$username'";

//             $result = mysqli_query($conn, $sql);
           
//             $rows = mysqli_num_rows($result);
//             // print_r($rows);
//             // die();
//             if($rows == 1){
//                 while($line=mysqli_fetch_assoc($result)){
//                     // var_dump($line);
//                     // die();
//                     if(password_verify($password, $line['password'])){
//                         $login = true;
//                         session_start();
//                         $_SESSION['loggedin'] = true;
//                         $_SESSION['user_name'] = $username;
//                       header("Location: index.php");
//                     }else{
//                         $showError = "No such User exists...";
//                     }
//                 }
//             }else{
//                 $showError = "No such User exists";
//             }
//     } else{
//         $showError =  "Password does not match ";
//     }
// }



// if(isset($_POST['login_useraccount_form_submit'])){
//     if(isset($_POST['user_name'], $_POST['pass']) && trim($_POST['user_name']) !=='' && $_POST['pass'] !== ''){

//         $username = $_POST['user_name'];
//         $password = $_POST['pass'];
//             // $sql = "SELECT * FROM 'signup' where userName = ' $username' AND password = '$password' ";
//             // $sql = "SELECT * FROM `signup` WHERE userName='$username' AND password='$password' ";
//             $sql = "SELECT * FROM `signup` WHERE user_name='$username'";

//             $result = mysqli_query($conn, $sql);
           
//             $rows = mysqli_num_rows($result);
//             // print_r($rows);
//             // die();
//             if($rows == 1){
//                 while($line=mysqli_fetch_assoc($result)){
//                     // var_dump($line);
//                     // die();
//                     foreach($result as $row){
//                         $user_id = $row['id'];
//                         $user_name = $row['user_name'];
//                     }
//                 }
//                     // if(password_verify($password, $line['password'])){
//                         // $login = true;
//                         // session_start();

//                         $_SESSION['auth'] = true;
//                         $_SESSION['auth_user'] = [
//                             'id' =>$user_id,
//                             'user_name' =>$user_name
//                         ];
//                         // $_SESSION['user_name'] = $username;
//                       header("Location: index.php");
//             }else{
//                 $showError = "No such User exists";
//             }
//         }else{
//             $showError = "No such User exists";
//         }
// }  


// session_start();  // Start session at the beginning of the file
// include 'db_connection.php'; // Make sure you have a valid database connection

// if (isset($_POST['login_useraccount_form_submit'])) {
//     if (!empty($_POST['user_name']) && !empty($_POST['pass'])) {
//         $username = trim($_POST['user_name']);
//         $password = trim($_POST['pass']);

//         // Use prepared statements to prevent SQL injection
//         $sql = "SELECT * FROM `signup` WHERE user_name = ?";
//         $stmt = mysqli_prepare($conn, $sql);
//         mysqli_stmt_bind_param($stmt, "s", $username);
//         mysqli_stmt_execute($stmt);
//         $result = mysqli_stmt_get_result($stmt);

//         if ($row = mysqli_fetch_assoc($result)) {
//             // Verify password (if stored as a hash)
//             if (password_verify($password, $row['password'])) {
//                 $_SESSION['auth'] = true;
//                 $_SESSION['auth_user'] = [
//                     'id' => $row['id'],
//                     'user_name' => $row['user_name']
//                 ];

//                 header("Location: index.php");
//                 exit(); // Ensure script execution stops after redirection
//             } else {
//                 $showError = "Invalid credentials!";
//             }
//         } else {
//             $showError = "No such user exists!";
//         }
//     } else {
//         $showError = "All fields are required!";
//     }
// }

if(isset($_POST['login_useraccount_form_submit'])){
    if(isset($_POST['user_name'], $_POST['pass']) && trim($_POST['user_name']) !=='' && $_POST['pass'] !== ''){

        $username = $_POST['user_name'];
        $password = $_POST['pass'];
            // $sql = "SELECT * FROM 'signup' where userName = ' $username' AND password = '$password' ";
            // $sql = "SELECT * FROM `signup` WHERE userName='$username' AND password='$password' ";
            $sql = "SELECT * FROM `signup` WHERE user_name='$username'";

            $result = mysqli_query($conn, $sql);
           
            $rows = mysqli_num_rows($result);
            // print_r($rows);
            // die();
            if($rows == 1){
                while($line=mysqli_fetch_assoc($result)){
                    // var_dump($line);
                    // die();
                    if(password_verify($password, $line['password'])){
                        $login = true;
                        session_start();
                        $_SESSION['loggedin'] = true;
                        $_SESSION['user_name'] = $username;
                      header("Location: index.php");
                    }else{
                        $showError = "No such User exists...";
                    }
                }
            }else{
                $showError = "No such User exists";
            }
    } else{
        $showError =  "Password does not match ";
    }
}





    // if($login){
    // echo '
    //     <div class="alert alert-success alert-dismissible fade show" role="alert">
    //     <strong>Success!</strong> Your are logged In Successfully.
    //     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //     </div>
    // ';
    // }
    
    if($showError){
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>'.$showError.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
        
    }
// if(isset($_POST['login_useraccount_form_submit'])) {
//     // Validate inputs
//     if(isset($_POST['user_name'], $_POST['pass']) && trim($_POST['user_name']) !== '' && $_POST['pass'] !== '') {
        
//         $username = trim($_POST['user_name']);
//         $password = $_POST['pass'];
        
//         // Use prepared statement to prevent SQL injection
//         $sql = "SELECT * FROM `signup` WHERE `user_name` = ? LIMIT 1";
//         $stmt = mysqli_prepare($conn, $sql);
//         mysqli_stmt_bind_param($stmt, "s", $username);
//         mysqli_stmt_execute($stmt);
//         $result = mysqli_stmt_get_result($stmt);
        
//         if(mysqli_num_rows($result) == 1) {
//             $user = mysqli_fetch_assoc($result);
            
//             // Verify password (assuming passwords are hashed in database)
//             if(password_verify($password, $user['password'])) {
//                 // Authentication successful
//                 $_SESSION['auth'] = true;
//                 $_SESSION['auth_user'] = [
//                     'id' => $user['id'],
//                     'user_name' => $user['user_name']
//                 ];
                
//                 header("Location: index.php");
//                 exit(); // Always exit after header redirect
//             } else {
//                 $showError = "Invalid password";
//             }
//         } else {
//             $showError = "No such user exists";
//         }
//     } else {
//         $showError = "Please fill all fields";
//     }
// }

// // Display error message if exists
// if(isset($showError) && $showError) {
//     echo '
//         <div class="alert alert-danger alert-dismissible fade show" role="alert">
//             <strong>Error!</strong> '.htmlspecialchars($showError).'
//             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//         </div>
//     ';
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Login | SM-IMS</title>

    <!-- <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpeg"> -->

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <!-- <div class="login-logo">
                            <img src="assets/img/logo.png" alt="img">
                        </div> -->
                        <div class="login-userheading">
                            <h3>Sign In</h3>
                            <h4>Please login to your account</h4>
                        </div>

                        <!-- form strat -->
                        <form method="POST" onkeyup="validation()" onsubmit="return validation()">

                            <!-- USERNAME -->
                            <div class="form-login">
                                <label>Department Name</label>
                                <div class="form-addons">
                                    <input type="text" name="user_name" placeholder="username" id="p_name" required>
                                    <!-- <img src="assets/img/icons/users1.svg" alt="img"> -->
                                    <span id="p_nameErr"></span>
                                </div>
                            </div>

                            <!-- password -->
                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input type="password" class="pass-input" name="pass" id="pass"
                                        placeholder="Enter your password" autocomplete="off" min="6" max="12" required>
                                    <!-- <span class="fas toggle-password fa-eye-slash"></span> -->
                                    <span id="passErr"></span>
                                </div>
                            </div>

                            <div class="form-login">
                                <div class="alreadyuser">
                                    <h4><a href="#" class="hover-a">Forgot Password?</a></h4>
                                </div>
                            </div>

                            <!-- SUBMIT BUTTON -->
                            <div class="form-login">
                                <input type="submit" class="btn btn-login" name="login_useraccount_form_submit"
                                    value="Login">
                            </div>
                        </form>
                        <!-- form end -->

                        <div class="signinform text-center">
                            <h4>Don’t have an account? <a href="signup.php" class="hover-a">Sign Up</a></h4>
                        </div>
                        <div class="form-setlogin">
                            <h4>Developed By</h4>
                        </div>
                        <div class="form-sociallink">
                            <ul>
                                <li style="width:100%;">
                                    <a href="www.google.com/maafstudio">
                                        <img src="assets/img/icons/google.png" class="me-2" alt="google">
                                        MAAF STUDIO
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="login-img">
                    <img src="assets/img/tailer.jpg" alt="img">
                </div>
                
            </div>
        </div>
    </div>


    <script>
    function validation() {
        var p_name = document.getElementById("p_name").value;
        var pass = document.getElementById("pass").value;

        let isValid = true;

        isValid = validate_p_name(p_name) && isValid;
        isValid = validate_pass(pass) && isValid;

        return isValid;
    }

    function validate_p_name(p_name) {
        var p_nameErr = document.getElementById("p_nameErr");
        if (p_name === "") {
            p_nameErr.innerHTML = "Please put yout name";
            return false;
        }


        if (!/^[a-zA-Z0-9 ]+$/.test(p_name)) {
            p_nameErr.innerHTML = "Only number & characters are allowed";
            return false;
        }
        p_nameErr.innerHTML = "";
        return true;
    }


    function validate_pass(pass) {
        var passErr = document.getElementById("passErr");
        if (pass === "") {
            passErr.innerHTML = "Please put your password";
            return false;
        }
        // validation for strong pwd
        // var strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        // if (!strongRegex.test(pass)) {
        //     passErr.innerHTML =
        //         "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character.";
        //     return false;
        // }
        passErr.innerHTML = "";
        return true;
    }
    </script>


    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/script.js"></script>
</body>

</html>