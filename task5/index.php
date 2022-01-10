<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $title = $_POST['title'];
        $content = $_POST['content'];

        $errors = [];

        if(empty($title)){
            $errors['title']='this field is required';
        }elseif(!preg_match("/^[a-zA-Z-' ]*$/",$title)){
            $errors['title']='only letters an white spaces allowed';
        }

        if(empty($content)){
            $errors['content']='this field is required'; 
        }elseif(strlen($content)<50){
            $errors['content']='the lentgh must be greater than 50 chars';
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
            foreach ($errors as $key => $value) {
                echo '<h2>'. $key.' '.$value.'</h2>';
            }
        }else{
            $file = fopen('file.txt','a') or die('can not open this file');
            $postData = $title .':'. $content .'|'. $disPath ."\n";
            fwrite($file,$postData);
            fclose($file);
        }

        $fileread = fopen('file.txt' , 'r') or die('can not open this file');
        while (!feof($fileread)) {
            $post = fgets($fileread);
            $mark = strpos($post , ":");
            $mark2 = strpos($post , "|");
            $titletext = substr($post , 0,$mark);
            $contenttext = substr($post , $mark+1,$mark2);
            $imagetext = substr($post , $mark2+1 , -1);

            echo '<div class="post">';
            echo '<img src='. $imagetext . '><br>';
            echo '<h1>'.$titletext.'</h1>'.'<p>'. $contenttext . '</p>';
            echo '</div>';
        }
        fclose($fileread);



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
        h2{
            text-align:center;
            color:red;
        }
        form{
            width:40%;
            margin:50px auto;
            border:2px solid black;
            height:530px;
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
    </style>
</head>
<body>
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
            <label for="img">Upload Your Image</label>
            <input type="file" name="image" id="img">
        </fieldset>
        <fieldset>
            <input type="submit" value='post' id='sub'>
        </fieldset>
    </form>
</body>
</html>