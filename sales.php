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

    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css" />
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />

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

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
        
            <!-- <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-3">
                        <input type="text" class="form-control" id="product-code" placeholder="Enter Product Code" name="product-code">
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <div class="input-group date" id="reservationdate" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate">
                              <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                      </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate2">
                              <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                      </div>
                      </div>
                      <div class="col-md-3">
                        <select class="form-control select2">
                          <option selected="selected">Walk-in-Customer</option>
                          <option>Alaska</option>
                          <option>California</option>
                          <option>Delaware</option>
                          <option>Tennessee</option>
                          <option>Texas</option>
                          <option>Washington</option>
                        </select>
                      </div>
                    </div>
                    <div class="mt-5" style="display: flex;">
                      <button type="button" class="btn btn-info" style="margin-right: 10px;width: 120px;">Filter</button>
                      <button type="button" class="btn btn-info" style="margin-right: 10px;width: 120px;">Reset</button> 
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Products</h3>
                  </div>
            
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover">
                      <thead>
                        <tr class="bg-info">
                          <th>SL</th> <!-- 1 -->
                          <th>Invoice</th>  <!-- 2 -->
                          <th>Customer</th>  <!-- 3 -->
                          <th>Items</th>  <!-- 4 -->
                          <th>Date</th>  <!-- 5 -->
                          <th>Total Price</th>  <!-- 6 -->
                          <th>Discount</th>  <!-- 7 -->
                          <th>Receivable</th>  <!-- 8 -->
                          <th>Paid</th>  <!-- 9 -->
                          <th>Due</th>  <!-- 10 -->
                          <th>Purchase Cost</th>  <!-- 11 -->
                          <th>Profit</th>  <!-- 12 -->
                          <th>Status</th>  <!-- 13 -->
                          <th>Actions</th>  <!-- 14 -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $n = 0;
                          $sql = $conn->query("SELECT * FROM `p_invoice_summary` WHERE `store` = '$_SESSION[store_id]' ORDER BY `id` DESC");
                          while($row = mysqli_fetch_assoc($sql)){
                            ?>
                        <tr>
                          <td><?php echo ++$n; ?></td> <!-- 1 -->
                          <td><?php echo $row['invoice']; ?></td> <!-- 2 -->
                          <td> <!-- 3 -->
                          <?php 
                            if($row['client'] != "Walk-in-Customer"){
                              $row2 = mysqli_fetch_assoc($conn->query("SELECT `id`,`name` FROM `customer` WHERE `store` = '$_SESSION[store_id]' AND `id` = $row[client]"));
                              echo $row2['name'];
                              $customer = $row2['name'];
                            }else{
                              echo $row['client'];
                              $customer = $row['client'];
                            }
                          ?>
                          </td>
                          <td> <!-- 4 -->
                            <ul>
                              <?php
                                $purchaseCost = 0;
                                $medicine = $conn->query("SELECT * FROM `p_invoice` WHERE `invoice` = $row[invoice]");
                                while($medicineName = mysqli_fetch_assoc($medicine)){
                              ?>
                              <li>
                                <?php 
                                  echo $medicineName['product']." (".$medicineName['qty'].")"; 
                                  $purchaseCost = $purchaseCost+($medicineName['qty']*$medicineName['cost']);
                                ?>
                              </li>
                              <?php } ?>
                            </ul>
                          </td>
                          <td><?php echo $row['order_date']; ?></td> <!-- 5 -->
                          <td><?php echo $row['total_price']; ?></td> <!-- 6 -->
                          <td><?php echo $row['discount']." ".$row['discount_type']; ?></td> <!-- 7 -->
                          <td> <?php echo $row['payable'] ?> </td> <!-- 8 -->
                          <td><?php echo $row['paid']; ?></td> <!-- 9 -->
                          <td><?php echo $row['due']; ?></td> <!-- 10 -->
                          <td><?php echo $purchaseCost; ?></td> <!-- 11 -->
                          <td><?php echo $row['total_price'] - $row['total_cost']; ?></td> <!-- 12 -->
                          <td class="text-center"> <!-- 13 -->
                            <?php 
                              if($row['due'] == 0){
                                echo "PAID";
                              }else{
                                echo "UNPAID";
                              }
                            ?>
                          </td>
                          <td class="text-center"> <!-- 14 -->
                            <div class="btn-group">
                              <button class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-cogs"></i> Manage</button>

                              <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 30px; left: 0px; will-change: top, left;">
                                <a class="dropdown-item" href="sales-history.php?id=<?php echo $row['client'] ?>"> <i class="fa fa-history text-secondary"></i> Sell History </a> 
                                <a class="dropdown-item" href="sales-invoice.php?id=<?php echo $row['invoice']; ?>"> <i class="fa fa-print text-cyan"></i> Print </a> 
                                <a class="dropdown-item" href="return-action.php?invoice=<?php echo $row['invoice'];?>&&customer=<?php echo $customer;?>"> <i class="fa fa-backward text-success"></i> Return </a>  
                                <!-- <a class="dropdown-item delete" href=""> <i class="fa fa-trash text-danger"></i> Delete </a> -->
                                <a href="actions/remove.php?sales&code=<?php echo base64_encode($row['invoice']); ?>" class="dropdown-item delete" onclick="return confirm('Are you sure to delete?')"> <i class="fa fa-trash text-danger"></i> Delete</a>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
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
  <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Page specific script -->
    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Initialize Select2 Elements
        $(".select2bs4").select2({
          theme: "bootstrap4",
        });

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", { placeholder: "dd/mm/yyyy" });
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", { placeholder: "mm/dd/yyyy" });
        //Money Euro
        $("[data-mask]").inputmask();

        //Date picker
        $("#reservationdate").datetimepicker({
          format: "L",
        });
        //Date picker
        $("#reservationdate2").datetimepicker({
          format: "L",
        });

        //Date and time picker
        $("#reservationdatetime").datetimepicker({ icons: { time: "far fa-clock" } });

        //Date range picker
        $("#reservation").daterangepicker();
        //Date range picker with time picker
        $("#reservationtime").daterangepicker({
          timePicker: true,
          timePickerIncrement: 30,
          locale: {
            format: "MM/DD/YYYY hh:mm A",
          },
        });
        //Date range as a button
        $("#daterange-btn").daterangepicker(
          {
            ranges: {
              Today: [moment(), moment()],
              Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
              "Last 7 Days": [moment().subtract(6, "days"), moment()],
              "Last 30 Days": [moment().subtract(29, "days"), moment()],
              "This Month": [moment().startOf("month"), moment().endOf("month")],
              "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")],
            },
            startDate: moment().subtract(29, "days"),
            endDate: moment(),
          },
          function (start, end) {
            $("#reportrange span").html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
          }
        );

      });
    </script>

   
  </body>
</html>
