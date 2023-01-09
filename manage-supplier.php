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
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header py-2">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                    <h6 class="fs-17 font-weight-600 mb-0">Supplier</h6>
                    </div>
                    <div class="text-right">
                    <a href="add-supplier.php" class="btn btn-info btn-sm mr-1"><i class="fas fa-plus mr-1"></i>New Supplier</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <tr class="bg-info">
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Paid</th>
                        <th>Purchase Due</th>
                        <th>Payable</th>
                        <th>Wallet</th>
                        <th>Total Due</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $n = 0;
                        $sql = $conn->query("SELECT * FROM `p_supplier` WHERE `store` = '$_SESSION[store_id]'");
                        while($row = mysqli_fetch_assoc($sql)){
                      ?>
                      <tr>
                        <th scope="row"><?php echo ++$n; ?></th>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td> --- </td>
                        <td> --- </td>
                        <td><?php echo $row['payable']; ?></td>
                        <td><?php echo $row['receivable']; ?></td>
                        <td class="font-weight-bold"> 0.00 Tk </td>
                        <td>
                            <a class="btn btn-info btn-sm disabled" data-toggle="modal" data-target="#edit-customer<?php echo $row['id']; ?>"><i class="fa fa-edit"></i></a>
                            <a href="actions/remove.php?remove&code=<?php echo base64_encode($row['id']); ?>&wr=<?php echo base64_encode("p_supplier"); ?>" class="btn btn-danger btn-sm delete" onclick="return confirm('Are you sure to delete?')"> <i class="fa fa-trash"></i> </a>
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