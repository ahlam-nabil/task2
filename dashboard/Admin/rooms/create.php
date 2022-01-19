<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';


###############################################################
$sql = "select * from rooms_roles";
$op  = mysqli_query($con,$sql);
###############################################################
if($_SERVER['REQUEST_METHOD']== 'POST'){
    $room_number = Clean($_POST['room_num']);
    $desc = Clean($_POST['desc']);
    $room_price = Clean($_POST['price']);
    $room_role_id = $_POST['room_role_id'];

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
    if (!Validate($_FILES['image']['name'],1)) {
        $errors['Image'] = 'Field Required';
    }else{

         $ImgTempPath = $_FILES['image']['tmp_name'];
         $ImgName     = $_FILES['image']['name'];

         $extArray = explode('.',$ImgName);
         $ImageExtension = strtolower(end($extArray));

         if (!Validate($ImageExtension,7)) {
            $errors['Image'] = 'Invalid Extension';
         }else{
             $FinalName = time().rand().'.'.$ImageExtension;
         }

    }

    if(count($errors)>0){
        $message = $errors;
    }else{
        $disPath = './uploads/'.$FinalName;

        if(move_uploaded_file($ImgTempPath,$disPath)){
            $sql = "insert into rooms (number,room_role_id,img,discription,price) values ($room_number,$room_role_id,'$FinalName','$desc',$room_price)";
            $op = mysqli_query($con,$sql);
            if($op){
                $message=['message'=>'room added'];
            }else{
                $message = ['message'=>'error try again'];
            }
            
        }else{
            $message = ['message'=>'error in uploading image'];
        }
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
            <h2>Dashboard/add room</h2>

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

                <form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                    enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" name="room_num" id="room_num" class="form-control input-sm "
                            placeholder="room number">
                    </div>

                    <div class="form-group">
                        <textarea name="desc" id="desc" placeholder="room description"
                            class="form-control input-sm "></textarea>
                    </div>

                    <div class="form-group">
                        <input type="text" name="price" id="prive" class="form-control input-sm "
                            placeholder="room price">
                    </div>
                    <div class="form-group">
                        <select name="room_role_id" class="form-select form-control input-sm "
                            aria-label="Default select example">
                            <optgroup selected label="Room type">
                                <?php
                               while($data = mysqli_fetch_assoc($op)){
                            ?>

                                <option value="<?php echo $data['id'];?>"><?php echo $data['room_type'];?></option>

                                <?php }
                            ?>
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName">Image</label>
                        <input type="file" class="form-control input-sm" name="image">
                    </div>

                    <input type="submit" value="Add" class="btn btn-info btn-block w-100">

                </form>
            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>