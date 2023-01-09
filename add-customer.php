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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="container-fluid">
          <div class="row">
            <div class="card card-default col-md-12 col-lg-9">
              <div class="card-header py-2">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                  <h6 class="fs-17 font-weight-600 mb-0">New Customer</h6>
                  </div>
                  <div class="text-right">
                  <a href="manage-customer.php" class="btn btn-info btn-sm mr-1"><i class="fas fa-bars mr-1"></i>Manage Customer</a>
                  </div>
                </div>
              </div>
              <form action="actions/addCustomer.php" method="POST">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" id="name" placeholder="Enter Customer Name" name="name">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Email</label>
                      <input type="email" class="form-control" id="email" placeholder="Enter Customer Email"
                        name="email">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Address</label>
                      <input type="text" class="form-control" id="email" placeholder="Enter Address" name="addr1">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Phone</label>
                      <input type="text" class="form-control" id="phone" placeholder="Enter Customer Phone"
                        name="phone">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Points</label>
                      <input type="text" class="form-control" id="receivable" name="points">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Type</label>
                        <select class="form-control select2" name="customerType">
                            <option value="Regular-Customer" selected="selected">Regular-Customer</option>
                            <option value="Walk-in-Customer">Walk-in-Customer</option>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Status</label>
                        <select class="form-control select2" name="customerStatus">
                            <option value="Active" selected="selected">Active</option>
                            <option value="In-Active">In-Active</option>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-6"></div>
                  <div class="ml-2 form-row justify-content-center">
                    <button type="submit" class="btn btn-info" name="submit"> <i class="fa fa-save mr-2"></i> Save </button>
                  </div>
                </div>
              </div>
              </form>
            </div>
            <!-- ads start  -->
            <div class="d-none d-lg-block col-lg-3">
              <div class="card">
                <a href="#"> <img src="dist/img/clinic.jpg" alt="" class="img-fluid"> </a>
              </div>
            </div>
            <!-- ads end  -->
          </div>
      </section>
    </div>
	<!-- Footer -->
	<?php include("part/footer.php");?>
	<!-- Footer End -->
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
    $(function () {
      $(".select2").select2();

      $(".select2bs4").select2({
        theme: "bootstrap4",
      });
    });
  </script>

</body>

</html>