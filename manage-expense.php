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
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header py-2">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                    <h6 class="fs-17 font-weight-600 mb-0">Expense List</h6>
                    </div>
                    <div class="text-right">
                      <a href="manage-expense.php" class="btn btn-warning btn-sm mr-1"><i class="fas fa-align-justify mr-1"></i>Manage Expense</a>
                      <a href="expense-category.php" class="btn btn-success btn-sm mr-1"><i class="fas fa-align-justify mr-1"></i>Manage Category</a>
                      <a href="expense.php" class="btn btn-info btn-sm mr-1"><i class="fas fa-align-justify mr-1"></i>Add Expense</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <tr class="bg-info">
                        <th>#</th>
                        <th>Expense</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Note</th>
                        <th>Amount</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        $num = 0;
                        $sql = $conn->query("SELECT * FROM `p_expense` WHERE `store` = '$_SESSION[store_id]'");
                        while($row = mysqli_fetch_assoc($sql)){
                      ?>
                      <tr>
                        <td> <?php echo ++$num; ?> </td>
                        <td> <?php echo $row['name']; ?> </td>
                        <td> <?php echo $row['expense_date']; ?> </td>
                        <td> <?php echo $row['category']; ?> </td>
                        <td> <?php echo $row['details']; ?> </td>
                        <td> <?php echo $row['amount']; ?> </td>
                        <td>
                          <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit-expense<?php echo $row['id']; ?>"><i class="fa fa-edit"></i></a>
                          <a href="actions/remove.php?remove&code=<?php echo base64_encode($row['id']); ?>&wr=<?php echo base64_encode("p_expense"); ?>" class="btn btn-danger btn-sm delete" onclick="return confirm('Are you sure to delete?')"> <i class="fa fa-trash"></i> </a>
                        </td>
                      </tr>
                      <!-- Modal  start -->
                      <div class="modal fade" id="edit-expense<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title badge badge-info">Update Expense</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form method="POST" action="actions/expense.php">
                                  <div class="row">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="name">Expense Name:</label>
                                        <input type="text" class="form-control" id="expense-name" placeholder="Expense Name" name="expense_name" value="<?php echo $row['name']; ?>" required>
                                        <input type="hidden" class="form-control" name="code" value="<?php echo base64_encode($row['id']); ?>">
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="name">Expense Amount:</label>
                                        <input type="text" class="form-control" id="expense-amount" placeholder="Expense Amount" name="expense_amount" value="<?php echo $row['amount']; ?>" required>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="name">Expense Date:</label>
                                        <div class="input-group">
                                          <input type="date" class="form-control" name="edate" value="<?php echo $row['expense_date']; ?>">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Expense Category:</label>
                                        <select class="form-control select2" name="expense_category">
                                          <option value="<?php echo $row['category']; ?>" selected="selected"><?php echo $row['category']; ?></option>
                                          <?php
                                            $cat = $conn->query("SELECT * FROM `p_expense_category` WHERE `store` = '$_SESSION[store_id]'");
                                            while($rw = mysqli_fetch_assoc($cat)){
                                          ?>
                                          <option value="<?php echo $rw['category'] ?>"><?php echo $rw['category'] ?></option>
                                          <?php } ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Paid With:</label>
                                        <select class="form-control select2" name="paymentM">
                                          <option value="<?php echo $row['payment_method']; ?>" selected="selected"><?php echo $row['payment_method']; ?></option>
                                          <option value="Hand Cash">Hand Cash</option>
                                          <option value="Bkash">Bkash</option>
                                          <option value="Rocket">Rocket</option>
                                          <option value="Cash on Delivery">Cash on Delivery</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Expense Note:</label>
                                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="details"><?php echo $row['details'] ?></textarea>
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
                    <tfoot class="bg-light">
                      <tr>
                        <td colspan="5" class="text-right">Total : </td>
                        <td colspan="2"> <strong> 50 Tk </strong> </td>
                      </tr>
                    </tfoot>
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

    <script>
      $(function() {
          $(".select2").select2();

          $(".select2bs4").select2({
              theme: "bootstrap4",
          });
      });
    </script>


</body>

</html>