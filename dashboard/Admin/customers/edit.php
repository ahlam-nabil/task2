<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';

############################################################################# 
$id = $_GET['id'];

$sql = "select * from users where id =$id";
$op = mysqli_query($con,$sql);

if(mysqli_num_rows($op) == 1){
    // code ..... 
    $data = mysqli_fetch_assoc($op);
}else{
    $_SESSION['message'] = ["message" => "Invalid Id"];
    header("Location: index.php");
    exit();
}
############################################################################# 





# Code ..... 

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $is_active = $_POST['is_active'];

    $errors = [];

    #validations
    

    

    if(count($errors)>0){
        $message = $errors;
    }else{
       if (count($message)==0){
           $sql = "UPDATE `users` SET is_active = $is_active where id=$id" ;
           $op = mysqli_query($con,$sql);
           if($op){
               $message = ['message'=>'row updated'];
           }else{
               $message = ['message'=>'error try again '.mysqli_error($con)];
           }
       }

       $_SESSION['message']=$message;
       header('Location: index.php');
       exit();
}
$_SESSION['message'] = $message;


}



require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>



<main>
    <div class="container-fluid">
        <ol class="breadcrumb mb-4 mt-4">
            <h2>Dashboard/activation update</h2>

            <?php 
                echo '<br><br>';
                if(isset($_SESSION['message'])){
                    Messages($_SESSION['message']);
                
                    # Unset Session ... 
                    unset($_SESSION['message']);
                }
            
            ?>

        </ol>


        <div class="card mb-4">

            <div class="card-body w-50 m-auto">

                <form role="form" action="edit.php?id=<?php echo $data['id']; ?>" method="post">
                    <div class="form-group">
                        <select name="is_active" class="form-select form-control input-sm "
                            aria-label="Default select example">
                            <optgroup  label="activation">
                                <option value="0" <?php echo $data['is_active'] == '1' ?  "selected" : " " ;?>>not active</option>
                                <option value="1" <?php echo $data['is_active'] == '1' ?  "selected" : " " ;?>>active</option>
                            </optgroup>
                        </select>
                    </div>

                    <input type="submit" value="Update" class="btn btn-info btn-block w-100">

                </form>
            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>