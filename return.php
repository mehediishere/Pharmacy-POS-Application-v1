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
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Return List</h3>
                  </div>
            
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover">
                      <thead>
                        <tr class="bg-info">
                          <th>SL</th>
                          <th>Invoice</th>
                          <th>Customer</th>
                          <th>Returned</th>
                          <th>Discount</th>
                          <th>Returnable</th>
                          <th>Returned Amount</th>
                          <th>Date</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                          $n = 0;
                          $sql = $conn->query("SELECT * FROM `p_return_summary` WHERE `store` = '$_SESSION[store_id]' ORDER BY `id` DESC");
                          while($row = mysqli_fetch_assoc($sql)){
                        ?>
                        <tr>
                          <td><?php echo ++$n; ?></td>
                          <td><?php echo $row['invoice']; ?></td>
                          <td><?php echo $row['customer']; ?></td>
                          <td>
                            <?php
                              $returnedProduct = $conn->query("SELECT * FROM `p_return_product` WHERE `store` = '$_SESSION[store_id]' AND `invoice` = '$row[invoice]'");
                              while($returnedProductRow = mysqli_fetch_assoc($returnedProduct)){
                                echo $returnedProductRow['product']." ( ".$returnedProductRow['return_qty']." )"."<br>";
                              }
                            ?>
                          </td>
                          <td><?php echo $row['discount']; ?></td>
                          <td><?php echo $row['returnable']; ?></td>
                          <td><?php echo $row['returned']; ?></td>
                          <td><?php echo $row['date']; ?></td>
                          <td class="text-center">
                            <div class="btn-group">
                              <button class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-cogs"></i>
                              </button>
                              <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 30px; left: 0px; will-change: top, left;">
                              
                                <a class="dropdown-item" href="return-history.php?id=<?php echo $row['customer_id'] ?>"> <i class="fa fa-history text-secondary"></i> Return History </a> 
                                
                                <a href="actions/remove.php?return&code=<?php echo base64_encode($row['invoice']); ?>" class="dropdown-item delete" onclick="return confirm('Are you sure to delete?')"> <i class="fa fa-trash text-danger"></i> Delete</a>
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
	
	<!-- Data Table JS -->
	<?php include("part/data-table-js.php");?>
	<!-- Data Table JS end -->
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
