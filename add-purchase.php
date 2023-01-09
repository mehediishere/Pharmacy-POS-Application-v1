<?php
	session_start();
	if(!isset($_SESSION['store_id'])) {
		header("location:login.php");
		exit();
	}else{
		include('config/db.php');
	}
  // include_once('actions/cart.php');
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
      <div class="col-12 col-md-5">
        <div class="card-body h-100 bg-white">
          <div class="row">
            <div class="col-6">
              <img src="dist/img/icon.png" alt="" class="img-fluid">
            </div>
            <div class="col-6 text-right">
              <a type="button" class="btn btn-outline-success proceed-order" data-toggle="modal" data-target="#paymentConfirm">Proceed Order <i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
          <!-- Modal Order Process Start  -->
          <div class="modal fade" id="paymentConfirm" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Payment Confirm</h5>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="actions/purchaseInvoice.php">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Total Items</label>
                                        <p class="form-control TotalQty" readonly> </p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Total Price</label>
                                        <p class="form-control TotalAmount" readonly> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-8">
                                        <label for="name">Enter Coupon Code</label>
                                        <input type="text" class="form-control couponcode" name="couponcodef">
                                    </div>
                                    <div class="col-4">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-success form-control apply-coupon">APPLY</button>
                                    </div>
                                    <label class="col-12  coupon-msg"> </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Discount (Tk)</label>
                                <input type="text" class="form-control after-coupon" name="discounted_tkf" value="0" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">Grand Total</label>
                                <input type="text" class="form-control grandtotal" name="grandtotalf" value="0" readonly>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label>Payment Method</label>
                                    <select name="paymentmethodf" class="form-control paymentmethodf">
                                        <option value="cash on delivery"><strong>Cash On Delivery</strong></option>
                                        <option value="bkash"><strong>Bkash</strong></option>
                                        <option value="rocket"><strong>Rocket</strong></option>
                                        <option value="nagad"><strong>Nagad</strong></option>
                                    </select>
                                </div>
                                <div class="col-12">
                                  <label for="name">Transection ID</label>
                                  <input type="text" class="form-control transId" name="transId" placeholder="Enter Transection ID" value="" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info" name="orderSubmit">Place Order</button>
                    </div>
                    </form>
                </div>
            </div>
          </div>
          <!-- Modal Order Process End  -->
          <div id="onisku">
          <table class="table table-bordered table-hover mt-3">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price (TK)</th>
                <th scope="col">Total (TK)</th>
              </tr>
            </thead>
            <tbody>
            <?php		
              if(isset($_SESSION["cart_item"])){
              $total_quantity = 0;
              $total_price = 0;
              foreach ($_SESSION["cart_item"] as $item){
                  $item_price = $item["quantity"]*$item["price"];
            ?>
              <tr data-widget="expandable-table" aria-expanded="false">
                <td>
                  <form action="actions/remove.php" method="POST">
                    <input type="hidden" name="code" value="<?php echo $item['code'] ?>">
                    <button type="submit" name="action2" class="remove text-danger border-0 bg-transparent" data-med_id="<?php echo $item['code'] ?>" data-toggle="tooltip" title="Remove"><i class="far fa-minus-square"></i></button>
                  </form>
                </td>
                <td><?php echo $item["name"]; ?></td>
                <td>
                  <input type="number" class="form-control field_item_qty" data-code="<?php echo $item['code'] ?>" min="0" max="999" value="<?php echo $item["quantity"]; ?>">
                </td>
                <td><?php echo $item["price"]; ?></td>
                <td><?php echo $item_price; ?></td>
              </tr>
                <?php
                  $total_quantity += $item["quantity"];
                  $total_price += ($item["price"]*$item["quantity"]);
                } }else{
              ?>
              <tr>
                <td colspan="5" class="text-secondary">&nbsp; <i class="fas fa-box-open"></i> Empty ShoppingCart</td>
              </tr>
              <?php } ?>
            </tbody>

            <tfoot>
              <tr>
                <td></td>
                <td class="text-right"><strong>Total</strong></td>
                <td><strong class="total-qty"><?php echo isset($total_quantity) ? $total_quantity : 0; ?></strong></td>
                <td class="text-right"><strong>Total</strong></td>
                <td><strong class="total-price"><?php echo isset($total_price) ? $total_price : 0; ?></strong></td>
              </tr>
            </tfoot>
          </table>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-7">
        <div class="card-body h-100 bg-white">
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
                    $cm = runQuery("SELECT * FROM `medicine` WHERE `store` = 'admin_62b'");
                    foreach($cm as $v){
                  ?>
                  <div class="col-md-4 col-sm-6 mt-3">
                      <div class="product-grid h-100">
                          <div class="product-image">
                              <a href="#" class="image">
                                  <img src="dist/img/product/bonsil.jpg">
                              </a>
                              <?php if($v['discount'] > '0'){ ?>
                              <span class="product-hot-label">5%</span>
                              <?php } ?>
                              <ul class="product-links">
                                  <li><a type="button" class="add-to-cart" data-code="<?php echo $v['id']; ?>" data-tip="Add to Cart"><i class="fa fa-shopping-bag"></i></a></li>
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
              <div class="my-3">
                <img src="dist/img/product/discount2.jpg" alt="" class="w-100">
              </div>
              <div class="row mt-3">
                  <div class="col-md-4 col-sm-6">
                      <div class="product-grid h-100">
                          <div class="product-image">
                              <a href="#" class="image">
                                  <img src="dist/img/product/bonsil.jpg">
                              </a>
                              <span class="product-hot-label">5%</span>
                              <ul class="product-links">
                                  <li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-bag"></i></a></li>
                                  <li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-heart"></i></a></li>
                                  <li><a href="#" data-tip="Compare"><i class="fa fa-random"></i></a></li>
                                  <li><a href="#" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                              </ul>
                          </div>
                          <div class="product-content">
                              <h3 class="title"><a href="#">Bonsil</a></h3>
                              <div class="price">$49.99</div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4 col-sm-6">
                      <div class="product-grid h-100">
                          <div class="product-image">
                              <a href="#" class="image">
                                  <img src="dist/img/product/pirfenex.jpg">
                              </a>
                              <ul class="product-links">
                                  <li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-bag"></i></a></li>
                                  <li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-heart"></i></a></li>
                                  <li><a href="#" data-tip="Compare"><i class="fa fa-random"></i></a></li>
                                  <li><a href="#" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                              </ul>
                          </div>
                          <div class="product-content">
                              <h3 class="title"><a href="#">Pirfenex</a></h3>
                              <div class="price">$45.99</div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4 col-sm-6">
                      <div class="product-grid h-100">
                          <div class="product-image">
                              <a href="#" class="image">
                                  <img src="dist/img/product/diabetes.jpg">
                              </a>
                              <span class="product-hot-label">5%</span>
                              <ul class="product-links">
                                  <li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-bag"></i></a></li>
                                  <li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-heart"></i></a></li>
                                  <li><a href="#" data-tip="Compare"><i class="fa fa-random"></i></a></li>
                                  <li><a href="#" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                              </ul>
                          </div>
                          <div class="product-content">
                              <h3 class="title"><a href="#">Celled</a></h3>
                              <div class="price">$45.99</div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row mt-3">
                  <div class="col-md-4 col-sm-6">
                      <div class="product-grid h-100">
                          <div class="product-image">
                              <a href="#" class="image">
                                  <img src="dist/img/product/bonsil.jpg">
                              </a>
                              <span class="product-hot-label">5%</span>
                              <ul class="product-links">
                                  <li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-bag"></i></a></li>
                                  <li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-heart"></i></a></li>
                                  <li><a href="#" data-tip="Compare"><i class="fa fa-random"></i></a></li>
                                  <li><a href="#" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                              </ul>
                          </div>
                          <div class="product-content">
                              <h3 class="title"><a href="#">Bonsil</a></h3>
                              <div class="price">$49.99</div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4 col-sm-6">
                      <div class="product-grid h-100">
                          <div class="product-image">
                              <a href="#" class="image">
                                  <img src="dist/img/product/pirfenex.jpg">
                              </a>
                              <ul class="product-links">
                                  <li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-bag"></i></a></li>
                                  <li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-heart"></i></a></li>
                                  <li><a href="#" data-tip="Compare"><i class="fa fa-random"></i></a></li>
                                  <li><a href="#" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                              </ul>
                          </div>
                          <div class="product-content">
                              <h3 class="title"><a href="#">Pirfenex</a></h3>
                              <div class="price">$45.99</div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4 col-sm-6">
                      <div class="product-grid h-100">
                          <div class="product-image">
                              <a href="#" class="image">
                                  <img src="dist/img/product/diabetes.jpg">
                              </a>
                              <ul class="product-links">
                                  <li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-bag"></i></a></li>
                                  <li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-heart"></i></a></li>
                                  <li><a href="#" data-tip="Compare"><i class="fa fa-random"></i></a></li>
                                  <li><a href="#" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                              </ul>
                          </div>
                          <div class="product-content">
                              <h3 class="title"><a href="#">Celled</a></h3>
                              <div class="price">$45.99</div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
            <!-- Company Product list end -->
          </div>
        </div>
      </div>
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

    <script>
      $(function() {
          //Initialize Select2 Elements
          $(".select2").select2();

          //Initialize Select2 Elements
          $(".select2bs4").select2({
              theme: "bootstrap4",
          });

          if($('.paymentmethodf').val() != "cash on delivery"){
            $('.transId').removeAttr('readonly');
          }

          $('.paymentmethodf').on('change', function(){
            var val = $(this).val();
            if(val == "cash on delivery"){
              $('.transId').attr('readonly',"");
            }else{
              $('.transId').removeAttr('readonly');
            }
          });
      });
    </script>

    <script>
      $(function() {
        $('.add-to-cart').on('click', function(){
          var code = $(this).data("code");
          var quantity = 1;
          var reeq = $.ajax({
            method: "GET",
            url: "actions/cart.php",
            data: {
              code: code,
              quantity: quantity,
              action: "add"
            }
          });
          reeq.done(function(msg) {
            $("#onisku").load(window.location.href + " #onisku");
            // totalPrice();
            // console.log(msg);
          });
        });

        $(document).on("change keyup", ".field_item_qty", function() {
          var qty = $(this).val();
          var code = $(this).data("code");
          
          // Quantity update
          var reeq = $.ajax({
            method: "GET",
            url: "actions/cart.php",
            data: {
              code: code,
              qty: qty,
              incQty: "incQty"
            }
          });
          reeq.done(function(data) {
            $("#onisku").load(window.location.href + " #onisku");
          });
        });
      });
    </script>
    <script>
      $(function(){
        $('.proceed-order').on( "click", function() {

          var totalPrice = $('.total-price').text();
          var totalQty = $('.total-qty').text();

          $('.TotalQty').text(totalQty);
          $('.TotalAmount').text(totalPrice);

          $('.grandtotal').val(totalPrice);

        });

        $('.couponcode').on( "keyup change", function() {

          $('.after-coupon').val(0);

        });

        // discount/coupun calculate
        $(".apply-coupon").on("click", function() {
          var coupon = $(".couponcode").val();
          var totalPrice = $('.total-price').text();

          // check coupon field whether empty
          if($.trim(coupon) != ""){
            var reeq = $.ajax({
                method: "GET",
                url: "ajaxreq/coupon.php",
                data: {
                  coupon: coupon,
                  amount: totalPrice,
                  applyCoupon: "applyCoupon"
                }
            });
            reeq.done(function (val) {
              var obj = JSON.parse(val);
              // console.log(val);
              if(obj['amount'] < totalPrice){
                  $('.coupon-msg').html('<span class="text-success"><i class="fas fa-check"></i> Coupon successfully redeemed.</span>');
              }else{
                  $('.coupon-msg').html('<span class="text-danger"><i class="fas fa-times"></i> The coupon code is not valid/expired.</span>');
              }
              $('.after-coupon').val(obj['discount']);
              $('.grandtotal').val(obj['amount']);

            });
          }
        });

      });
    </script>
  </body>
</html>
