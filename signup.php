<?php include('./connect.php');?>
<?php
$showError = false;
$showAlert = false;

if (isset($_POST['create_new_useraccount_form_submit'])) {
    if (isset($_POST['user_name'], $_POST['pass']) && trim($_POST['user_name']) !== '' && trim($_POST['pass'] !== '')) {

        $username = $_POST['user_name'];
        $password = $_POST['pass'];
        $cpassword = $_POST['conpass'];
        // $user_role = $_POST['user_role'];

        $exist_user = mysqli_query($conn, "SELECT * FROM `signup` WHERE `user_name` ='$username' LIMIT 1 ")
            or die(mysqli_error($conn));

        if ($row_user = mysqli_fetch_assoc($exist_user)) {
            $showError = "Username already exists";
        } else {
            if ($password == $cpassword) {
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `signup` (`user_name`, `password`) VALUES ('$username', '$hash_pass')";
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

if ($showAlert) {
    echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Account Registered Successfully. <a href="/sm-ims/signin.php" class="alert-link">Login Your Account</a>.
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
    <title>SignUp | SM-IMS</title>

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
                            <h3>Create an Account</h3>
                        </div>
                        <form method="POST" onkeyup="validation()" onsubmit="return validation()">
                            <!-- USERNAME -->
                            <div class="form-login">
                                <label>Full Name</label>
                                <div class="form-addons">
                                    <input type="text" name="user_name" placeholder="username" id="p_name" required>
                                    <!-- <img src="assets/img/icons/users1.svg" alt="img"> -->
                                    <span id="p_nameErr"></span>
                                </div>
                            </div>
                            <!-- password -->
                            <div class="form-login">
                                <label>Password</label>
                                <div class="form-addons">
                                    <input type="password" name="pass" id="pass" placeholder="Enter your password"
                                        autocomplete="off" min="10" max="11" required>
                                    <!-- <span class="fas toggle-password fa-eye-slash"></span> -->
                                    <span id="passErr"></span>
                                </div>
                            </div>
                            <!-- confirm password -->
                            <div class="form-login">
                                <label>Confirm Password</label>
                                <div class="pass-group">
                                    <input type="password" name="conpass" id="conpass"
                                        placeholder="Confirm your password" autocomplete="off">
                                    <!-- <span class="fas toggle-password fa-eye-slash"></span> -->
                                    <span id="conpassErr"></span>
                                </div>
                            </div>
                            <div class="form-login">
                                <input type="submit" class="btn btn-login" name="create_new_useraccount_form_submit"
                                    value="Register" class="submit-btn">
                            </div>
                        </form>
                        <div class="signinform text-center" >
                            <h4>Already a user? <a href="signin.php" class="hover-a">Sign In</a></h4>
                        </div>
                        <div class="form-setlogin" >
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
                    <img src="assets/img/login.jpg" alt="img">
                </div>
            </div>
        </div>
    </div>

    <script>
    function validation() {
        var p_name = document.getElementById("p_name").value;
        var pass = document.getElementById("pass").value;
        var conPass = document.getElementById("conpass").value;

        let isValid = true;

        isValid = validate_p_name(p_name) && isValid;
        isValid = validate_pass(pass) && isValid;
        isValid = validate_conPass(pass, conPass) && isValid;

        return isValid;
    }

    function validate_p_name(p_name) {
        var p_nameErr = document.getElementById("p_nameErr");
        if (p_name === "") {
            p_nameErr.innerHTML = "Please Enter Your Name";
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
            passErr.innerHTML = "Please Enter Your password";
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

    // REGEX for strong pwd
        // var strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        // if (!strongRegex.test(pass)) {
        //     passErr.innerHTML =
        //         "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character.";
        //     return false;
        // }
    </script>


    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/script.js"></script>
</body>

</html>