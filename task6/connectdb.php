<?php
    session_start();
    $server     = "localhost";
    $dbname     = "nti_course";
    $dbuser     = "root";
    $dbpassword = "";
    $connect =  new mysqli($server ,  $dbuser , $dbpassword , $dbname);
    
    if($connect){
         'database connected successfully';
    }else{
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
?>
