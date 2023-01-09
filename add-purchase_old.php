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

    <!-- All CSS -->
    <?php include("part/all-css.php"); ?>
    <!-- All CSS end -->
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("part/navbar.php"); ?>
        <!-- Navbar end -->

        <!-- Sidebar -->
        <?php include("part/sidebar.php"); ?>
        <!--  Sidebar end -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper mt-3">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Purchase</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Pharmacy.com</a></li>
                                <li class="breadcrumb-item active">Products</li>
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
                        <div class="col-md-5">
                            <div class="card card-info">
                                <!-- /.card-header -->
                                <!-- form start -->
                                <!-- <form class="form-horizontal"> -->
                                <form method="post" action="actions/purchaseInvoice.php" class="form-horizontal">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <table id="example2" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Name</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="cart-block">
                                                    <?php
                                            $pp2 = $conn->query("SELECT * FROM `cart` WHERE `user`='admin_62b' and `ip_add`='" . $ip . "'  and `type`='Order' ");
                                            while ($res = mysqli_fetch_assoc($pp2)) {
                                                $pro = mysqli_fetch_assoc($conn->query("SELECT * FROM `medicine` WHERE `id`='" . $res['p_id'] . "' and `store`='" . $res['user'] . "'"));
                                            ?>
                                                    <tr>
                                                        <td><a href="actions/purchaseInvoice.php?remove=<?php echo $res['serial']; ?>"><i class="fas fa-trash text-danger"></i></a></td>
                                                        <td><?php echo $pro['name']; ?></td>
                                                        <td>
                                                            <input type="number" value="<?php echo $res['qty']; ?>"
                                                                min="0" class="updateQty form-control"
                                                                data-serial="<?php echo $res['serial']; ?>"
                                                                data-user="<?php echo $res['user']; ?>" />
                                                        </td>
                                                        <td><?php echo $res['price']; ?></td>
                                                        <td class="id<?php echo $res['serial']; ?>">
                                                            <?php echo $res['totalprice']; ?></td>
                                                    </tr>
                                                    <?php } ?>

                                                </tbody>
                                                <tfoot>
                                                    <?php
                                                        $amount_final = mysqli_fetch_assoc($conn->query("SELECT SUM(totalprice) as total, SUM(qty) as qty FROM `cart` 
                                                        WHERE `user`='admin_62b' and `ip_add`='" . $ip . "'  and `type`='Order'  "));
                                                    ?>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Total</th>
                                                        <th class="TotalAmount"
                                                            data-totalamount="<?php echo  $amount_final['total']; ?>">
                                                            <?php echo  $amount_final['total']; ?>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="form-group">
                                            <textarea name="notef" id="" class="form-control" rows="3" placeholder="Note"></textarea>
                                        </div>
                                    </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div style="display: flex;justify-content: center;">
                                    <button type="button" class="btn btn-info proceedPayment" data-toggle="modal"
                                        data-target="#paymentConfirm">Payment</button>
                                    <!-- Modal -->
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
                                                    <!-- <form method="post" action="actions/invoice.php"> -->
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="name">Total Items</label>
                                                                    <p class="form-control TotalQty" readonly>
                                                                        <?php echo  $amount_final['qty']; ?></p>
                                                                    <input type="hidden" class="TotalQty"
                                                                        name="totalQtyf"
                                                                        value="<?php echo  $amount_final['qty']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="name">Total Price</label>
                                                                    <p class="form-control TotalAmount" readonly
                                                                        data-totalamount="<?php echo  $amount_final['total']; ?>">
                                                                        <?php echo  $amount_final['total']; ?></p>
                                                                    <input type="hidden" class="TotalAmount"
                                                                        name="totalAmountf"
                                                                        value="<?php echo  $amount_final['total']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <label for="name">Enter Coupon Code</label>
                                                                    <input type="text" class="form-control" id="apply-coupon-val" name="couponcodef">
                                                                </div>
                                                                <div class="col-4">
                                                                    <label>&nbsp;</label>
                                                                    <button type="button" class="btn btn-success form-control apply-coupon">APPLY</button>
                                                                </div>
                                                                <label class="col-12  coupon-msg">
                                                                    <!-- <span class="text-success">Coupon successfully redeemed.</span> -->
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name">Discount (Tk)</label>
                                                            <p class="form-control after-coupon" readonly
                                                                data-afterDiscount="0">0.00</p>
                                                            <input type="hidden" class="after-coupon"
                                                                name="discounted_tkf" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name">Grand Total</label>
                                                            <p class="form-control grandtotal" readonly data-afterDiscount="0">0.00</p>
                                                            <input type="hidden" class="form-control grandtotal" name="grandtotalf" value="" readonly>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label>Payment Method</label>
                                                                <select name="paymentmethodf" class="form-control">
                                                                    <option value="cash on delivery"><strong>Cash On
                                                                            Delivery</strong></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-info"
                                                        name="orderSubmit">Place Order</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-footer -->
                            </form>
                        </div>
                        <div class="col-md-7">
                            <div class="card card-info">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="p-3">
                                            <h4>Category</h4>
                                            <div class="mt-5">
                                                <?php
                                        $Category = $conn->query("SELECT * FROM `medicine_category` where `store`='" . $_SESSION['store_id'] . "' and `chk`='0'");
                                        while ($res = mysqli_fetch_assoc($Category)) {
                                        ?>
                                                <button type="button" class="btn btn-block btn-info onclick"
                                                    data-serial=<?php echo $res['id']; ?>
                                                    data-user="<?php echo $res['store']; ?>"><?php echo $res['category']; ?></button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="p-3">
                                            <h4>Product List</h4>
                                            <hr>
                                            <div class="mt-5 d-flex" style=" margin-top: 0px !important;">
                                                <div class="row" style="width: 100%;">
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control SearchBox"
                                                            id="exampleInputEmail1" placeholder="Search Box"
                                                            data-user="<?php echo $_SESSION['store_id']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-3 Hiden">
                                            <?php
                                    $Allproduct = $conn->query("SELECT * FROM `medicine` where `store`='admin_62b'");
                                    while ($res = mysqli_fetch_assoc($Allproduct)) {
                                    ?>
                                            <div class="col-md-4">
                                                <a href="javascript:void(0)" class="add-to-cart"
                                                    data-user="<?php echo $res['store']; ?>"
                                                    data-serial="<?php echo $res["id"]; ?>" data-type="Order">
                                                    <div class="card">
                                                        <img class="card-img-top"
                                                            src="../Admin/dist/img/medicine/<?php echo $res["img"]; ?>"
                                                            alt="Card image cap"
                                                            style="height: 150px;object-fit: contain;">
                                                        <div class="card-body">
                                                            <h5 class="card-title">
                                                                <p style="margin-bottom: 0px;">
                                                                    <?php echo $res['name']; ?>
                                                                </p>
                                                            </h5>
                                                            <p class="card-text" style="margin-bottom: 0px;">
                                                                <?php echo $res['price']; ?> Tk
                                                            </p>
                                                            <p class="card-text" style="margin-bottom: 0px;"> Stock :
                                                                <?php echo $res['qty']; ?>
                                                            </p>

                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <div class="row p-3 Show"> </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php include("part/footer.php"); ?>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Product search option
            $(".SearchBox").on("keyup", function (e) {
                e.preventDefault();
                e.stopPropagation();
                var val = $(this).val();
                var user = $(this).attr("data-user");
                var reeq = $.ajax({
                    method: "GET",
                    url: "ActionOrder/SearchProduct.php",
                    data: {
                        val: val,
                        user: user,
                        SearchBox: "SearchBox"
                    }
                });
                reeq.done(function (msg) {
                    $(".Hiden").hide();
                    $(".Show").html(msg);

                });
            });
            // onClick category and show category wish product
            $(".onclick").on("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                var val = $(this).attr("data-serial");
                var user = $(this).attr("data-user");
                var reeq = $.ajax({
                    method: "GET",
                    url: "ActionOrder/SearchProduct.php",
                    data: {
                        val: val,
                        user: user,
                        CategoryWishProduct: "CategoryWishProduct"
                    }
                });
                reeq.done(function (msg) {
                    // console.log(msg);
                    $(".Hiden").hide();
                    $(".Show").html(msg);
                });
            });
        });

        $(document).ready(function () {
            // product order
            var cart = function (user, type) {
                var req = $.ajax({
                    method: "GET",
                    url: "ActionOrder/cart_block1.php",
                    data: {
                        user: user,
                        type: type,
                        fgdf: "jhgfjsd"
                    }
                });
                req.done(function (msg) {
                    $(".cart-block").html(msg);
                });
            }

            $(document).on("click", ".add-to-cart", function (e) {
                e.preventDefault();
                e.stopPropagation();
                var ser = $(this).attr("data-serial");
                var user = $(this).attr("data-user");
                var type = $(this).attr("data-type");
                var reeq = $.ajax({
                    method: "GET",
                    url: "ActionOrder/add_cart.php",
                    data: {
                        ser: ser,
                        user: user,
                        type: type,
                        dhh: "ggf"
                    }
                });
                reeq.done(function (msg) {
                    var obj = JSON.parse(msg);
                    $(".TotalAmount").text(obj["Amount"]);
                    $(".TotalAmount").val(obj["Amount"]);
                    $(".TotalAmount").attr("data-totalamount", obj['Amount']);
                    $(".TotalQty").text(obj["qtyT"]);
                    $(".TotalQty").val(obj["qtyT"]);
                    // $(".after-discount").text(obj['Amount']);
                    // $("#after-discount").val(obj['Amount']);
                    cart(user, type);
                    // if (obj['Chk'] == '0') {
                    //     $(".id" + ser).prop("disabled", true);
                    // }
                    // $(".qtyId" + ser).val(obj["Qty"]);
                    // $(".qtyId" + ser).attr("data-serial", obj["Serial"]);

                });
            });

        });
    </script>
    <script>
        $(document).ready(function () {
            // Update Qty
            $(document).on("change", ".updateQty", function (e) {
                e.preventDefault();
                e.stopPropagation();
                var value = $(this).val();
                var serial = $(this).attr("data-serial");
                var user = $(this).attr("data-user");
                var reeq = $.ajax({
                    method: "GET",
                    url: "ActionOrder/updateQty.php",
                    data: {
                        value: value,
                        serial: serial,
                        user: user,
                        updateQty: "updateQty"
                    }
                });
                reeq.done(function (msg) {
                    // console.log(msg);
                    var obj = JSON.parse(msg);
                    $(".id" + serial).text(obj['amount']);
                    $(".TotalAmount").text(obj['totalAmount']);
                    $(".TotalAmount").val(obj['totalAmount']);
                    $(".TotalAmount").attr("data-totalamount", obj['totalAmount']);
                    $(".TotalQty").text(obj['qtyT']);
                    $(".TotalQty").val(obj['qtyT']);
                    // $(".after-discount").text(obj['totalAmount']);
                    // $("#after-discount").val(obj['totalAmount']);
                });
            });
        });
    </script>
    <?php include("part/alert.php"); ?>
    <?php include("part/all-js.php"); ?>
    <script>
        $(function () {
            $(".select2").select2();

            $(".select2bs4").select2({
                theme: "bootstrap4",
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // click on payment btn
            $(".proceedPayment").on("click", function () {
                var tt = $('.TotalAmount').attr('data-totalamount');
                $('.grandtotal').val(tt);
                $('.grandtotal').text(tt);
                $("#apply-coupon-val").val("");
                // console.log(tt);
            });
            
            $(".apply-coupon").on("click", function(){
                var tt = $('.TotalAmount').attr('data-totalamount');
                var ac = $("#apply-coupon-val").val();
                if($.trim(ac) != ""){
                    var reeq = $.ajax({
                        method: "POST",
                        url: "ajaxreq/coupon.php",
                        data: {
                            amount: tt,
                            coupon: ac,
                            couponDiscount: "couponDiscount"
                        }
                    });
                    reeq.done(function (val) {
                        var obj = JSON.parse(val);
                        console.log(val);
                        if(obj['amount'] < tt){
                            $('.coupon-msg').html('<span class="text-success"><i class="fas fa-check"></i> Coupon successfully redeemed.</span>');
                            $('.after-coupon').text(obj['discount']);
                            $('.after-coupon').val(obj['discount']);
                            
                            $('.grandtotal').text(obj['amount']);
                            $('.grandtotal').val(obj['amount']);
                        }else{
                            $('.coupon-msg').html('<span class="text-danger"><i class="fas fa-times"></i> The coupon code is not valid/expired.</span>');
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>