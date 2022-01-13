<?php
    require('connectdb.php');
    require('helpers.php');


    if($_SERVER['REQUEST_METHOD']=='POST'){
        $title = clean($_POST['title']);
        $content = clean($_POST['content']);
        $date = $_POST['date'];

        $errors = [];

        // validate title
        if(!Validate($title,1)){
            $errors['title'] = 'field required';
        }elseif(!Validate($title,2)){
            $errors['title'] = 'only letters an white spaces allowed';
        }

        // validate content
        if(!Validate($content,1)){
            $errors['content'] = 'field required';
        }elseif (!Validate($content,3)) {
            $errors['content'] = 'length must be greater than 50';
        }

        if(!Validate($date,1)){
            $errors['date'] = 'field required';
        }

        // upload image
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
                    }else{
                     $errors['image']= 'Error Try Again';
                 }
         
                }else{
                    $errors['image']= 'Extension Not Allowed';
                }
         
         
            }else{
                $errors['image']= 'Image Field Required';
            }

            if(count($errors)>0){
                // print errors
                Errors($errors);
             }else{
                $sql = "INSERT INTO `blog`(`title`, `content`, `date`, `picture`) VALUES
                 ('$title','$content','$date','$disPath')";
                $op = mysqli_query($connect,$sql);
                if ($op) {
                    $Message = 'Raw Inserted';
                } else {
                    $Message = 'Error try Again : ' . mysqli_error($connect);
                }
                $_SESSION['Message'] = $Message;
             }
            
            
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Module</title>
    <style>
        .post{
            width:50%;
            height:400px;
            margin:auto;
            text-align:center;
        }
        .post img{
            width:100%;
            height:200px;
        }
        h1{
            text-align:center;
        }
        h2{
            text-align:center;
            color:red;
        }
        form{
            width:40%;
            margin:auto;
            border:2px solid black;
            min-height:500px;
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
            width:70%;
            height:40px;
            font-size:20px;
            font-weight:bold;
            text-align:center;
        }
        textarea{
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
    </style>
</head>
<body>
    <h1>Create Post</h1>

        <?php
            if(isset($_SESSION['Message'])){
                echo $_SESSION['Message'];
                unset($_SESSION['Message']);
            }
        ?>

    <h3><a href="profile.php">Go To Profile</a></h3>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"  enctype="multipart/form-data">
        <fieldset>
            <label for="title">Title</label>
            <input type="text" name='title' id='title'>
        </fieldset>
        <fieldset>
            <label for="content">Content</label>
            <textarea name="content" id="content" cols="30" rows="10"></textarea>
        </fieldset>
        <fieldset>
            <label for="date">Date</label>
            <input type="date" name="date" id="date">
        </fieldset>
        <fieldset>
            <label for="img">Upload Your Image</label>
            <input type="file" name="image" id="img">
        </fieldset>
        <fieldset>
            <input type="submit" value='post' id='sub'>
        </fieldset>
    </form>
</body>
</html>