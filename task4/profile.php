
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile page</title>

    <style>
        body{
            background-color:#120B96;
        }
        h1{
            text-align:center;
            color:white;
        }
        .cont{
            width:50%;
            height:300px;
            background-color:white;
            border:1px solid black;
            margin:50px auto;
            display:flex;
            justify-content:space-around;
        }
        .info{
            margin-top:50px;
            margin-left:50px;
            width:500px;
           
        }
        .img{
            margin-top:50px;
            width:300px;
            
        }
        .lable{
            font-size:25px;
            font-weight:bold;
        }
        .details{
            font-size:20px;
        }
        .img img{
            width:200px;
            height:200px;
        }
    </style>
</head>
<body>
    <h1>Profile page</h1>
    <div class="cont">
        <div class="info">
            <?php
                session_start();
                echo '<span class="lable">Name: </span><span class="details">'.$_SESSION['name'] . '</span><br><br>';
                echo '<span class="lable">Email: </span><span class="details">'.$_SESSION['email'] . '</span><br><br>';
                echo '<span class="lable">Address: </span><span class="details">'.$_SESSION['address'] . '</span><br><br>';
                echo '<span class="lable">Linkedin Url: </span><span class="details">'.$_SESSION['url'] . '</span><br><br>';
            ?>
        </div>
        <div class="img">
            <?php
                
                echo '<img src='.$_SESSION['path'] .'>'
            ?>
        </div>
    </div>
</body>
</html>