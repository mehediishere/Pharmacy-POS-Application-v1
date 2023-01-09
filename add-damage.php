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
        <section class="content">
          <div class="container-fluid">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Add Damage Product</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <form method="POST" action="actions/damageProduct.php">
                      <div class="card-body">
                    
                    
                        <div class="form-group">
                            <label>Products</label>
                    
                            <select class="form-control select2" name="product" required>
                              <option value="" selected="selected">Select a Product</option>
                              <?php
                                $med_sql = $conn->query("SELECT * FROM `medicine` WHERE `store`='$_SESSION[store_id]'");
                                while($med_row = mysqli_fetch_assoc($med_sql)){
                                    ?>
                                      <option value="<?php echo $med_row['id'];?>|<?php echo $med_row['name'];?>|<?php echo $med_row['qty'];?>|<?php echo $med_row['price'];?>|<?php echo $med_row['manufacturerprice'];?>">
                                        <?php echo $med_row['name']." ( ".$med_row['qty']." )"; ?></option>
                                <?php } ?>
                           </select>
                      
                        
                        </div>
                    
                        <div class="form-group">
                          <label for="qty">Quantity</label>
                          <input type="text" class="form-control" id="qty" name="qty" required>
                        </div>
                      
                       
                        <div class="form-group">
                          <label>Note</label>
                          <textarea class="form-control" rows="3" placeholder="Enter ..." name="note"></textarea>
                        </div>
                      
                        
                      </div>
                      <!-- /.card-body -->
                
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                      </div>
                    </form>
                

                  
                 
                  </div>
               
                  </div>
             
              </div>
                <!-- /.row -->

          

                <!-- /.row -->
              </div>
           
            
            </div>
  
          </div>
   
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
      // DropzoneJS Demo Code End
    </script>
      
  </body>
</html>
