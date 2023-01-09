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
          <!-- <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Advanced Form</li>
              </ol>
            </div>
          </div> -->
        </div>
        <!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- SELECT2 EXAMPLE -->
          <div class="card card-default">
            <div class="card-header py-2">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                <h6 class="fs-17 font-weight-600 mb-0">New Product</h6>
                </div>
                <div class="text-right">
                <a href="manage-products.php" class="btn btn-info btn-sm mr-1"><i class="fas fa-align-justify mr-1"></i>Manage Product</a>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-8">
                  <form action="actions/addProduct.php" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                      <div class="form-group">
                          <label>Brand</label>
                          <div class="row">
                            <div class="col-md-6">
                              <select class="form-control select2" name="brand_product">
                              <option value="" selected="selected">Select Type</option>
                                <?php
                                  $sql = $conn->query("SELECT * FROM `manufacturer` WHERE `store` = '$_SESSION[store_id]'");
                                  while($row = mysqli_fetch_assoc($sql)){
                                ?>
                                <option class="text-capitalize" value="<?php echo $row['id']; ?>"><?php echo ucfirst($row['name']); ?></option>
                                <?php
                                  }
                                ?>
                              </select>
                            </div>
                            <div class="col-md-6">
                            <a href="add-brand.php" class="btn btn-info">Add Brand</a>
                            </div>
                          </div>
                      </div>
                      <div class="form-group">
                        <label>Category</label>
                        <div class="row">
                          <div class="col-md-6">
                            <select class="form-control select2" name="category_product">
                              <option value="" selected="selected">Select Type</option>
                              <?php
                                $sql = $conn->query("SELECT * FROM `medicine_category` WHERE `store` = '$_SESSION[store_id]'");
                                while($row = mysqli_fetch_assoc($sql)){
                              ?>
                              <option class="text-capitalize" value="<?php echo $row['id']; ?>"><?php echo ucfirst($row['category']); ?></option>
                              <?php
                                }
                              ?>
                            </select>
                          </div>
                          <div class="col-md-6">
                            <a href="add-category.php" class="btn btn-info">Add Category</a>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Product Name" name="product_name">
                      </div>
                      <div class="form-group">
                        <label for="name">Product Code</label>
                        <input type="text" class="form-control" id="code" placeholder="Enter Product Code" name="product_code">
                      </div>
                      <div class="form-group">
                        <label for="stock">Opening Stock</label>
                        <input type="text" class="form-control" id="stock" name="new_stock">
                      </div>
                      <div class="form-group">
                        <label for="product-price">Price</label>
                        <input type="text" class="form-control" id="price" placeholder="Enter Product Price" name="product_price">
                      </div>
                      <div class="form-group">
                        <label for="product-price">Cost</label>
                        <input type="text" class="form-control" id="cost" placeholder="Enter Product Cost" name="cost">
                      </div>
                      <div class="form-group">
                        <label>Product Details</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="details"></textarea>
                      </div>
                      <div class="form-group">
                        <label>Expire Date</label>
                          <div class="input-group date" id="reservationdate"
                              data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" name="expiredate" data-target="#reservationdate">
                              <div class="input-group-append" data-target="#reservationdate"
                                  data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Product Image</label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="uploadfile" oninput="img_preview.src=window.URL.createObjectURL(this.files[0])">
                            <label class="custom-file-label">Choose file</label>
                            <!-- <img id="img_preview" class="img-thambnail mt-3" src="" alt="medicine image" height="200px" width="200px;" > -->
                          </div>
                      </div>

                    </div>
                    <!-- /.card-body -->

                  </div>
                  <div class="col-md-2">
                    <img id="img_preview" class="img-thambnail mt-3" src="" alt="product image" height="200px" width="200px;" >
                  </div>
                </div>
                <div class="pl-3">
                  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
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
  <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script>
    $(function() {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Initialize Select2 Elements
        $(".select2bs4").select2({
            theme: "bootstrap4",
        });

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {
            placeholder: "dd/mm/yyyy"
        });
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {
            placeholder: "mm/dd/yyyy"
        });
        //Money Euro
        $("[data-mask]").inputmask();

        //Date picker
        $("#reservationdate").datetimepicker({
            format: "L",
        });

        //Date and time picker
        $("#reservationdatetime").datetimepicker({
            icons: {
                time: "far fa-clock"
            }
        });

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
        $("#daterange-btn").daterangepicker({
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [moment().startOf("month"), moment().endOf("month")],
                    "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1,
                        "month").endOf(
                        "month")],
                },
                startDate: moment().subtract(29, "days"),
                endDate: moment(),
            },
            function(start, end) {
                $("#reportrange span").html(start.format("MMMM D, YYYY") + " - " + end.format(
                    "MMMM D, YYYY"));
            }
        );
    });
    </script>
</body>

</html>