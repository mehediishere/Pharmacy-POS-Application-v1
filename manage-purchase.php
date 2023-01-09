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

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Order</h3>
                  </div>
                  <div class="card-body">
                    <table id="orderTable" class="table table-bordered table-hover">
                      <thead>
                        <tr class="bg-info">
                          <!-- <th class="rmThText">SL</th> -->
                          <th class="adThText">Order</th>
                          <th class="adThText">Items</th>
                          <th class="adThText">Date</th>
                          <th class="adThText">Total Price</th>
                          <th class="adThText">Payment Status</th>
                          <th class="adThText">Order Status</th>
                          <th class="rmThText">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $n = 0;
                          $sql = $conn->query("SELECT * FROM `p_purchase_summary` WHERE `store` = '$_SESSION[store_id]' ORDER BY `id` DESC");
                          while($row = mysqli_fetch_assoc($sql)){
                            ?>
                        <tr>
                          <!-- <td><?php echo ++$n; ?></td> -->
                          <td>#<?php echo $row['invoice']; ?></td>
                          <td>
                            <ul>
                              <?php
                                $purchaseCost = 0;
                                $medicine = $conn->query("SELECT * FROM `p_purchase` WHERE `invoice` = $row[invoice]");
                                while($medicineName = mysqli_fetch_assoc($medicine)){
                              ?>
                              <li>
                                <?php 
                                  echo $medicineName['product']." (".$medicineName['qty'].")"; 
                                ?>
                              </li>
                              <?php } ?>
                            </ul>
                          </td>
                          <td><?php echo $row['date']; ?></td>
                          <td><?php echo $row['total_price']-$row['discounted']; ?></td>
                          <td>
                            <?php 
                              if($row['paid_status'] == "paid"){
                                $badge = "badge badge-success";
                              }elseif($row['paid_status'] == "on review"){
                                $badge = "badge badge-purple";
                              }elseif($row['paid_status'] == "cancel"){
                                $badge = "badge badge-danger";
                              }else{
                                $badge = "badge badge-warning";
                              }
                            ?>
                            <p class="<?php echo $badge; ?> text-uppercase"><?php echo $row['paid_status']; ?></p>
                          </td>
                          <td>
                            <?php 
                              if($row['status'] == "received"){
                                $badge = "badge badge-success";
                              }elseif($row['status'] == "confirm"){
                                $badge = "badge badge-primary";
                              }elseif($row['status'] == "on the way"){
                                $badge = "badge badge-purple";
                              }elseif($row['status'] == "cancel"){
                                $badge = "badge badge-danger";
                              }else{
                                $badge = "badge badge-warning";
                              }
                            ?>
                            <p class="<?php echo $badge; ?> text-uppercase"><?php echo $row['status']; ?></p>
                          </td>
                          <td class="text-center">
                            <div class="btn-group">
                              <button class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-cogs"></i> Manage</button>
                              <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 30px; left: 0px; will-change: top, left;">
                                <a class="dropdown-item" href="purchase-invoice.php?id=<?php echo $row['invoice']; ?>"> <i class="fa fa-print text-cyan"></i>&nbsp;&nbsp; Print Invoice </a> 
                                <?php if($row['paid_status'] == "unpaid" && $row['status'] != "cancel"){ ?>
                                  <button type="button" class="form-control border-0" data-toggle="modal" data-target="#orderModal" data-whatever="<?php echo $row['invoice']; ?>"><i class="fa fa-credit-card text-success"></i>&nbsp;&nbsp; Add Payment</button>
                                  <?php } ?>
                                  <?php if($row['paid_status'] == "unpaid"){ ?>
                                    <a class="dropdown-item" href="actions/purchaseInvoice.php?cancel&invoice=<?php echo $row['invoice']; ?>"> <i class="fa fa-minus-square text-danger"></i>&nbsp;&nbsp; Cancel Order </a>
                                  <?php } ?>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <!-- Modal start -->
                    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <form action="actions/purchaseInvoice.php" method="post">
                          <div class="modal-header">
                            <h5 class="modal-title">Add Payment - Invoice #</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div>
                              <label>Payment Date</label>
                              <input type="date" class="form-control" name="date" required readonly value="<?php echo date("Y-m-d"); ?>">
                              <label class="mt-3">Transection With</label>
                              <select name="trandectionWith" class="form-control" id="trans" required>
                                <option value="Bkash" selected>Bkash</option>
                                <option value="Rocket">Rocket</option>
                                <option value="Nagad">Nagad</option>
                                <option value="Bank">Bank</option>
                              </select>
                              <input type="text" name="transectionInfo" class="form-control mt-1" placeholder="Transection ID / Bank account number" required>
                              <textarea name="transectionDetails" class="form-control mt-1 transTxt" placeholder="Enter Transection ID and other details " rows="3"></textarea>
                              <label class="mt-3">Amount</label>
                              <input type="number" name="amount" class="form-control" placeholder="0.00" required>
                              <input type="hidden" name="invoice" class="form-control ini">
                            </div>
                          </div>
                          <div class="modal-footer">
                          <small class="text-danger"><strong>Note: </strong> You will be able to submit payment information one time. Carefully enter these information. After submission for any change/query <a href=""> contact us</a> or call at <a href="">+8801958-586986</a></small>
                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info" name="update" onclick="return confirm('Are you sure to submit?')">Submit Payment</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- Modal end  -->
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
        
        $('.transTxt').attr('placeholder', "Enter Transection details. \n Ex. Phone (send from): ")
        $('#trans').on('change', function(){
          var val = $(this).val();
          if(val == "Bank"){
            $('.transTxt').attr('placeholder', "Enter Bank details. \n Ex. Bank Name: ")
          }else{
            $('.transTxt').attr('placeholder', "Enter Transection details. \n Ex. Phone (send from): ")
          }
        });
      });
    </script>

  <!-- Data table -->
  <script>
    $(document).ready(function() {

    $('#orderTable thead tr').clone(true).addClass('filters bg-light shadow-sm').removeClass('bg-info').appendTo('#orderTable thead');

    $('#orderTable').DataTable( {
        dom: 'rtip',
        orderCellsTop: true,
        // buttons: [],
        select: false,
        aaSorting: [],
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

<script>
  // Bootstrap dynamic modal
    $('#orderModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var recipient = button.data('whatever');
      var modal = $(this);
      modal.find('.modal-title').html('<strong>Invoice #' + recipient+'</strong>')
      modal.find('.ini').val(recipient);
    });
  </script>

   
  </body>
</html>
