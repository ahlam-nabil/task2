<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $url = $_POST['url'];
        $chr = '@';

        $errors=[];
        if(empty($name)){
            $errors['name']="please fill this field";
        }elseif(is_numeric($name)){
            $errors['name']="this is not a string, please fill this field with a string";
        }

        if(empty($email)){
            $errors['email']="please fill this field";
         }//elseif(strpos($email, $chr) == false){
        //     $errors['email']="this is not an email, please write correct email";
        // }

        
        if(empty($password)){
            $errors['password']="please fill this field";
         }elseif(strlen($password)<6){
             $errors['password']="the length must be >= 6";
         }

         if(empty($address)){
            $errors['address']="please fill this field";
         }elseif(strlen($address) != 10){
             $errors['address']="the length must be = 10";
         }

         if(empty($url)){
            $errors['linkid in url']="please fill this field";
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
        form{
            width:40%;
            margin:50px auto;
            border:2px solid black;
            height:500px;
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
    </style>
</head>
<body>
    <h1>Registration Form</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <fieldset>
            <label for="name">Name</label>
            <input type="text" id="name" name="name">
        </fieldset>
        <fieldset>
            <label for="em">Email</label>
            <input type="email" id="em" name="email" placeholder="example@gmail.com">
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
            <input type="url" id="url" name="url">
        </fieldset>
        <fieldset>
            <input type="submit" id="sub">
        </fieldset>
    </form>
</body>
</html>