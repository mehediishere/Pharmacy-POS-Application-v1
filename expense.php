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
          <div class="card card-default col-md-12 col-lg-9">
            <div class="card-header py-2">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                <h6 class="fs-17 font-weight-600 mb-0">New Expense</h6>
                </div>
                <div class="text-right">
                  <a href="manage-expense.php" class="btn btn-warning btn-sm mr-1"><i class="fas fa-align-justify mr-1"></i>Manage Expense</a>
                  <a href="expense-category.php" class="btn btn-success btn-sm mr-1"><i class="fas fa-align-justify mr-1"></i>Manage Category</a>
                  <a href="expense.php" class="btn btn-info btn-sm mr-1"><i class="fas fa-align-justify mr-1"></i>Add Expense</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <form method="POST" action="actions/expense.php">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="name">Expense Name:</label>
                            <input type="text" class="form-control" id="expense-name" placeholder="Expense Name"
                              name="expense_name" required>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="name">Expense Amount:</label>
                            <input type="text" class="form-control" id="expense-amount" placeholder="Expense Amount" name="expense_amount" required>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="name">Expense Date:</label>
                            <div class="input-group">
                              <input type="date" class="form-control" name="edate" value="<?php echo date('Y-m-d');?>">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Expense Category:</label>
                            <select class="form-control select2" name="expense_category">
                              <option value="" selected="selected">Select a Category</option>
                              <?php
                                $n = 0;
                                $sql = $conn->query("SELECT * FROM `p_expense_category` WHERE `store` = '$_SESSION[store_id]'");
                                while($row = mysqli_fetch_assoc($sql)){
                              ?>
                              <option value="<?php echo $row['category'] ?>"><?php echo $row['category'] ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Paid With:</label>
                            <select class="form-control select2" name="paymentM">
                              <option value="" selected="selected">Select a Category</option>
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
                            <textarea class="form-control" rows="3" placeholder="Enter ..." name="details"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div>
                      <button type="submit" class="btn btn-info" name="submitEX">Save</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- ads start  -->
          <div class="d-none d-lg-block col-lg-3">
            <div class="card">
              <a href="#"> <img src="dist/img/clinic.jpg" alt="" class="img-fluid"> </a>
            </div>
          </div>
          <!-- ads end  -->
        </div>
    </div>
    </section>
  </div>

  <!-- Footer -->
  <?php include("part/footer.php");?>
  <!-- Footer End -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- Alert -->
  <?php include("part/alert.php");?>
  <!-- Alert end -->

  <!-- All JS -->
  <?php include("part/all-js.php");?>
  <!-- All JS end -->

  <!-- Page specific script -->
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