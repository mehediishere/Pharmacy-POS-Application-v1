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

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include("part/navbar.php");?>
    <!-- Navbar end -->

    <!-- Sidebar -->
    <?php include("part/sidebar.php");?>
    <!--  Sidebar end -->

    <div class="content-wrapper">

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Products Stock</h3>
                </div>
                <div class="card-body">
                  <table id="stockTable" class="table table-bordered table-hover">
                    <thead>
                      <tr class="bg-info">
                        <th> </th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Cost</th>
                        <th>Price</th>
                        <th>Total Sells</th>
                        <th>Available Stock</th>
                        <th>Sell Value</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $n = 0;
                      // $sql = $conn->query("SELECT `name` FROM `medicine` WHERE `store`='$_SESSION[store_id]'");
                      // $sql = $conn->query("SELECT a.img, a.name, a.manufacturerprice, a.price, a.qty, (a.qty*a.price) as sellvalue, b.category FROM medicine_category as b 
                      // inner join medicine as a on (b.id = a.category and a.store='$_SESSION[store_id]')");
                      // while($row = mysqli_fetch_assoc($sql)){
                      //   $totalSells = mysqli_fetch_assoc($conn->query("SELECT sum(qty) as total FROM `invoice` where `product` = '$row[name]' GROUP BY 'qty'"));
                      $sql = $conn->query("SELECT a.img, a.name, c.name AS cat, a.cost, a.price, a.qty FROM `p_medicine` AS a INNER JOIN `p_medicine_category` AS c ON (a.category = c.id AND a.store = '$_SESSION[store_id]')");
                      while($row = mysqli_fetch_assoc($sql)){
                        $totalSells = mysqli_fetch_assoc($conn->query("SELECT sum(qty) as total FROM `p_invoice` where `product` = '$row[name]' GROUP BY 'qty'"));
                      ?>
                      <tr>
                        <td style="padding:5px" class="text-center">
                          <img src="dist/img/product/<?php echo $row['img']; ?>" width="50" alt="Image">
                        </td>
                        <td> <?php echo $row['name']; ?></td>
                        <td> <?php echo $row['cat']; ?></td>
                        <td> <?php echo $row['cost']; ?> </td>
                        <td> <?php echo $row['price']; ?> </td>
                        <td> <?php echo isset($totalSells['total']) ? $totalSells['total'] : 0; ?> </td>
                        <td> <?php echo $row['qty']; ?> </td>
                        <td> <?php echo $row['price']*$row['qty']; ?> </td>
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


    <!-- Alert -->
    <?php include("part/alert.php");?>
    <!-- Alert end -->
  </div>

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
      $("#stockTable")
        .DataTable({
          responsive: true,
          lengthChange: false,
          autoWidth: false,
          // aaSorting: [],
          order: [[5, 'desc']],
          buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
        })
        .buttons()
        .container()
        .appendTo("#stockTable_wrapper .col-md-6:eq(0)");
    });
  </script>

</body>

</html>