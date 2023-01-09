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
  <body class="hold-transition sidebar-mini">
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
                  <div class="card-header">
                    <h3 class="card-title">Products</h3>
                  </div>
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover">
                      <thead>
                        <tr class="bg-info">
                          <th>Code</th>
                          <th>Image</th>
                          <th>Name</th>
                          <th>Category</th>
                          <th>Brand</th>
                          <th>From Abroad</th>
                          <th>Cost</th>
                          <th>Price</th>
                          <th>Total Qunatity</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $sql = $conn->query("SELECT a.id, a.img, a.name, c.name AS cat, b.name AS bar, a.abroad, a.cost, a.price, a.qty FROM `p_medicine` AS a
                          inner JOIN p_medicine_category AS c ON (a.category = c.id and a.store = 1) LEFT JOIN p_brand AS b ON a.brand = b.id");
                          while($row = mysqli_fetch_assoc($sql)){
                        ?>
                        <tr>
                          <td class="text-capitalize"><?php echo $row['id']; ?></td>
                          <td class="text-capitalize"><img src="dist/img/product/<?php echo $row['img']; ?>" alt="<?php echo $row['name']; ?>" style="max-width: 50px;"></td>
                          <td class="text-capitalize"><?php echo $row['name']; ?></td>
                          <td class="text-capitalize"><?php echo $row['cat']; ?></td>
                          <td class="text-capitalize"><?php echo $row['bar']; ?></td>
                          <td class="text-capitalize"><?php echo $row['abroad']; ?></td>
                          <td class="text-capitalize"><?php echo $row['cost']; ?></td>
                          <td class="text-capitalize"><?php echo $row['price']; ?></td>
                          <td class="text-capitalize"><?php echo $row['qty']; ?></td>
                          <td class="text-center">
                            <div class="btn-group">
                              <button class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-cogs"> Manage</i> </button>
                              <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 30px; left: 0px; will-change: top, left;">
                                <a class="dropdown-item" href=""> <i class="fa fa-edit"></i> Edit </a>
                                <a class="dropdown-item" href=""> <i class="fa fa-history"></i> Sell History </a> 
                                <a class="dropdown-item delete" href=""> <i class="fa fa-trash"></i> Delete </a>
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
  </body>
</html>
