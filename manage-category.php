<?php
		session_start();
		if(!isset($_SESSION['store_id'])) {
			header("location:login.php");
			exit();
		}else{
			include('config/db.php');
		}
	?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pharmacy</title>

	<!-- Data Table CSS -->
	<?php include("part/data-table-css.php");?>
	<!-- Data Table CSS end -->
	
	<!-- All CSS -->
	<?php include("part/all-css.php");?>
	<!-- All CSS end -->

  </head>
  <body class="hold-transition sidebar-mini">
    <div class="wrapper">
	  <!-- Navbar -->
    <?php include("part/navbar.php");?>
      <!-- Navbar end -->

      <!-- Sidebar -->
      <?php include("part/sidebar.php");?>
      <!--  Sidebar end -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Category</h3>
                  </div>
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover">
                      <thead>
                        <tr class="bg-info">
                          <th class="col-2">SL</th>
                          <th class="col-3">Image</th>
                          <th class="col-4">Name</th>
                          <th class="col-3">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $n = 0;
                          $sql = $conn->query("SELECT * FROM `p_medicine_category` WHERE `store` = '$_SESSION[store_id]'");
                          while($row = mysqli_fetch_assoc($sql)){
                        ?>
                        <tr>
                          <td><?php echo ++$n; ?></td>
                          <td><img src="dist/img/medicine-category/<?php echo $row['img'] ?>" alt="" style="width: 50px;"></td>
                          <td class="text-capitalize"><?php echo $row['name'] ?></td>
                          <td>
                            <div class="btn-group">
                              <button class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-cogs"></i>
                                Manage
                                </button>
                              <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 36px; left: 0px; will-change: top, left;">
                                <a class="dropdown-item text-success" href="#" data-toggle="modal" data-target="#edit<?php echo $row['id']; ?>"> <i class="fa fa-edit"></i> Edit </a>
                                <a class="dropdown-item text-danger delete" href="actions/remove.php?removeCategory=<?php echo $row['id']; ?>"> <i class="fa fa-trash"></i> Delete </a>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <!-- Edit Modal -->
                        <div class="modal fade" id="edit<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form action="actions/addMedicineOptions.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label for="name">Category Name</label>
                                    <input type="text" class="form-control" id="medi_cat" placeholder="Enter Category Name" name="medicineCategory" value="<?php echo $row['name']; ?>">
                                    <input type="hidden" name="catid" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="img" value="<?php echo $row['img']; ?>">
                                  </div>
                                  <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" class="form-control" name="uploadfile">
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" name="updateCategory" class="btn btn-primary">Save changes</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- Edit Modal end  -->
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
	<!-- Footer -->
	<?php include("part/footer.php");?>
	<!-- Footer End -->

  </div>
	<!-- Alert -->
	<?php include("part/alert.php");?> 
	<!-- Alert end --> 
	
	<!-- All JS -->
	<?php include("part/all-js.php");?>
	<!-- All JS end -->
	
	<!-- Data Table JS -->
	<?php include("part/data-table-js.php");?>
	<!-- Data Table JS end -->
  </body>
</html>
