<?php
    session_start();
    function clean($input){
        $input = strip_tags($input);
        $input = trim($input);
        $input =  stripslashes($input);
        return $input;
    }
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $name =clean( $_POST['name']);
        $email = clean($_POST['email']);
        $password = clean($_POST['password']);
        $address = clean($_POST['address']);
        $url = clean($_POST['url']);

        $errors=[];
        $imgsucces =" ";


        if(empty($name)){
            $errors['name']='please fill this filled';
        }elseif(!preg_match("/^[a-zA-Z-' ]*$/",$name)){
            $errors['name']='only letters an white spaces allowed';
        }else{
            $_SESSION['name']=$name;
        }

        if(empty($email)){
            $errors['email']='please fill this field';
        }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errors['email']='inavlid email';
        }else{
            $_SESSION['email']=$email;
        }

        if(empty($password)){
            $errors['password']='please fill this field';
        }elseif(strlen($password)<6){
            $errors['password']='length must be >= 6';
        }else{
            $_SESSION['password']=$password;
        }

        if(empty($address)){
            $errors['address']='please fill this field';
        }elseif(strlen($address) < 10){
            $errors['address']='length must be >10';
        }else{
            $_SESSION['address']=$address;
        }

        if(empty($url)){
            $errors['linkidin url']='please fill this field';
        }elseif(!filter_var($url,FILTER_VALIDATE_URL)){
            $errors['linkidin url']='inavlid url';
        }elseif(strpos($url,'https://www.linkedin.com')===false){
            $errors['linkidin url']='this is not a linkedin url, please write the correct linkedin url';
         }else{
            $_SESSION['url']=$url;
        }

         if(!empty($_FILES['image']['name'])){

            $imgName     = $_FILES['image']['name'];
            $imgTempPath = $_FILES['image']['tmp_name'];
            $imagSize    = $_FILES['image']['size'];
            $imgType     = $_FILES['image']['type'];
         
         
             $imgExtensionDetails = explode('.',$imgName);
             $imgExtension        = strtolower(end($imgExtensionDetails));
         
             $allowedExtensions   = ['png','jpg','gif'];
         
                if(in_array($imgExtension ,$allowedExtensions)){
                   
         
                 $finalName = rand().time().'.'.$imgExtension;
         
                  $disPath = './uploads/'.$finalName;
         
                 if(move_uploaded_file($imgTempPath,$disPath)){
                     echo '<p style="color:#25CB12; font-size=20px; font-weight:bold; text-align:center;">Image Uploaded</p>';
                     $_SESSION['path']= $disPath;
                 }else{
                     $errors['image']= 'Error Try Again';
                 }
         
                }else{
                    $errors['image']= 'Extension Not Allowed';
                }
         
         
            }else{
                $errors['image']= 'Image Field Required';
            }
            


            foreach($errors as $key=>$value){
                echo '<h2>'. $key.'==>'.$value.'</h2>';
            }
         }
         
         



    


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>form validation</title>
    <style>
        body{
            background-color:#120B96;
        }
        h1{
            text-align:center;
            color:white;
        }
        h2{
            text-align:center;
            color:red;
        }
        p{
            color:white;
            font-size:20px
        }
        #suc{
            color:#01EA0D;
        }
        form{
            width:40%;
            margin:50px auto;
            border:2px solid black;
            height:580px;
            background-color:white;
            border-radius:20px;
        }
        fieldset{
            border:0;
            display:flex;
            justify-content:space-around;
            margin-top:20px
        }
        label{
            font-size:20px;
            font-weight:bold;
            width:30%;
            text-align:center;
        }
        input{
            width:60%;
            height:40px;
            font-size:20px;
            font-weight:bold;
            text-align:center;
        }
        #sub{
            width:100%;
            height:50px;
            font-size:25px;
            font-weight:bold;
            background-color:green;
            color:white;
            border-radius:15px;
            cursor: pointer;
        }
        h3{
            text-align:center;
        }
        h3 a{
            text-decoration:none;
            color:white;
        }
        h3 a:hover{
            color:red;
        }
    </style>
</head>
<body>
    <h1>Registration Form</h1>
    <h3><a href="profile.php">Go To Profile Page</a></h3>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"  enctype="multipart/form-data">
        <fieldset>
            <label for="name">Name</label>
            <input type="text" id="name" name="name">
        </fieldset>
        <fieldset>
            <label for="em">Email</label>
            <input type="text" id="em" name="email" placeholder="example@gmail.com">
        </fieldset>
        <fieldset>
            <label for="ps">Password</label>
            <input type="password" id="ps" name="password">
        </fieldset>
        <fieldset>
            <label for="ad">Address</label>
            <input type="text" id="ad" name="address">
        </fieldset>
        <fieldset>
            <label for="url">Linkdin Url</label>
            <input type="text" id="url" name="url">
        </fieldset>
        <fieldset>
            <label for="img">Upload Your Image</label>
            <input type="file" name="image" id="img">
        </fieldset>
        <fieldset>
            <input type="submit" id="sub">
        </fieldset>
    </form>
</body>
</html>