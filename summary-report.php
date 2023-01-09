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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Summary Report</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <button class="btn btn-primary">Home</button>
              </ol>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-12">
              <div class="card">


                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="card card-body bg-success">
                        <h6 class="text-white text-uppercase">Sell Amount</h6>
                        <?php $result = mysqli_fetch_assoc($conn->query("SELECT IFNULL(SUM(`paid`), 0) as paid FROM `p_invoice_summary` WHERE `store` = '$_SESSION[store_id]'"));?>
                        <p class="fs-18 fw-700">৳ <?php echo $result['paid']; ?></p>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="card card-body bg-primary">
                        <h6 class="text-white text-uppercase">Sell Profit</h6>
                        <?php $result = mysqli_fetch_assoc($conn->query("SELECT IFNULL(SUM(`total_price`-`total_cost`), 0) as profit FROM `p_invoice_summary` WHERE `store` = '$_SESSION[store_id]'"));?>
                        <p class="fs-18 fw-700">৳ <?php echo $result['profit']; ?> </p>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="card card-body bg-danger">
                        <h6 class="text-white text-uppercase">Purchase Cost</h6>
                        <?php $result = mysqli_fetch_assoc($conn->query("SELECT IFNULL(SUM(`total_price`), 0) as purchase FROM `p_purchase_summary` WHERE `store` = '$_SESSION[store_id]' AND `paid_status` != 'unpaid'"));?>
                        <p class="fs-18 fw-700">৳ <?php echo $result['purchase']; ?></p>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="card card-body bg-dark">
                        <h6 class="text-white text-uppercase">Expense</h6>
                        <?php $result = mysqli_fetch_assoc($conn->query("SELECT IFNULL(SUM(`amount`), 0) as expense FROM `p_expense` WHERE `store` = '$_SESSION[store_id]'"));?>
                        <p class="fs-18 fw-700">৳ <?php echo $result['expense']; ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
            <div class="col-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Top Sell Product</h4>
                  </div>
                  <div class="card-body">
                    <table id="mytable" class="table table-bordered table-hover">
                      <thead>
                        <tr class="bg-info">
                          <th>Total Sale</th>
                          <th>Product Name</th>
                          <th>Quantity</th>
                          <th>Price</th>
                          <th>Sale Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $n = 0;
                          $sql = $conn->query("SELECT `name`, `qty`, `price` FROM `p_medicine` WHERE `store` = '$_SESSION[store_id]'");
                          while($row = mysqli_fetch_assoc($sql)){
                            $sellQty = mysqli_fetch_assoc($conn->query("SELECT sum(qty) AS `qty` FROM `p_invoice` where `product` = '$row[name]' AND `store` = '$_SESSION[store_id]'"));
                        ?>
                        <tr>
                          <td><?php if(!empty($sellQty['qty'])){ echo $sellQty['qty']; }else{ echo 0;} ?></td>
                          <td><?php echo $row['name']; ?></td>
                          <td><?php echo $row['qty']; ?></td>
                          <td><?php echo $row['price']; ?></td>
                          <td><?php echo $sellQty['qty']*$row['price']; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                      <tfoot class="bg-light">
                        <tr>
                          <td colspan="4" class="text-right"><strong>Total Sales (tk): </strong></td>
                          <td><strong id="totalSales"> 0.00 </strong></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Expense</h4>
                  </div>
                  <div class="card-body">
                    <table id="mytable2" class="table table-bordered table-hover">
                      <thead>
                        <tr class="bg-info">
                          <th>#</th>
                          <th>Expense</th>
                          <th>Category</th>
                          <th>Payment Method</th>
                          <th>Amount</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $n = 0;
                          $sql = $conn->query("SELECT * FROM p_expense WHERE store = '$_SESSION[store_id]'");
                          while($row = mysqli_fetch_assoc($sql)){
                        ?>
                        <tr>
                          <td><?php echo ++$n; ?></td>
                          <td><?php echo $row['name']; ?></td>
                          <td><?php echo $row['category']; ?></td>
                          <td><?php echo $row['payment_method']; ?></td>
                          <td><?php echo $row['amount']; ?></td>
                          <td><?php echo $row['expense_date']; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                      <tfoot class="bg-light">
                        <tr>
                          <td colspan="4" class="text-right"><strong> Total (tk): </strong> </td>
                          <td colspan="1"><strong id="totalExpense"> 0.00 </strong> </td>
                          <td></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-6">
              <div class="card">
                  <div class="card-header">
                    <h4>Purchase Product</h4>
                  </div>
                  <div class="card-body">
                    <table id="mytable3" class="table table-bordered table-hover">
                      <thead>
                        <tr class="bg-info">
                          <th>#</th>
                          <th>Invoice</th>
                          <th>Total Items</th>
                          <th>Total Price</th>
                          <th>Paid Status</th>
                          <th>Order Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $n = 0;
                          $sql = $conn->query("SELECT * FROM `p_purchase_summary` WHERE store = '$_SESSION[store_id]' ORDER BY `date` DESC");
                          while($row = mysqli_fetch_assoc($sql)){
                        ?>
                        <tr>
                          <td><?php echo ++$n; ?></td>
                          <td> <?php echo $row['invoice']; ?> </td>
                          <td><?php echo $row['total_qty']; ?></td>
                          <td><?php echo $row['total_price']; ?></td>
                          <td><?php echo $row['paid_status']; ?></td>
                          <td><?php echo $row['status']; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="3" class="text-right"> <strong> Total (tk):</strong></td>
                          <td> <strong id="totalPurchase"> 0 </strong> </td>
                          <td></td>
                          <td></td>
                        </tr>
                      </tfoot>

                    </table>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Cash Received</h4>
                  </div>
                  <div class="card-body">
                    <table id="mytable4" class="table table-bordered table-hover">
                      <thead>
                        <tr class="bg-info">
                          <th>#</th>
                          <th>Name</th>
                          <th>Customer/Supplier</th>
                          <th>Payment Date</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $n = 0;
                          $sql = $conn->query("SELECT * FROM `p_payment` WHERE `store` = '$_SESSION[store_id]' AND `payment_type` = 'Cash Receivable'");
                          while($row = mysqli_fetch_assoc($sql)){
                        ?>
                        <tr>
                          <td><?php echo ++$n; ?></td>
                          <td> <?php echo $row['name']; ?> </td>
                          <td><?php echo $row['account_type']; ?></td>
                          <td><?php echo $row['payment_date']; ?></td>
                          <td><?php echo $row['amount']; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="4" class="text-right"><strong>Total (tk): </strong> </td>
                          <td> <strong id="totalReceived"> 0.00 </strong> </td>
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
	
	<!-- Data Table JS -->
	<?php include("part/data-table-js.php");?>
	<!-- Data Table JS end -->


  <!-- Page specific script -->
  <script>
    $(function () {
      //Initialize Select2 Elements
      $(".select2").select2();

      //Initialize Select2 Elements
      $(".select2bs4").select2({
        theme: "bootstrap4",
      });
    });
  </script>

    <script>
      $(document).ready(function () {
          $('#mytable').DataTable({
              order: [[0, 'desc']],
              // pageLength : 3,
              dom: 'Bfrtip',
              buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print', 'colvis' ],
              "footerCallback": function (row, data, start, end, display) {                
                var totalAmount = 0;
                for (var i = 0; i < data.length; i++) {
                    totalAmount += parseFloat(data[i][4]);
                }
                // console.log(totalAmount);
                $("#totalSales").text(totalAmount);
              }
          });

          $('#mytable2').DataTable({
              // order: [[0, 'desc']],
              dom: 'Bfrtip',
              buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print', 'colvis' ],
              "footerCallback": function (row, data, start, end, display) {                
                //Get data here 
                // console.log(data);
                var totalAmount = 0;
                for (var i = 0; i < data.length; i++) {
                    totalAmount += parseFloat(data[i][4]);
                }
                // console.log(totalAmount);
                $("#totalExpense").text(totalAmount);
              }
          });

          $('#mytable3').DataTable({
              // order: [[0, 'desc']],
              dom: 'Bfrtip',
              buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print', 'colvis' ],
              "footerCallback": function (row, data, start, end, display) {                
                //Get data here 
                // console.log(data);
                var totalAmount = 0;
                for (var i = 0; i < data.length; i++) {
                    totalAmount += parseFloat(data[i][3]);
                }
                // console.log(totalAmount);
                $("#totalPurchase").text(totalAmount);
              }
          });

          $('#mytable4').DataTable({
              // order: [[0, 'desc']],
              dom: 'Bfrtip',
              buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print', 'colvis' ],
              "footerCallback": function (row, data, start, end, display) {                
                //Get data here 
                // console.log(data);
                var totalAmount = 0;
                for (var i = 0; i < data.length; i++) {
                    totalAmount += parseFloat(data[i][4]);
                }
                // console.log(totalAmount);
                $("#totalReceived").text(totalAmount);
              }
          });
      });
    </script>

</body>

</html>