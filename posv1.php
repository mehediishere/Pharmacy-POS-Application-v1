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
    <div class="content-wrapper mt-3">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">POS Manage</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Pos Manage</li>
              </ol>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->

            <div class="col-md-5">
              <div class="card card-info">
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal">
                  <div class="card-body">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                      </div>
                      <input type="text" class="form-control" id="barcode" placeholder="Scan Barcode" name="barcode" />
                    </div>

                    <div class="form-group">
                      <input type="text" class="form-control" id="name" placeholder="Start to write product name"
                        name="name" />
                    </div>
                    <div class="form-group">
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate">
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>



                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-8">
                          <select class="form-control select2">
                            <option selected="selected">Walk-in-Customer</option>
                            <option>Alaska</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                          </select>
                        </div>

                        <div class="col-md-4">

                          <button type="button" class="btn btn-default" data-toggle="modal"
                            data-target="#modal-default">ADD </button>

                        </div>
                      </div>


                      <div class="modal fade" id="modal-default">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Add Customer</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form>
                                <div class="card-body">
                                  <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter Name"
                                      name="name">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                      placeholder="Enter email" name="email">
                                  </div>

                                  <div class="form-group">
                                    <label for="address"> Address</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                      placeholder="Enter address" name="address">
                                  </div>
                                  <div class="form-group">
                                    <label for="number"> Phone</label>
                                    <input type="number" class="form-control" id="phone" placeholder="Enter Number"
                                      name="number">
                                  </div>
                                  <div class="form-group">
                                    <label for="receivable"> Opening Receivable</label>
                                    <input type="text" class="form-control" id="receivable"
                                      placeholder="Enter Receivable" name="receivable">
                                  </div>
                                  <div class="form-group">
                                    <label for="payable"> Opening Payable</label>
                                    <input type="text" class="form-control" id="payable" placeholder="Enter payable"
                                      name="payable">
                                  </div>



                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                  <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                              </form>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                    </div>
                    <div class="form-group">
                      <table id="example2" class="table table-bordered table-hover">
                        <thead>
                          <tr>

                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Sub T</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>

                            <td>Mahamud</td>
                            <td>1</td>
                            <td>12.50</td>
                            <td>12.50</td>
                            <td><i class="fas fa-trash"></i></td>
                          </tr>

                        </tbody>
                        <tfoot>
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Total</th>
                            <th>1200</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>


              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div style="display: flex;justify-content: center;">
                  <button type="submit" class="btn btn-success ">Payable</button>
                </div>
              </div>
              <!-- /.card-footer -->
              </form>
            </div>
            <div class="col-md-7">
              <div class="card card-info">
                <!-- /.card-header -->

                <div class="row">
                  <div class="col-md-4">
                    <div class="p-3">
                      <h4>Category</h4>
                      <div class="mt-5">
                        <button type="button" class="btn btn-block btn-info">Document</button>
                        <button type="button" class="btn btn-block btn-info">Electronics</button>
                        <button type="button" class="btn btn-block btn-info">Fashion</button>
                        <button type="button" class="btn btn-block btn-info">Hardware</button>
                        <button type="button" class="btn btn-block btn-info">House</button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="p-3">
                      <h4>Product List</h4>
                      <hr>
                      <div class="mt-5 d-flex">
                        <div class="row">
                          <div class="col-md-6 mt-sm-2">
                            <input type="text" class="form-control" id="exampleInputEmail1">
                          </div>
                          <div class="col-md-3 mt-sm-2">
                            <button type="button" class="btn btn-block btn-success">Search</button>
                          </div>
                          <div class="col-md-3 mt-sm-2">
                            <button type="button" class="btn btn-block btn-info">Reset</button>
                          </div>
                        </div>


                      </div>
                    </div>
                    <div class="row p-3">
                      <div class="col-md-3" style="border: 1px solid gray;">
                        <img src="" alt="">
                        <p>Air Condition - 000007</p>
                        <p>96000.00 Tk
                        </p>
                        <p> Stock : 0</p>
                      </div>
                      <div class="col-md-3" style="border: 1px solid gray;">
                        <img src="" alt="">
                        <p>Air Condition - 000007</p>
                        <p>96000.00 Tk
                        </p>
                        <p> Stock : 0</p>
                      </div>
                      <div class="col-md-3" style="border: 1px solid gray;">
                        <img src="" alt="">
                        <p>Air Condition - 000007</p>
                        <p>96000.00 Tk
                        </p>
                        <p> Stock : 0</p>
                      </div>
                      <div class="col-md-3" style="border: 1px solid gray;">
                        <img src="" alt="">
                        <p>Air Condition - 000007</p>
                        <p>96000.00 Tk
                        </p>
                        <p> Stock : 0</p>
                      </div>
                      <div class="col-md-3" style="border: 1px solid gray;">
                        <img src="" alt="">
                        <p>Air Condition - 000007</p>
                        <p>96000.00 Tk
                        </p>
                        <p> Stock : 0</p>
                      </div>
                      <div class="col-md-3" style="border: 1px solid gray;">
                        <img src="" alt="">
                        <p>Air Condition - 000007</p>
                        <p>96000.00 Tk
                        </p>
                        <p> Stock : 0</p>
                      </div>
                      <div class="col-md-3" style="border: 1px solid gray;">
                        <img src="" alt="">
                        <p>Air Condition - 000007</p>
                        <p>96000.00 Tk
                        </p>
                        <p> Stock : 0</p>
                      </div>
                      <div class="col-md-3" style="border: 1px solid gray;">
                        <img src="" alt="">
                        <p>Air Condition - 000007</p>
                        <p>96000.00 Tk
                        </p>
                        <p> Stock : 0</p>
                      </div>
                      <div class="col-md-3" style="border: 1px solid gray;">
                        <img src="" alt="">
                        <p>Air Condition - 000007</p>
                        <p>96000.00 Tk
                        </p>
                        <p> Stock : 0</p>
                      </div>
                      <div class="col-md-3" style="border: 1px solid gray;">
                        <img src="" alt="">
                        <p>Air Condition - 000007</p>
                        <p>96000.00 Tk
                        </p>
                        <p> Stock : 0</p>
                      </div>
                      <div class="col-md-3" style="border: 1px solid gray;">
                        <img src="" alt="">
                        <p>Air Condition - 000007</p>
                        <p>96000.00 Tk
                        </p>
                        <p> Stock : 0</p>
                      </div>
                    </div>
                  </div>
                </div>

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

  <!-- jQuery -->
  <!-- Alert -->
    <?php include("part/alert.php");?> 
	<!-- Alert end --> 
  
  <!-- All JS -->
	  <?php include("part/all-js.php");?>
	<!-- All JS end -->

  <!-- InputMask -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
  <!-- date-range-picker -->
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Bootstrap Switch -->

  <!-- Page specific script -->
  <script>
    $(function () {
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
            "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf(
              "month")],
          },
          startDate: moment().subtract(29, "days"),
          endDate: moment(),
        },
        function (start, end) {
          $("#reportrange span").html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
        }
      );
    });
  </script>
</body>

</html>
