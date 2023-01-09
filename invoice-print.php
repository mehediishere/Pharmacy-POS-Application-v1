<?php
	session_start();
	if(!isset($_SESSION['store_id'])) {
		header("location:login.php");
		exit();
	}elseif(!isset($_SESSION["invoice_user_print"])){
    echo "<script>window.history.back();</script>";
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

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <div class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h4>
          <i class="fas fa-globe"></i> AdminLTE, Inc.
          <small class="float-right">Date: 2/10/2014</small>
        </h4>
      </div>
    </div>
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong>Admin, Inc.</strong><br>
          795 Folsom Ave, Suite 600<br>
          San Francisco, CA 94107<br>
          Phone: (804) 123-5432<br>
          Email: info@almasaeedstudio.com
        </address>
      </div>
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong><?php echo $_SESSION["invoice_user_print"]["name"]; ?></strong><br>
          Phone: <?php echo $_SESSION["invoice_user_print"]["phone"]; ?><br>
          Email: <?php echo $_SESSION["invoice_user_print"]["email"]; ?><br>
          Address: <?php echo $_SESSION["invoice_user_print"]["address1"]; ?>
        </address>
      </div>
      <div class="col-sm-4 invoice-col">
        <h5>Invoice #<?php echo $_SESSION["invoice_user_print"]["invoice"]; ?></h5><br>
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
            foreach($_SESSION["invoice_cart_print"] as $value){
                $sumPrice += $value['price']*$value['quantity'];
                $total += $sumPrice;
            ?>
          <tr>
            <td><?php echo ++$n; ?></td>
            <td><?php echo $value['name'] ?></td>
            <td><?php echo $value['quantity'] ?></td>
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
        <p class="lead">Amount Due 2/22/2014</p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td><?php echo $total ?> Tk</td>
            </tr>
            <tr>
              <th>Discount (<?php echo $_SESSION["invoice_user_print"]["discount_type"]; ?>)</th>
              <td><?php echo ($_SESSION["invoice_user_print"]["discount"] < 0) ? 0 : $_SESSION["invoice_user_print"]["discount"]; ?> Tk</td>
            </tr>
            <tr>
              <th>Grand Total: </th>
              <td><?php echo $_SESSION["invoice_user_print"]["after_discount"]; ?> Tk</td>
            </tr>
            <tr>
              <th>Paid: </th>
              <td><?php echo $_SESSION["invoice_user_print"]["paid"]; ?> Tk</td>
            </tr>
            <tr>
              <th>Due: </th>
              <td><?php echo ($_SESSION["invoice_user_print"]["due"] < 0) ? 0 : $_SESSION["invoice_user_print"]["due"]; ?> Tk</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
