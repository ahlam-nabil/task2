<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
################################################################
$sql = 'SELECT bookings.* , users.name , rooms.number from bookings INNER JOIN users ON bookings.client_id = users.id INNER JOIN rooms on bookings.room_id = rooms.id';
$op = mysqli_query($con,$sql);
###############################################################

require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>



<main>
    <div class="container-fluid">
        <ol class="breadcrumb mb-4 mt-4">
        <h2>Dashboard/remove booking</h2>
            <?php 
            echo '<br><br>';
           if(isset($_SESSION['message'])){
             messages($_SESSION['message']);
          
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
                            <th>room number</th>
                            <th>start date</th>
                            <th>end date</th>
                            <th>total price</th>
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
                                      <td><?php echo $data['number']; ?></td>
                                      <td><?php echo $data['start_date']; ?></td>
                                      <td><?php echo $data['end_date']; ?></td>
                                      <td><?php echo $data['total_price']; ?></td>
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
