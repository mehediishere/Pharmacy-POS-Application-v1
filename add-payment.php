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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
                <h6 class="fs-17 font-weight-600 mb-0">Add Payment</h6>
                </div>
                <div class="text-right">
                <a href="manage-payment.php" class="btn btn-info btn-sm mr-1"><i class="fas fa-align-justify mr-1"></i>Manage Payment</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <form action="actions/addPayment.php" method="POST">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Wallet/Direct Transaction</label>
                            <select class="form-control select2" name="transaction">
                              <option value="No" selected="selected">No</option>
                              <option value="Yes">Yes</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="name">Payment Date:</label>
                            <div class="input-group">
                              <input type="date" class="form-control datetimepicker-input" name="payment_date" value="<?php echo date('Y-m-d');?>">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Payment Type:</label>
                            <select class="form-control select2" name="payment_type">
                              <option value="" selected="selected">Select Type</option>
                              <option>Cash Receivable</option>
                              <option>Cash Pay</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Account Type: <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="account_type" id="account_type" required>
                              <option value="" selected="selected">Select Type</option>
                              <option value="supplier">Supplier</option>
                              <option value="customer">Customer</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Account Id: <span class="text-danger">*</span></label>
                            <select class="form-control select2 input-select-section" name="account_id" required>
                              <option value=""></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="name">Amount:</label>
                            <input type="text" class="form-control" id="amount" placeholder="Amount" name="amount" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Payment Method</label>
                            <select class="form-control select2" name="payment_method">
                              <option value="Hand Cash" selected="selected">Hand Cash</option>
                              <option>Bkash</option>
                              <option>Bank</option>
                              <option>Rocket</option>
                              <option>Cash on delivery</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Expense Note:</label>
                            <textarea class="form-control" rows="3" placeholder="Enter ..." name="details"></textarea>
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-info" name="submit">Save</button>
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
  </div>

 	<!-- Alert -->
   <?php include("part/alert.php");?> 
	<!-- Alert end --> 
	
	<!-- All JS -->
	<?php include("part/all-js.php");?>
	<!-- All JS end -->
    <script>
        $(function() {
            $(".select2").select2();

            $(".select2bs4").select2({
                theme: "bootstrap4",
            });
        });
    </script>

<script>
    $(function() { 
      $("#account_type").on( "change", function() {
        var name = $(this).val();
        $.ajax({
          url: "ajaxreq/paymentAccountList.php",
          type: "POST",
          data: 'request=' + name,
          success:function(data){
            $(".input-select-section").html(data);
          }
        });
      });
    });
  </script>

</body>

</html>