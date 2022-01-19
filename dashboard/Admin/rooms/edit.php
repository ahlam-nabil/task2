<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';

############################################################################# 
$id = $_GET['id'];

$sql = "select rooms.*,images.* from rooms inner join images on rooms.image_id = images.id where rooms.id =$id;";
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

//rooms-roles
$sql = "select * from rooms_roles";
$op = mysqli_query($con,$sql);




# Code ..... 

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $room_number = Clean($_POST['room_num']);
    $desc = Clean($_POST['desc']);
    $room_price = Clean($_POST['price']);
    $room_role_id = $_POST['room_role_id'];
    $is_available = $_POST['is_available'];

    $errors = [];

    #validations

    if (!Validate($room_number, 1)) {
        $errors['room number'] = 'Required Field';
    } elseif (!Validate($room_number, 3)) {
        $errors['room number'] = 'Invalid number';
    }

    if (!Validate($desc, 1)) {
        $errors['description'] = 'Required Field';
    } elseif (!Validate($desc, 5)) {
        $errors['description'] = 'Invalid String';
    }elseif (!Validate($desc,2)) {
        $errors['description'] = 'length must be >= 6';
    }

    if (!Validate($room_price, 1)) {
        $errors['room price'] = 'Required Field';
    } elseif (!Validate($room_price, 3)) {
        $errors['room price'] = 'Invalid number';
    }

    if (!Validate($room_role_id,1)) {
        $errors['room type'] = 'Field Required';
    }elseif(!Validate($room_role_id,3)){
        $errors['room type'] = "Invalid Id";
    }
    

    # Validate Image
    if (Validate($_FILES['image']['name'],1)) {
        $ImgTempPath = $_FILES['image']['tmp_name'];
        $ImgName = $_FILES['image']['name'];

        $extArray = explode('.', $ImgName);
        $ImageExtension = strtolower(end($extArray));

        if (!Validate($ImageExtension, 7)) {
            $errors['Image'] = 'Invalid Extension';
        } else {
            $FinalName = time() . rand() . '.' . $ImageExtension;
        }

    }

    if(count($errors)>0){
        $message = $errors;
    }else{
       if (Validate($_FILES['image']['name'],1)){
           $disPath = '../images/uploads/'.$FinalName;

           if(!move_uploaded_file($ImgTempPath,$disPath)){
               $message = ['message'=> 'error in uploading image try again'];
           }else{
               unlink('../images/uploads/'.$data['name']);
           }
       }else{
           $FinalName = $data['name'];
       }


       if (count($message)==0){
           $sql = "UPDATE `rooms` SET `number`=$room_number,`room_role_id`=$room_role_id,`image_id`='$FinalName',discription='$desc',is_available=$is_available,price=$room_price where id= $id";
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
            <h2>Dashboard/update room</h2>

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

                <form role="form" action="edit.php?id=<?php echo $data['id']; ?>" method="post"
                    enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" name="room_num" id="room_num" class="form-control input-sm "
                            placeholder="room number" value="<?php echo $data['number']; ?>">
                    </div>

                    <div class="form-group">
                        <textarea name="desc" id="desc" placeholder="room description"
                            class="form-control input-sm "><?php echo $data['discription']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <input type="text" name="price" id="price" class="form-control input-sm "
                            placeholder="room price" value="<?php echo $data['price']; ?>">
                    </div>


                    <div class="form-group">
                        <select name="room_role_id" class="form-select form-control input-sm "
                            aria-label="Default select example">
                            <optgroup  label="Room type">
                                <?php
                                   while($roledata = mysqli_fetch_assoc($op)){
                            ?>

                                <option value="<?php echo $roledata['id']; ?>" <?php if($roledata['id'] == $data['room_role_id']){
                                        echo "selected";
                                        } 
                                        ?>>
                                    <?php echo $roledata['room_type']; ?>
                                </option>

                                <?php }
                            ?>
                            </optgroup>
                        </select>
                    </div>


                    <div class="form-group">
                        <select name="is_available" id="is_available" class="form-select form-control input-sm "
                            aria-label="Default select example">
                            <optgroup label="availability">
                                <option value="0" <?php echo $data['is_available'] == '1' ?  "selected" : " " ;?>>unavailable</option>
                                <option value="1"<?php echo $data['is_available'] == '1' ?  "selected" : " " ;?>>available</option>
                            </optgroup>
                        </select>
                    </div>



                    
                    <div class="form-group">
                        <label for="exampleInputName">Image</label>
                        <img src="../images/uploads/<?php echo $data['name']; ?>"  height="100px" width="150px">
                        <input type="file" class="form-control input-sm mt-3" name="image">
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