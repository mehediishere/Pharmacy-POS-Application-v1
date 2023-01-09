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
              <h1>Daily Report</h1>
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
                <div class="card-header">
                  <h3 class="card-title">Daily Report</h3>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example11" class="table table-bordered table-hover">
                    <thead class="bg-info">
                      <tr>
                        <th>Date</th>
                        <th>Sell Amount</th>
                        <th>Purchase Amount</th>
                        <th>Expenses</th>
                        <th>Returned</th>
                        <!-- <th>Sell/Gross Profit</th> -->
                        <!-- <th>Net Profit</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $day = 1;
                        $month = date('m', strtotime($date));
                        $year = date('Y', strtotime($date));
                        $dateLoop = $year."-".$month."-".$day;
                        while($day <= 31){
                          $sellAmount = mysqli_fetch_assoc($conn->query("SELECT SUM(total_price) as pr FROM `invoice_summary` WHERE `store` = '$_SESSION[store_id]' and order_date = '$dateLoop' group by order_date"));
                          $purchaseAmount = mysqli_fetch_assoc($conn->query("SELECT SUM(payable) as ps FROM `purchase_summary` WHERE `store` = '$_SESSION[store_id]' and `date` = '$dateLoop' group by `date`"));
                          $expense = mysqli_fetch_assoc($conn->query("SELECT SUM(amount) as ee FROM `expense` WHERE `store` = '$_SESSION[store_id]' and `expense_date` = '$dateLoop' group by `expense_date`"));
                          $returned = mysqli_fetch_assoc($conn->query("SELECT SUM(returnable) as rr FROM `return_summary` WHERE `store` = '$_SESSION[store_id]' and `date` = '$dateLoop' group by `date`"));
                      ?>
                      <tr>
                        <td><?php echo $dateLoop; ?></td>
                        <td><?php echo isset($sellAmount['pr']) ? $sellAmount['pr'] : "0.00"; ?></td>
                        <td><?php echo isset($purchaseAmount['ps']) ? $purchaseAmount['ps'] : "0.00"; ?></td>
                        <td><?php echo isset($expense['ee']) ? $expense['ee'] : "0.00"; ?></td>
                        <td><?php echo isset($returned['rr']) ? $returned['rr'] : "0.00"; ?></td>
                        <!-- <td>0</td> -->
                        <!-- <td>0</td> -->
                        <!-- <td>0</td> -->
                      </tr>
                      <?php 
                          $dateLoop = $year."-".$month."-".++$day; 
                        } 
                      ?>
                    </tbody>
                    <tfoot class="bg-light">
                      <tr>
                        <td><strong>Total:</strong></td>
                        <td><strong id="sellAmount">0.00</strong></td>
                        <td><strong id="purchaseAmount">0.00</strong></td>
                        <td><strong id="expense">0.00</strong></td>
                        <td><strong id="returned">0.00</strong></td>
                        <!-- <td>121850</td> -->
                        <!-- <td>116450</td> -->
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->


              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
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
    $(function () {
      $(".select2").select2();

      $(".select2bs4").select2({
        theme: "bootstrap4",
      });

      $('#example11').DataTable({
          // order: [[0, 'desc']],
          dom: 'Bfrtip',
          buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print', 'colvis' ],
          "footerCallback": function (row, data, start, end, display) {                
            //Get data here 
            // console.log(data);
            var sellAmount = 0;
            var purchaseAmount = 0;
            var expense = 0;
            var returned = 0;
            for (var i = 0; i < data.length; i++) {
                sellAmount += parseFloat(data[i][1]);
                purchaseAmount += parseFloat(data[i][2]);
                expense += parseFloat(data[i][3]);
                returned += parseFloat(data[i][4]);
            }
            // console.log(totalAmount);
            $("#sellAmount").text(sellAmount);
            $("#purchaseAmount").text(purchaseAmount);
            $("#expense").text(expense);
            $("#returned").text(returned);
          }
      });
    });
  </script>

</body>

</html>