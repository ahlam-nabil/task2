<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
################################################################
# Fetch Roes Data .......
$sql = 'SELECT * FROM `users` ;';
$op = mysqli_query($con, $sql);
################################################################

require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>



<main>
    <div class="container-fluid">
    <ol class="breadcrumb mb-4 mt-4">
        <h2>Dashboard/delete user</h2>
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
                                <th>client name</th>
                                <th>client email</th>
                                <th>client phone</th>
                                <th>client gender</th>
                                <th>is activity</th>
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
                                <td><?php echo $data['name']; ?></td>
                                <td><?php echo $data['email']; ?></td>
                                <td><?php echo $data['phone']; ?></td>
                                <td><?php echo $data['gender']; ?></td>
                                <td><?php if( $data['is_active']==1){
                                    echo "<span style='color:green;'>active</span>";
                                }elseif ( $data['is_active']==0) {
                                    echo " <span style='color:red;'>not active</span>";
                                } ?></td>

                                        <td>
                                          <a href='delete.php?id=<?php echo $data['id']; ?>' class='btn btn-danger m-r-1em'>Delete</a>
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
