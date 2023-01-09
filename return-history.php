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
    $check = mysqli_num_rows($conn->query("SELECT `customer_id` FROM `p_return_summary` WHERE `customer_id` = '$client'"));
    if($check <= 0){
      echo "<script>window.history.back();</script>";
      exit();
    }
    $name = mysqli_fetch_assoc($conn->query("SELECT `customer` FROM `p_return_summary` WHERE `customer_id` = '$client'"));
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
                    <h3 class="card-title">Return History of <strong class="badge badge-light" style="font-size: 20px;"> <?php echo $name['customer']; ?></strong></h3>
                  </div>
            
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover">
                      <thead>
                        <tr class="bg-info">
                          <th>SL</th>
                          <th>Invoice</th>
                          <th>Returned</th>
                          <th>Discount</th>
                          <th>Returnable</th>
                          <th>Returned Amount</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                          $n = 0;
                          $sql = $conn->query("SELECT * FROM `p_return_summary` WHERE `store` = '$_SESSION[store_id]' AND `customer_id` = '$client' ORDER BY `id` DESC");
                          while($row = mysqli_fetch_assoc($sql)){
                        ?>
                        <tr>
                          <td><?php echo ++$n; ?></td>
                          <td><?php echo $row['invoice']; ?></td>
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
