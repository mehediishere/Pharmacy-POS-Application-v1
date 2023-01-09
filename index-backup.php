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
              <img src="dist/img/icon-pos.png" alt="" class="img-fluid">
            </div>
            <div class="col-6 text-right">
              <a href="" class="btn btn-outline-info">Proceed <i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
          <div>
            <input type="text" name="title" class="form-control my-3" placeholder="Invoice Title">
            <input type="date" name="invoice-date" class="form-control my-3" value="<?php echo date('Y-m-d'); ?>">
            <div class="form-group">
              <select class="form-control select2" style="width: 100%;">
                <option selected="selected">Walk-In-Customer</option>
                <option>Alaska</option>
                <option>California</option>
                <option>Delaware</option>
                <option>Tennessee</option>
                <option>Texas</option>
                <option>Washington</option>
              </select>
            </div>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Type medicine name here">
              <span class="input-group-append">
                <button type="button" class="btn btn-info btn-flat" data-toggle="tooltip" data-placement="top" title="Add to List"><i class="fas fa-plus"></i></button>
              </span>
            </div>
          </div>
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
              <tr data-widget="expandable-table" aria-expanded="false">
                <td><a href="" class="text-danger"><i class="far fa-minus-square"></i></a></td>
                <td>Baxidal Baxidal Baxidal Baxidal Baxidal</td>
                <td>
                  <div class="row">
                    <div class="col-8">
                      <div class="row no-gutters">
                        <div class="col-3">
                          <button class="form-control"><i class="fas fa-plus"></i></button>
                        </div>
                        <div class="col-6">
                          <input type="text" class="form-control" value="10">
                        </div>
                        <div class="col-3">
                          <button class="form-control"><i class="fas fa-minus"></i></button>
                        </div>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <select class="form-control select2" style="width: 100%;">
                          <option selected="selected">PC</option>
                          <option>Box</option>
                          <option>Leaf</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </td>
                <td>3</td>
                <td>30</td>
              </tr>
            </tbody>
            <tfoot>
              <tr> 
                <td class="text-right" colspan="4"><strong>Total</strong></td>
                <td><strong>30</strong></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="col-12 col-md-7">
        <div class="card-body h-100 bg-white">
          <div class="row">
            <div class="col-3">
              <img src="dist/img/icon.png" alt="" class="img-fluid">
            </div>
            <div class="col-6"></div>
            <div class="col-3 text-right">
              <a href=""><i class="fa-lg text-info fas fa-cart-plus"></i><span class="badge badge-warning">0</span></a>
            </div>
          </div>
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
    });
    </script>
  </body>
</html>
