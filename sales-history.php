<?php
		session_start();
		if(!isset($_SESSION['store_id'])){
			header("location:login.php");
			exit();
		}elseif(!isset($_GET['id']) || empty($_GET['id']) || ctype_space($_GET['id']) || $_GET['id'] == "Walk-in-Customer"){
      echo "<script>window.history.back();</script>";
      exit();
    }else{
			include('config/db.php');
      $client = $_GET['id'];
      $check = mysqli_num_rows($conn->query("SELECT `client` FROM `p_invoice_summary` WHERE `client` = '$client'"));
      if($check <= 0){
        echo "<script>window.history.back();</script>";
        exit();
      }
      $name = mysqli_fetch_assoc($conn->query("SELECT `name` FROM `p_customer` WHERE `id` = '$client'"));
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
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  <h3 class="card-title">Sales History of <strong class="badge badge-light" style="font-size: 20px;"> <?php echo $name['name']; ?></strong></h3>
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
                          $sql = $conn->query("SELECT * FROM `p_invoice_summary` WHERE `store` = '$_SESSION[store_id]' AND `client` = '$client' ORDER BY `id` DESC");
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
                              <button class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-cogs"></i></button>

                              <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 30px; left: 0px; will-change: top, left;">
                                <a class="dropdown-item" href="sales-invoice.php?id=<?php echo $row['invoice']; ?>"> <i class="fa fa-print text-cyan"></i> Print </a> 
                                <a class="dropdown-item" href="return-action.php?invoice=<?php echo $row['invoice'];?>&&customer=<?php echo $customer;?>"> <i class="fa fa-backward text-success"></i> Return </a> 
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

   
  </body>
</html>
