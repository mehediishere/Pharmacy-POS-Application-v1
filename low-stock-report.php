<?php
session_start();
if (!isset($_SESSION['store_id'])) {
  header("location:login.php");
  exit();
} else {
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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Low Stock List</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Stock</li>
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
                <div class="card-header">
                  <h3 class="card-title">Products</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example11" class="table table-bordered table-hover">
                    <thead>
                      <tr class="bg-info">
                        <!-- <th>#</th> -->
                        <th>Image</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Cost</th>
                        <th>Price</th>
                        <th>Total Sells</th>
                        <!-- <th>Purchases</th> -->
                        <th>Available Stock</th>
                        <th>Sell Value</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $n = 0;
                      // $sql = $conn->query("SELECT `name` FROM `medicine` WHERE `store`='$_SESSION[store_id]'");
                      $sql = $conn->query("SELECT a.img, a.name, a.manufacturerprice, a.price, a.qty, (a.qty*a.price) as sellvalue, b.category FROM medicine_category as b 
                      inner join medicine as a on (b.id = a.category and a.store='$_SESSION[store_id]')");
                      while($row = mysqli_fetch_assoc($sql)){
                        $sql2 = mysqli_fetch_assoc($conn->query("SELECT sum(qty) as total FROM `invoice` where `product` = '$row[name]' GROUP BY 'qty'"));
                      ?>
                      <tr>
                        <!-- <th scope="row"><?php echo ++$n; ?></th> -->
                        <td style="padding:5px" class="text-center">
                          <img src="dist/img/product/<?php echo $row['img']; ?>" width="50" alt="Image">
                        </td>
                        <td> <?php echo $row['name']; ?></td>
                        <td> <?php echo $row['category']; ?></td>
                        <td> <?php echo $row['manufacturerprice']; ?> </td>
                        <td> <?php echo $row['price']; ?> </td>
                        <td> <?php echo isset($sql2['total']) ? $sql2['total'] : 0; ?> </td>
                        <td><strong> <?php echo $row['qty']; ?> </strong></td>
                        <td> <?php echo $row['sellvalue']; ?> </td>
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
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Footer -->
    <?php include("part/footer.php");?>
    <!-- Footer End -->


    <!-- Alert -->
    <?php include("part/alert.php");?>
    <!-- Alert end -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

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

      $('#example11').DataTable({
          order: [[6, 'asc']],
          dom: 'Bfrtip',
          buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print', 'colvis' ]
          // "footerCallback": function (row, data, start, end, display) {                
          //   //Get data here 
          //   // console.log(data);
          //   var sellAmount = 0;
          //   var purchaseAmount = 0;
          //   var expense = 0;
          //   var returned = 0;
          //   for (var i = 0; i < data.length; i++) {
          //       sellAmount += parseFloat(data[i][1]);
          //       purchaseAmount += parseFloat(data[i][2]);
          //       expense += parseFloat(data[i][3]);
          //       returned += parseFloat(data[i][4]);
          //   }
          //   // console.log(totalAmount);
          //   $("#sellAmount").text(sellAmount);
          //   $("#purchaseAmount").text(purchaseAmount);
          //   $("#expense").text(expense);
          //   $("#returned").text(returned);
          // }
      });

    });
  </script>
</body>

</html>