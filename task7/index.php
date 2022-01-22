<?php
    require('blog.php');

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $title = $_POST['title'];
        $content = $_POST['content'];
        

        $blog = new blog();
        $blog->blogtest($title,$content);
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
        if (isset($_SESSION['message'])) {
            foreach ($_SESSION['message'] as $key => $value) {
                echo $value . '<br>';
            }
            unset($_SESSION['message']);
        }
        ?>

   
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