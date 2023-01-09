<?php
	session_start();
	if(!isset($_SESSION['store_id'])) {
        header("location:login.php");
		exit();
	}else{
        include('config/db.php');
	}
    // include('actions/cart-pos.php');
//   include('actions/cart.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | Pharmacy</title>

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Product -->
    <link rel="stylesheet" href="dist/css/product.css">
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
    <div class="row w-100">
      <!-- Invoice Part -->
      <div class="col-12 col-md-5">
        <div class="card-body h-100 bg-white">
          <div class="row">
            <div class="col-6">
              <img src="dist/img/icon-pos.png" alt="" class="img-fluid">
            </div>
            <div class="col-6 text-right">
              <a type="button" class="btn btn-outline-info proceed-invoice" data-toggle="modal" data-target="#paymentConfirm">Proceed Invoice <i class="fas fa-arrow-right"></i></a>
              <!-- Payment Modal -->
              <div class="modal fade" id="paymentConfirm" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <form method="post" action="actions/invoice.php"> <!--- Form A101 Start --->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Payment Confirm</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="name">Total Items</label>
                                            <input type="text" class="form-control totalQuantity" name="totalQtyf" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="name">Total Price</label>
                                            <input type="text" class="form-control totalPurchase" name="totalAmountf" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-8">
                                            <label for="name">Discount</label>
                                            <input type="number" min="0" max="99" class="form-control discountActivity" id="discount_med" name="discountf">
                                        </div>
                                        <div class="col-4">
                                            <label>In</label>
                                            <select name="discounttypef" class="form-control discountActivity" id="discount_type">
                                                <option value="%" selected><strong>%</strong>
                                                </option>
                                                <option value="flat"><strong>FLAT</strong>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">After Discount</label>
                                    <p class="form-control after-discount" readonly>0.00</p>
                                    <input type="hidden" id="after-discount" name="afterdiscountf" value="">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Payment Method</label>
                                        <select name="paymentmethodf" class="form-control">
                                            <option value="hand cash" selected><strong>Hand
                                                    Cash</strong></option>
                                            <option value="cash on delivery"><strong>Cash On
                                                    Delivery</strong></option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="name">Paid</label>
                                            <input type="text" class="form-control paid-amount"
                                                data-paid="" name="paidf" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- All due start -->
                                <div class="row">
                                  <!-- <div class="col-6">
                                    <div class="form-group">
                                      <label class="text-secondary">Previous Due</label>
                                      <input type="text" class="form-control" id="previous_due" step='0.01' name="previousduef" readonly>
                                    </div>
                                  </div> -->

                                  <div class="col-12">
                                    <div class="form-group">
                                      <label class="text-secondary">Current Due</label>
                                      <p class="form-control" id="current_due" step='0.01' readonly></p>
                                      <input type="hidden" class="current_due" name="currentduef" value="0.00" step='0.01'>
                                      <input type="hidden" class="wallet" name="walletf" value="0.00" step='0.01'>
                                      <input type="hidden" class="form-control" id="previous_due" step='0.01' name="previousduef" readonly>
                                    </div>
                                  </div>
                                </div>
                                <!-- All due end -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-info" name="orderSubmit">Order</button>
                        </div>
                    </div>
                  <!-- </form> -->
                </div>
              </div>
              <!-- Payment Modal end -->
            </div>
          </div>
          <div>
            <input type="text" name="title" class="form-control my-3" placeholder="Invoice Title">
            <input type="date" name="invoiceDatef" class="form-control my-3" value="<?php echo date('Y-m-d'); ?>">
            <div class="form-group">
              <select class="form-control select2 select2-custom-tags customertypef" name="customertypef" style="width: 100%;">
                <option value="Walk-in-Customer" selected="selected">Walk-In-Customer</option>
                <?php
                  $customer_sql = $conn->query("SELECT * FROM `customer` WHERE `store` = '$_SESSION[store_id]'");
                  while ($customer_row = mysqli_fetch_assoc($customer_sql)) {
                ?>
                <option value="<?php echo $customer_row['id']; ?>"> <?php echo $customer_row['name'] . " ( " . $customer_row['phone'] . " )"; ?> </option>
                <?php } ?>
              </select>
            </div>
            <div class="input-group">
              <!-- <input type="text" class="form-control" placeholder="Type medicine name here"> -->
              <select id="medicine-in" class="form-control select2 select2-custom-tags2" name="medicine">
                <option value="" selected="selected"></option>
                <?php
                  $medlist = runQuery("SELECT `id`, `name` FROM `p_medicine` WHERE `store` = '$_SESSION[store_id]'");
                  foreach($medlist as $medlist){
                ?>
                <option value="<?php echo $medlist['id']; ?>"><?php echo $medlist['name']; ?></option>
                <?php } ?>
              </select>
              <span class="input-group-append">
                <button type="button" name="add_med" class="btn btn-info btn-flat add_med" data-toggle="tooltip" data-placement="top" title="Add to List"><i class="fas fa-plus"></i></button>
              </span>
            </div>
            </form> <!--- Form A101 End --->
          </div>
          <div id="onisku">
          <table id="datatab" class="table table-bordered table-hover mt-3">
            <thead>
              <tr>
                <th scope="col" data-toggle="tooltip" title="Actions"><i class="fas fa-list"></i></th>
                <th scope="col">Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price (TK)</th>
                <th scope="col">Total (TK)</th>
              </tr>
            </thead>
            <tbody id="my_data">
            <?php
              if(isset($_SESSION["cart_pos_item"])){
                $total_price = 0;
                $total_quantity = 0;
                  foreach ($_SESSION["cart_pos_item"] as $item){
                    $item_price = $item["quantity"]*$item["price"];
              ?>
              <tr data-widget="expandable-table" aria-expanded="false">
                <td>
                  <form action="actions/remove.php" method="POST">
                    <input type="hidden" name="code" value="<?php echo $item['code'] ?>">
                    <button type="submit" name="action_pos2" onclick="totalPrice();" class="remove text-danger border-0 bg-transparent" data-med_id="<?php echo $item['code'] ?>" data-toggle="tooltip" title="Remove"><i class="far fa-minus-square"></i></button>
                  </form>
                </td>
                <td><?php echo $item["name"]; ?></td>
                <td><input type="number" min="0" max="999" class="form-control field_item_qty qty_field_<?php echo $item["code"]; ?>" data-code="<?php echo $item["code"]; ?>" value="<?php echo $item["quantity"]; ?>"></td>
                <td><input type="text" class="form-control field_item_price qty_field_<?php echo $item["code"]; ?> price_field_<?php echo $item["code"]; ?>" data-code="<?php echo $item["code"]; ?>" min="0" value="<?php echo $item["price"]; ?>"></td>
                <td><input type="text" class="form-control field_item_total_price inc_qty_<?php echo $item["code"]; ?>" min="0" value="<?php echo $item_price; ?>"></td>
              </tr>
              <?php } }else{ ?>
                <tr>
                  <td colspan="5" class="text-secondary">&nbsp; <i class="fas fa-box-open"></i> Empty ShoppingCart</td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td class="text-center"> <button type="button" class="text-info border-0" onclick="totalPrice();" data-toggle="tooltip" title="Calculate Price & Quantity"><i class="fas fa-calculator"></i></a></td>
                <td class="text-right"><strong>Total</strong></td>
                <td><strong id="totalQuantity"></strong></td>
                <td class="text-right"><strong>Total</strong></td>
                <td><strong id="totalPurchase"></strong></td>
              </tr>
            </tfoot>
          </table>
          </div>
        </div>
      </div>
      <!-- Invoice Part end -->
      <!-- Show product part -->
      <div class="col-12 col-md-7">
        <div class="card-body h-100 bg-white">
          <!-- <div class="row">
            <div class="col-3">
              <img src="dist/img/icon-pos.png" alt="" class="img-fluid">
            </div>
            <div class="col-6"></div>
            <div class="col-3 text-right">
              <a href="add-purchase.php"><i class="fa-lg text-info fas fa-cart-plus"></i><span class="badge badge-warning"><?php echo isset($_SESSION["cart_pos_item"]) ? count($_SESSION["cart_pos_item"]) : 0; ?></span></a>
            </div>
          </div> -->
          <div class="row">
            <!-- Company category  -->
            <div class="col-3">
              <label for="">CATEGORY</label>
              <a href="" class="btn btn-light btn-block">Mega Deal <span class="badge badge-warning">HOT</span></a>
              <div class="dropdown my-2">
                <a class="btn btn-light dropdown-toggle btn-block" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Medicine
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="#">Tablet</a>
                  <a class="dropdown-item" href="#">Capsul</a>
                  <a class="dropdown-item" href="#">Syrap</a>
                  <a class="dropdown-item" href="#">Drop</a>
                </div>
              </div>
              <a href="" class="btn btn-light btn-block">Baby & Mom Care</a>
              <a href="" class="btn btn-light btn-block">Nutrition & Drinks</a>
              <a href="" class="btn btn-light btn-block">Diabetes</a>
              <a href="" class="btn btn-light btn-block">Women Care</a>
            </div>
            <!-- Company category end -->

            <!-- Company Product list -->
            <div class="col-9" style="height: 100vh; overflow:auto;">
              <form action="">
                <input type="search" class="form-control" placeholder="Search...">
              </form>
              <div class="row">
                  <?php
                    $cm = runQuery("SELECT * FROM `p_medicine` WHERE `store` = '$_SESSION[store_id]'");
                    foreach($cm as $v){
                  ?>
                  <div class="col-md-4 col-sm-6 mt-3">
                      <div class="product-grid h-100">
                          <div class="product-image">
                              <a href="#" class="image">
                                  <img src="dist/img/product/bonsil.jpg">
                              </a>
                              <ul class="product-links">
                                  <li><a class="prd" type="button" data-action="add" data-code="<?php echo $v['id']; ?>" data-tip="Add to Cart"><i class="fa fa-shopping-bag"></i></a></li>
                                  <li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-heart"></i></a></li>
                                  <li><a href="#" data-tip="Compare"><i class="fa fa-random"></i></a></li>
                                  <li><a href="#" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                              </ul>
                          </div>
                          <div class="product-content">
                              <h3 class="title"><a href="#"><?php echo $v['name']; ?></a></h3>
                              <div class="price">$ <?php echo $v['price']; ?></div>
                          </div>
                      </div>
                  </div>
                  <?php } ?>
                </div>
            </div>
            <!-- Company Product list end -->
          </div>
        </div>
      </div>
      <!-- Show product part end -->
    </div>
  </div>

	<!-- Footer -->
	<?php include("part/footer.php");?>
	<!-- Footer End -->

	
	<!-- Alert -->
	<?php include("part/alert.php");?> 
	<!-- Alert end --> 


	<!-- All JS -->
	<?php include("part/all-js.php");?>
	<!-- All JS end -->
	<!-- Data Table JS -->
	<?php include("part/data-table-js.php");?>
	<!-- Data Table JS end -->

    <!-- select2 input field -->
    <script>
      $(function() {
          //Initialize Select2 Elements
          $(".select2").select2();

          //Initialize Select2 Elements
          $(".select2bs4").select2({
              theme: "bootstrap4",
          });

          $(".select2-custom-tags").select2({
            // tags: true
          });
          $(".select2-custom-tags2").select2({
            // tags: true,
            placeholder: "Select/Type medicine name..."
          });

          // reset medicine select input field
          $("#medicine-in").val("").trigger( "change" );
      });
    </script>

    <!-- Total price function -->
    <script>
      totalPrice();

      function totalPrice(){
        // Total purchase
        var i = 0;
        $(".field_item_total_price").each(function() {
            i = i + parseFloat($(this).val());
        });
        $("#totalPurchase").text(i);

        // Total Quantity
        var k = 0;
        $(".field_item_qty").each(function() {
            k = k + parseFloat($(this).val());
        });
        $("#totalQuantity").text(k);

        // console.log(k);
      }
    </script>

    <!-- Ajax -->
    <script>
      $(function() {
        // Product search option
        $(".select2-custom-tags2").on("change", function(e) {
            e.preventDefault();
            e.stopPropagation();
            var val = $(this).val();
            var quantity = 1;
            // console.log(val);
            var reeq = $.ajax({
              method: "GET",
              url: "actions/cart-pos.php",
              data: {
                code: val,
                quantity: quantity,
                action_pos: "add"
              }
            });
            reeq.done(function(msg) {
              $("#onisku").load(window.location.href + " #onisku");
              totalPrice();
            });

            setTimeout(function(){ totalPrice(); },100);
        });

        $(document).on("click", ".prd", function(e) {
            e.preventDefault();
            e.stopPropagation();
            var code = $(this).data("code");
            var quantity = 1;
            // console.log(code);
            var reeq = $.ajax({
              method: "GET",
              url: "actions/cart-pos.php",
              data: {
                code: code,
                quantity: quantity,
                action_pos: "add"
              }
            });
            reeq.done(function(msg) {
              $("#onisku").load(window.location.href + " #onisku");
              totalPrice();
            });

            setTimeout(function(){ totalPrice(); },100);
        });

      });
    </script>

    <!-- On input field change in table -->
    <script>
      $(function() {

        // On change qty field
        $(document).on("change keyup", ".field_item_qty", function() {
          var v = $(this).val();
          var code = $(this).data("code");
          var price = $(".price_field_"+code).val();
          var vv = parseFloat(price*v);
          $(".inc_qty_"+code).val(vv);
          totalPrice();
          
          // Quantity update
          var reeq = $.ajax({
              method: "GET",
              url: "actions/cart-pos.php",
              data: {
                code: code,
                qty: v,
                incQty: "incQty"
              }
          });
        });

        // On change item price field
        $(document).on("change keyup", ".field_item_price", function() {
          var v = $(this).val();
          var code = $(this).data("code");
          var qty = $(".qty_field_"+code).val();
          var vv = parseFloat(v*qty);
          $(".inc_qty_"+code).val(vv);
          totalPrice();
          // console.log(code + " "+qty+" "+v);
        });

        // On change total item price field
        $(document).on("change keyup", ".field_item_total_price", function() {
          // var v = $(this).val();
          // console.log(v);
          totalPrice();
        });
      });
    </script>

    <!-- Proceed invoice, discount -->
    <script>
      $(function() { 
        // proceed invoice
          var v = $('#totalQuantity').text();
          var v2 = $('#totalPurchase').text();
        
        $('.proceed-invoice').on( "click", function() {
          totalPrice();
          var customer = $(".customertypef").val();

          v = $('#totalQuantity').text();
          v2 = $('#totalPurchase').text();

          $('.totalQuantity').val(v);
          $('.totalPurchase').val(v2);
          $("#after-discount").val(v2);

          // Check customer due
          var reeq = $.ajax({
                method: "GET",
                url: "actions/payment_process.php",
                data: {
                    customer: customer,
                    payBtn: "payBtn"
                }
            });
            reeq.done(function(data) {
                // $("#previous_due").text(data);
                $("#previous_due").val(data);
                // console.log(data);
            });
        });

        // discount calculate
        $(".discountActivity").on("keyup change", function() {
          var discount = $("#discount_med").val();
          var type = $("#discount_type").val();
          v2 = $('#totalPurchase').text();
          var amount = v2;
          var reeq = $.ajax({
            method: "GET",
            url: "actions/payment_process.php",
            data: {
              discount: discount,
              amount: amount,
              type: type,
              applyDiscount: "applyDiscount"
            }
          });
          reeq.done(function(msg) {
              var obj = JSON.parse(msg);
              $(".after-discount").text(obj['amount']);
              $("#after-discount").val(obj['amount']);
          });
        });

        // paid status
        $(".paid-amount").on("keyup change", function() {
          var customer = $(".customertypef").val();
          var payable = $("#after-discount").val();
          var paid = $(this).val();
          var due = $('#previous_due').text();
          var reeq = $.ajax({
            method: "GET",
            url: "actions/payment_process.php",
            data: {
              customer: customer,
              payable: payable,
              paid: paid,
              due: due,
              paidStatus: "paidStatus"
            }
          });
          reeq.done(function(data) {
              console.log(data);
              var obj = JSON.parse(data);
              $('#current_due').text(obj['currentDue']);
              $('.current_due').val(obj['currentDue']);
              $('.wallet').val(obj['wallet']);
          });
        });
      });
    </script>

  </body>
</html>
