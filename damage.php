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

    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          <!-- <div class="row">
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <select class="form-control select2" id="medicine_name">
                    <option value="" selected="selected">Select a Product </option>
                    <?php
                      $med_sql = $conn->query("SELECT * FROM `p_medicine` WHERE `store`='$_SESSION[store_id]'");
                      while($med_row = mysqli_fetch_assoc($med_sql)){
                          ?>
                            <option value="<?php echo $med_row['name'];?>"><?php echo $med_row['name']." ( ".$med_row['qty']." )"; ?></option>
                      <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div> -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Damage Products</h3>
                </div>
                <div class="card-body table-section">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="card">
                        <div class="card-body">
                          <select class="form-control select2" id="medicine_name">
                            <option value="" selected="selected">Select a Product </option>
                            <?php
                              $med_sql = $conn->query("SELECT * FROM `p_medicine` WHERE `store`='$_SESSION[store_id]'");
                              while($med_row = mysqli_fetch_assoc($med_sql)){
                                  ?>
                                    <option value="<?php echo $med_row['name'];?>"><?php echo $med_row['name']." ( ".$med_row['qty']." )"; ?></option>
                              <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <table id="damageProductTable" class="table table-bordered table-hover">
                    <thead>
                      <tr class="bg-info">
                        <th>SL</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Quantity <br><small>(Before Damage)</small></th>
                        <th>Damage Quantity</th>
                        <th>Cost</th>
                        <th>Note</th>
                        <th class="print_hidden">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="tbody-section">
                        <?php
                        $n = 0;
                          $sql = $conn->query("SELECT * FROM `p_damage_product` WHERE `store` = '$_SESSION[store_id]'");
                          while($row = mysqli_fetch_assoc($sql)){
                        ?>
                      <tr>
                        <td><?php echo ++$n; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['product']; ?></td>
                        <td><?php echo $row['total_qty']; ?></td>
                        <td><?php echo $row['damage_qty']; ?></td>
                        <td><?php echo $row['cost']; ?></td>
                        <td><?php echo $row['note']; ?></td>
                        <td class="print_hidden text-center">
                          <div class="btn-group">
                            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-cogs"></i> Manage</button>
                            <div class="dropdown-menu" x-placement="bottom-start">
                              <a class="dropdown-item" href=""> <i class="fa fa-pencil-square-o text-warning"></i> Edit </a>
                              <a href="actions/remove.php?remove&code=<?php echo base64_encode($row['id']); ?>&wr=<?php echo base64_encode("p_damage_product"); ?>" class="text-danger dropdown-item btn btn-danger btn-sm delete" onclick="return confirm('Are you sure to delete?')"> <i class="fa fa-trash"></i> Delete</a>
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
      //Initialize Select2 Elements
      $(".select2").select2();

      //Initialize Select2 Elements
      $(".select2bs4").select2({
        theme: "bootstrap4",
      });
    });
  </script>

  <script>
    $(function() { 
      $("#medicine_name").on( "change", function() {
        var name = $(this).val();
        $.ajax({
          url: "ajaxreq/damageList.php",
          type: "POST",
          data: 'request=' + name,
          success:function(data){
            $(".tbody-section").html(data);
          }
        });
      });
    });
  </script>

  <script>
    $(function () {
      $("#damageProductTable").DataTable({
          dom: 'lrtip',
          responsive: true,
          lengthChange: false,
          autoWidth: false,
          aaSorting: [],
          order: [[1, 'desc']],
          // buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
        });
    });
  </script>

</body>
</html>