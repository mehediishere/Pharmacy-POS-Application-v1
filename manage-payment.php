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
  <!-- Data Table CSS -->
	<?php include("part/data-table-css.php");?>
	<!-- Data Table CSS end -->
  <!-- All CSS -->
  <?php include("part/all-css.php");?>
  <!-- All CSS end -->
  <style>
    #prprprpr tbody tr.selected {
        color: white;
        background-color: rgb(164, 209, 250) !important;
    }
  </style>
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
      <section class="container-fluid">
        <div class="">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header py-2">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                    <h6 class="fs-17 font-weight-600 mb-0">Payments History</h6>
                    </div>
                    <div class="text-right">
                    <a href="add-payment.php" class="btn btn-info btn-sm mr-1"><i class="fas fa-plus mr-1"></i>New Payment</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <table id="prprprpr" class="table table-bordered display">
                    <thead>
                      <tr class="bg-info">
                        <th class="col-1 rmThText">SL</th>
                        <th class="col-2 adThText">User Details</th>
                        <th class="col-1 adThText">Payment Date</th>
                        <th class="col-1 adThText">Amount</th>
                        <th class="col-2 adThText">Payment Type</th>
                        <th class="col-2 adThText">Payment Method</th>
                        <th class="col-2 adThText">Note</th>
                        <th class="col-1 print_hidden rmThText">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $n = 0;
                        $sql = $conn->query("SELECT * FROM `p_payment` WHERE `store` = '$_SESSION[store_id]' ORDER BY `id` DESC");
                        while($row = mysqli_fetch_assoc($sql)){
                      ?>
                      <tr>
                        <td><?php echo ++$n; ?></td>
                        <td>
                          <div class="row">
                            <div class="col-12 col-md-3">Name:</div>
                            <div class="col-12 col-md-9"><em class="font-weight-bolder"><?php echo $row['name']; ?></em>,</div>

                            <div class="col-12 col-md-3">Type:</div>
                            <div class="col-12 col-md-9"><em class="font-weight-bolder"><?php echo $row['account_type']; ?></em>,</div>

                            <div class="col-12 col-md-3">Phone:</div>
                            <div class="col-12 col-md-9"><em class="font-weight-bolder"><?php echo $row['phone']; ?></em></div>
                          </div>
                        </td>
                        <td><?php echo $row['payment_date']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['payment_type']; ?></td>
                        <td><?php echo $row['payment_method']; ?></td>
                        <td><?php echo $row['details']; ?></td>
                        <td class="print_hidden">
                          <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit-payment<?php echo $row['id']; ?>"><i class="fa fa-edit"></i></a>
                          <a href="actions/remove.php?remove&code=<?php echo base64_encode($row['id']); ?>&wr=<?php echo base64_encode("p_payment"); ?>" class="btn btn-danger btn-sm delete" onclick="return confirm('Are you sure to delete?')"> <i class="fa fa-trash"></i> </a>
                        </td>
                      </tr>
                      <!-- Modal  start -->
                      <div class="modal fade" id="edit-payment<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title badge badge-info">Update</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form method="POST" action="actions/addPayment.php">
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                            <label>Wallet/Direct Transaction</label>
                                            <select class="form-control select2" name="transaction">
                                              <option value="<?php echo $row['transaction']; ?>" selected="selected"><?php echo $row['transaction']; ?></option>
                                              <option value="No">No</option>
                                              <option value="Yes">Yes</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="name">Payment Date:</label>
                                            <div class="input-group">
                                              <input type="date" class="form-control datetimepicker-input" name="payment_date" value="<?php echo $row['payment_date']; ?>">
                                              <input type="hidden" name="pyid" value="<?php echo $row['id']; ?>">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label>Payment Type:</label>
                                            <select class="form-control select2" name="payment_type">
                                              <option value="<?php echo $row['payment_type']; ?>" selected="selected"><?php echo $row['payment_type']; ?></option>
                                              <option>Cash Receivable</option>
                                              <option>Cash Pay</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label>Account Type:</label>
                                            <input type="text" class="form-control" value="<?php echo $row['account_type']; ?>" readonly>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label>Account Name:</label>
                                            <input type="text" class="form-control" value="<?php echo $row['name']; ?>" readonly>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="name">Amount:</label>
                                            <input type="text" class="form-control" id="amount" placeholder="Amount" name="amount" value="<?php echo $row['amount']; ?>" required>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label>Payment Method</label>
                                            <select class="form-control select2" name="payment_method">
                                              <option value="<?php echo $row['payment_method']; ?>" selected="selected"><?php echo $row['payment_method']; ?></option>
                                              <option>Bkash</option>
                                              <option>Bank</option>
                                              <option>Rocket</option>
                                              <option>Cash on delivery</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label>Expense Note:</label>
                                            <textarea class="form-control" rows="3" placeholder="Enter ..." name="details"><?php echo $row['details']; ?></textarea>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                              </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info" name="submitUP">Save changes</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <!-- Modal end -->
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

      $(".select2bs4").select2({ theme: "bootstrap4", });
    });
  </script>

    <!-- Data table -->
  <script>
    $(document).ready(function() {

    $('#prprprpr thead tr').clone(true).addClass('filters bg-light shadow-sm').removeClass('bg-info').appendTo('#prprprpr thead');

    $('#prprprpr').DataTable( {
        dom: 'Bfrtip',
        orderCellsTop: true,
        buttons: ["copy", "csv", "excel", "pdf",
        {
          extend: 'print',
          text: 'Print all',
          exportOptions: {
              modifier: {
                  selected: null
              }
          }
        },
        {
          extend: 'print',
          text: 'Print selected',
          exportOptions: {
              columns: [ 0, 1, 2, 3, 4, 5, 6 ]
          }
        }
        ],
        select: true,
        initComplete: function () {
          var api = this.api();
          // For each column
          api.columns( '.adThText' ).eq(0).each(function (colIdx) {
            // Set the header cell to contain the input element
            var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
            var title = $(cell).text();
            $(cell).html('<input type="text" class="form-control" placeholder="' + title + '" />');
            $('.filters th.rmThText').text('');

            // On every keypress in this input
            $(
                'input',
                $('.filters th').eq($(api.column(colIdx).header()).index())
            )
                .off('keyup change')
                .on('change', function (e) {
                    // Get the search value
                    $(this).attr('title', $(this).val());
                    var regexr = '({search})'; //$(this).parents('th').find('select').val();

                    var cursorPosition = this.selectionStart;
                    // Search the column for that value
                    api
                        .column(colIdx)
                        .search(
                            this.value != ''
                                ? regexr.replace('{search}', '(((' + this.value + ')))')
                                : '',
                            this.value != '',
                            this.value == ''
                        )
                        .draw();
                })
                .on('keyup', function (e) {
                    e.stopPropagation();

                    $(this).trigger('change');
                    $(this)
                        .focus()[0]
                        .setSelectionRange(cursorPosition, cursorPosition);
                });
          });
        },
    } );
} );
  </script>

</body>
</html>