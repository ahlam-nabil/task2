<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';



###############################################################################
if($_SERVER['REQUEST_METHOD']== 'POST'){
    $img_type = $_POST['img_type'];

    $errors = [];

    #validations

    

    if (!Validate($img_type, 1)) {
        $errors['image type'] = 'Required Field';
    } elseif (!Validate($img_type, 5)) {
        $errors['image type'] = 'Invalid String';
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
            $sql = "insert into images (name,type) values ('$FinalName','$img_type')";
            $op = mysqli_query($con,$sql);
            if($op){
                $message=['message'=>'image added'];
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
            <h2>Dashboard/add image</h2>

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
                        <label for="exampleInputName">Image</label>
                        <input type="file" class="form-control input-sm" name="image">
                    </div>

                    <div class="form-group">
                        <input type="text" name="img_type" id="type" class="form-control input-sm "
                            placeholder="image type">
                    </div>
                    <input type="submit" value="Add Image" class="btn btn-info btn-block w-100">

                </form>
            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>