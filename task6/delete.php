<?php
    require('connectdb.php');
    $id = $_GET['id'];

    $sql = "select * from blog where id = $id";
    $op = mysqli_query($connect,$sql);
    $data = mysqli_fetch_assoc($op);
    unlink($data['picture']);
    if(mysqli_num_rows($op)==1){
        $sql = "delete from blog where id = $id";
        $op = mysqli_query($connect,$sql);
        if($op){
            $Message= "post deleted";
            header('Location: profile.php');
        }else{
            $Message= "error try again";
        }
    }else{
        $Message= "invalid id";
    }
    $_SESSION['Message'] = $Message;
?>