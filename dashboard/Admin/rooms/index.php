<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
################################################################
# Fetch Roes Data .......
$sql = 'select rooms.* ,rooms_roles.room_type,images.name from rooms inner join rooms_roles on rooms.room_role_id = rooms_roles.id inner join images on rooms.image_id = images.id';
$op = mysqli_query($con, $sql);
################################################################

require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>



<main>
    <div class="container-fluid">
    <ol class="breadcrumb mb-4 mt-4">
        <h2>Dashboard/rooms display</h2>
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

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>room number</th>
                                <th>room type</th>
                                <th>room description</th>
                                <th>room price</th>
                                <th>room image</th>
                                <th>room availability</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                                        # Fetch Data ...... 
                                        while($data = mysqli_fetch_assoc($op)){
                                      
                                    ?>

                            <tr>
                                <td><?php echo $data['id']; ?></td>
                                <td><?php echo $data['number']; ?></td>
                                <td><?php echo $data['room_type']; ?></td>
                                <td><?php echo $data['discription']; ?></td>
                                <td><?php echo $data['price']; ?></td>
                                <td><img src="../images/uploads/<?php echo $data['name']; ?>" height="60px" width="100px"></td>
                                <td><?php if( $data['is_available']==1){
                                    echo "available";
                                }elseif ( $data['is_available']==0) {
                                    echo " unavailable";
                                } ?></td>

                                <td>
                                    <a href='edit.php?id=<?php echo $data['id']; ?>' class='btn btn-primary m-r-1em'>Edit</a>
                                </td>

                            </tr>

                            <?php 
                                        }
                                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>
