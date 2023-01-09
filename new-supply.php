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
                  <h6 class="fs-17 font-weight-600 mb-0">New Supply</h6>
                  </div>
                  <div class="text-right">
                  <a href="manage-supply.php" class="btn btn-info btn-sm mr-1"><i class="fas fa-align-justify mr-1"></i>Manage Supply</a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <form action="actions/addNewSupply.php" method="POST">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="name">Title</label>
                      <input type="text" class="form-control" placeholder="Enter a title / Supplier name" name="title" required>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="name">Supply Date</label>
                      <input type="date" class="form-control" placeholder="Enter supply date" value="<?php echo date('Y-m-d');?>" name="supplydate" required>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="name">Supplier</label>
                      <select class="form-control select2" name="supplier">
                        <option value="" selected="selected"></option>
                          <?php
                            $sql = $conn->query("SELECT `id`, `name`, `phone` FROM `p_supplier` WHERE `store` = '$_SESSION[store_id]'");
                            while($row = mysqli_fetch_assoc($sql)){
                          ?>
                          <option class="text-capitalize" value="<?php echo $row['name']." (".$row['phone'].")"; ?>"><?php echo ucfirst($row['name'])." (".$row['phone'].")"; ?></option>
                          <?php
                            }
                          ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="name">Medicine Supply Details</label>
                      <textarea name="details" class="form-control" rows="5" placeholder="Ex. 
1. Baxidal - 10pc - 30tk 
2. Losactil - 10pc - 50tk"></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Total</label>
                      <input type="number" class="form-control" placeholder="Enter total amount" name="total">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Payable</label>
                      <span class="text-danger">(Keep it blank if no Discount applied)</span>
                      <input type="number" class="form-control" name="payable" placeholder="Enter payable amount after discount">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Paid</label>
                      <input type="number" class="form-control" placeholder="Enter paid amount" name="paid">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Due</label>
                      <input type="number" class="form-control" name="due" placeholder="Enter due amount">
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <button type="submit" name="submit" class="btn btn-info"> <i class="fa fa-save mr-2"></i> Save </button>
                </div>
              </form>
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
	
</div>

<!-- Alert -->
<?php include("part/alert.php");?> 
<!-- Alert end --> 
	<!-- All JS -->
	<?php include("part/all-js.php");?>
	<!-- All JS end -->
  <!-- Page specific script -->
  <script>
    $(function () {
      $(".select2").select2({
        tags: true,
        placeholder: "Type / Select supplier. Ex - name (phone number)"
      });

      $(".select2bs4").select2({
        theme: "bootstrap4",
      });

    });
  </script>

</body>

</html>