<?php
	session_start();
	if(!isset($_SESSION['store_id'])) {
		header("location:login.php");
		exit();
	}elseif(!isset($_GET['id']) || ctype_space($_GET['id'])){
    echo "<script>window.history.back();</script>";
    exit();
  }
  else{
		include('config/db.php');
    $id = $_GET['id'];
    $check = mysqli_num_rows($conn->query("SELECT `invoice` FROM `p_invoice` WHERE `invoice` = '$id'"));
    if($check > 0){
      $invoiceDetails = $conn->query("SELECT * FROM `p_invoice` WHERE `invoice` = '$id' AND `store` = '$_SESSION[store_id]'");
      $invoiceSummary = mysqli_fetch_assoc($conn->query("SELECT * FROM `p_invoice_summary` WHERE `invoice` = '$id' AND `store` = '$_SESSION[store_id]'"));
      $user = mysqli_fetch_assoc($conn->query("SELECT * FROM `p_customer` WHERE `id` = '$invoiceSummary[client]' AND `store` = '$_SESSION[store_id]'"));
    }else{
      echo "<script>window.history.back();</script>";
      exit();
    }
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pharmacy</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
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

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Note:</h5>
              This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div>


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Pharmacy
                    <small class="float-right">Date: <?php echo $invoiceSummary['order_date'];?></small>
                  </h4>
                </div>
              </div>
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <strong>From</strong>
                  <address>
                    <strong>Admin, Inc.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                    Email: info@almasaeedstudio.com
                  </address>
                </div>
                <div class="col-sm-4 invoice-col">
                  <strong>To</strong>
                  <address>
                    Name: <strong><?php echo isset($user["name"])?$user["name"]:"Walk in customer"; ?></strong><br>
                    Phone: <?php echo isset($user["phone"])?$user["phone"]:""; ?><br>
                    Email: <?php echo isset($user["email"])?$user["email"]:""; ?><br>
                    Address: <?php echo isset($user["address"])?$user["address"]:""; ?>
                  </address>
                </div>
                <div class="col-sm-4 invoice-col">
                  <h5>Invoice #<?php echo $id; ?></h5><br>
                </div>
              </div>
              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>SL</th>
                      <th>Product</th>
                      <th>Quantity</th>
                      <th>Price</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                      $sumPrice = 0; $total = 0; $n = 0;
                      while($value = mysqli_fetch_assoc($invoiceDetails)){
                          $sumPrice += $value['price']*$value['qty'];
                          $total += $sumPrice;
                      ?>
                    <tr>
                      <td><?php echo ++$n; ?></td>
                      <td><?php echo $value['product'] ?></td>
                      <td><?php echo $value['qty'] ?></td>
                      <td><?php echo $value['price'] ?></td>
                      <td><?php echo $sumPrice ?></td>
                    </tr>
                    <?php $sumPrice =0; } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Payment Methods:</p>
                  <img src="dist/img/credit/visa.png" alt="Visa">
                  <img src="dist/img/credit/mastercard.png" alt="Mastercard">
                  <img src="dist/img/credit/american-express.png" alt="American Express">
                  <img src="dist/img/credit/paypal2.png" alt="Paypal">

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead"></p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td><?php echo number_format((float)$total, 2, '.', ''); ?> Tk</td>
                      </tr>
                      <tr>
                        <th>Discount:</th>
                        <td><?php echo ($invoiceSummary["discount"] < 0) ? 0.00 : number_format((float)$invoiceSummary["discount"], 2, '.', ''); ?> (<?php echo $invoiceSummary["discount_type"]; ?>)</td>
                      </tr>
                      <tr>
                        <th>Grand Total: </th>
                        <td><?php echo $invoiceSummary["payable"]; ?> Tk</td>
                      </tr>
                      <tr>
                        <th>Paid: </th>
                        <td><?php echo $invoiceSummary["paid"]; ?> Tk</td>
                      </tr>
                      <tr>
                        <th>Due: </th>
                        <td><?php echo ($invoiceSummary["due"] <= 0) ? 0.00 : number_format((float)$invoiceSummary["due"], 2, '.', ''); ?> Tk</td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="sales-invoice-print.php?id=<?php echo $id; ?>" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                  <!-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit Payment </button> -->
                  <!-- <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;"> <i class="fas fa-download"></i> Generate PDF </button> -->
                </div>
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

	
	<!-- Alert -->
	<?php include("part/alert.php");?> 
	<!-- Alert end --> 
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
