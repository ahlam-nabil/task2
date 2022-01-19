<?php
    require '../helpers/dbConnection.php';
    require '../helpers/functions.php';


    $id = $_GET['id'];

    $sql = "select * from bookings where id = $id";
    $op = mysqli_query($con,$sql);

    if(mysqli_num_rows($op)==1){
        $sql = "delete from bookings where id= $id";
        $op = mysqli_query($con,$sql);
        if($op){
        $message = ["message "=>"the booking is removed"];
         }else{
            $message = ["message "=>"error try again"];
         }
    }else{
        $message = ["message "=>"invalid id"];
    }

    $_SESSION["message"] = $message;
    header("Location: index.php");

?>