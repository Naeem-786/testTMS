<?php
include('./connect.php');

$id = $_GET['id'];
// var_dump($id);
// die();

$sql = " DELETE FROM product_cat WHERE id = '$id' ";
$result = mysqli_query($conn, $sql);

if($result){
    // echo "Record deleted";
    
    header("Location:addproductcode.php");
}else{
    echo "Record Not deleted";
}

?>