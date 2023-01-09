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
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
	  <!-- Navbar -->
    <?php include("part/navbar.php");?>
      <!-- Navbar end -->

      <!-- Sidebar -->
      <?php include("part/sidebar.php");?>
      <!--  Sidebar end -->

      <div class="content-wrapper">
        <section class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header py-2">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                      <h6 class="fs-17 font-weight-600 mb-0">Customer</h6>
                      </div>
                      <div class="text-right">
                      <a href="add-customer.php" class="btn btn-info btn-sm mr-1"><i class="fas fa-plus mr-1"></i>New Customer</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover">
                      <thead>
                        <tr class="bg-info">
                          <th>SL</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Current Due</th>
                          <th>Points</th>
                          <th>Wallet</th>
                          <th>Customer Type</th>
                          <th>Customer Status</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $n = 0;
                          $sql = $conn->query("SELECT * FROM `p_customer` WHERE `store` = '$_SESSION[store_id]'");
                          while($row = mysqli_fetch_assoc($sql)){
                        ?>
                        <tr>
                          <td><?php echo ++$n; ?></td>
                          <td class="text-capitalize"><?php echo $row['name'] ?></td>
                          <td class="text-capitalize"><?php echo $row['email'] ?></td>
                          <td class="text-capitalize"><?php echo $row['phone'] ?></td>
                          <td><?php echo $row['due'] ?></td>
                          <td class="text-capitalize"><?php echo $row['points'] ?></td>
                          <td><?php echo $row['wallet'] ?></td>
                          <td class="text-capitalize"><?php echo $row['customertype'] ?></td>
                          <td class="text-capitalize"><?php echo $row['customerstatus'] ?></td>
                          <td>
                            <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit-customer<?php echo $row['id']; ?>"><i class="fa fa-edit"></i></a>
                            <a href="actions/remove.php?remove&code=<?php echo base64_encode($row['id']); ?>&wr=<?php echo base64_encode("p_customer"); ?>" class="btn btn-danger btn-sm delete" onclick="return confirm('Are you sure to delete?')"> <i class="fa fa-trash"></i> </a>
                          </td>
                        </tr>
                        <!-- Modal  start -->
                        <div class="modal fade" id="edit-customer<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title badge badge-info">Update</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form method="POST" action="actions/addCustomer.php">
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Customer Name" name="name" value="<?php echo $row['name'] ?>">
                                        <input type="hidden" name="code" value="<?php echo $row['id'] ?>">
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="name">Email</label>
                                        <input type="email" class="form-control" placeholder="Enter Customer Email" name="email" value="<?php echo $row['email'] ?>">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="name">Address</label>
                                        <input type="text" class="form-control" placeholder="Enter Address" name="addr" value="<?php echo $row['address'] ?>">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="name">Phone</label>
                                        <input type="text" class="form-control" placeholder="Enter Customer Phone" name="phone" value="<?php echo $row['phone'] ?>">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="name">Type</label>
                                          <select class="form-control select2" name="customerType">
                                              <option value="<?php echo $row['customertype'] ?>" selected="selected"><?php echo $row['customertype'] ?></option>
                                              <option value="Regular-Customer">Regular-Customer</option>
                                              <option value="Walk-in-Customer">Walk-in-Customer</option>
                                          </select>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="name">Points</label>
                                        <input type="text" class="form-control" name="points" value="<?php echo $row['points'] ?>">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="name">Current Due</label>
                                        <input type="text" class="form-control" name="due" value="<?php echo $row['due'] ?>">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="name">Wallet</label>
                                        <input type="text" class="form-control" name="wallet" value="<?php echo $row['wallet'] ?>">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="name">Status</label>
                                          <select class="form-control select2" name="customerStatus">
                                              <option value="<?php echo $row['customerstatus'] ?>" selected="selected"><?php echo $row['customerstatus'] ?></option>
                                              <option value="Active">Active</option>
                                              <option value="In-Active">In-Active</option>
                                          </select>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-info" name="submitUP">Save changes</button>
                                </div>
                                </form>
                            </div>
                          </div>
                        </div>
                        <!-- Modal end -->
                        <?php } ?>
                      </tbody>
                    </table>
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
