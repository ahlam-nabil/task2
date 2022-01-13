<?php
    require('connectdb.php');
    $sql = "select * from blog";
    $objdata = mysqli_query($connect,$sql); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <style>
        .post{
            width:50%;
            margin:50px auto;
            min-height:300px;
            display:flex;
            justify-content:space-around;
            border:1px solid black;
            border-radius:20px;
        }
        .info,.img{
            width:300px;
            min-height:300px;  
        }
        h2{
            line-height: 7px;
            text-align:center;
        }
        span{
            font-size:12px;
            line-height:5px;
            display:block;
            text-align:center;
            color:gray;
        }
        p{
            text-align:justify;
            font-size:18px;
            line-height:25px
        }
        img{
            width:100%;
            height:200px;
            border-radius:20px;
            box-shadow:0px 0px 15px black;
            margin-top:20px;
        }
        .img .button a{
            text-decoration:none;
            display:inline-block;
            width:100px;
            height:30px;
            text-align:center;
            margin-top:10px;
            line-height:30px;
            color:white;
            font-size:20px;
            font-weight:bold;
            border-radius:20px;
        }
        .img .button a:first-of-type{
            background-color:green;
            margin-left:40px
        }
        .img .button a:last-of-type{
            background-color:red;
            margin-left:20px
        }
        #cp{
            display:block;
            width:15%;
            height:30px;
            line-height:30px;
            text-align:center;
            margin:auto;
            text-decoration:none;
            background-color:blue;
            color:white;
            font-size:20px;
            font-weight:bold;
            border-radius:20px;
        }
    </style>
</head>
<body>
<a id="cp" href="index.php">Create New Post</a>

    <?php
        while($data = mysqli_fetch_assoc($objdata)){
           
            if(isset($_SESSION['Message'])){
                echo $_SESSION['Message'];
                unset($_SESSION['Message']);
            }
    ?>
    <div class="post">
        <div class="info">
            <h2><?php echo $data['title'] ?></h2>
            <span><?php echo $data['date'] ?></span><br>
            <p><?php echo $data['content'] ?></p>
        </div>
        <div class="img">
            <div class="button">
                <a href="update.php?id=<?php echo $data['id']?>">Update</a>
                <a href="delete.php?id=<?php echo $data['id']?>">Delete</a>
            </div>
            <img src="<?php echo $data['picture'] ?>">
        </div>
    </div>
    <?php
            }
    ?>
</body>
</html>