<?php

    // Database server credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    // $dbname = "pdatabase";
    $dbname = "ims";

    // create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    

    // check connection
    if(!$conn){
        die("Connection failed: ". msqli_connect_error());
    }else{  
        // echo "connection successful <br>";
}


?>