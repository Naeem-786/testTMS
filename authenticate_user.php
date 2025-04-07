<?php
    session_start();
    if(!isset($_SESSION['auth'])){
        $_SESSION['auth_status'] = 'Successfully login as User Dashboard';
        header("Location: SM-TMS/index.php");
        exit(0);
    }else{
        if($_SERVER['auth'] == "1"){

        }else{
        $_SESSION['status'] = 'You are not Authorized';

            header("Location: SM-TMS/index.php");
            exit(0);
        }
    }
?>