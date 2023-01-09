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

    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css" />
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />
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
                        <div class="col-md-5">
                            <div class="card card-info">
                                <!-- /.card-header -->
                                <!-- form start -->
                                <!-- <form class="form-horizontal"> -->
                                <form method="post" action="actions/invoice.php" class="form-horizontal">
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="barcode"
                                                placeholder="Scan Barcode" name="barcode" />
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control"
                                                placeholder="Invoice title / walk-in-customer name" name="title" />
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="date" class="form-control" name="invoiceDatef"
                                                    value="<?= date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <select class="form-control select2 customertypef"
                                                        name="customertypef">
                                                        <option value="Walk-in-Customer" selected="selected">
                                                            Walk-in-Customer</option>
                                                        <?php
                                                        $customer_sql = $conn->query("SELECT * FROM `customer` WHERE `store` = '$_SESSION[store_id]'");
                                                        while ($customer_row = mysqli_fetch_assoc($customer_sql)) {
                                                        ?>
                                                        <option value="<?php echo $customer_row['id']; ?>">
                                                            <?php echo $customer_row['name'] . " ( " . $customer_row['phone'] . " )"; ?>
                                                        </option>
                                                        <?php } ?>
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
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- <form> -->
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="name">Name</label>
                                                                    <input type="text" class="form-control" id="name"
                                                                        placeholder="Enter Name" name="name">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="exampleInputEmail1">Email
                                                                        address</label>
                                                                    <input type="email" class="form-control"
                                                                        id="exampleInputEmail1"
                                                                        placeholder="Enter email" name="email">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="address"> Address</label>
                                                                    <input type="text" class="form-control"
                                                                        id="exampleInputEmail1"
                                                                        placeholder="Enter address" name="address">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="number"> Phone</label>
                                                                    <input type="number" class="form-control" id="phone"
                                                                        placeholder="Enter Number" name="number">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="receivable"> Opening
                                                                        Receivable</label>
                                                                    <input type="text" class="form-control"
                                                                        id="receivable" placeholder="Enter Receivable"
                                                                        name="receivable">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="payable"> Opening Payable</label>
                                                                    <input type="text" class="form-control" id="payable"
                                                                        placeholder="Enter payable" name="payable">
                                                                </div>



                                                            </div>
                                                            <!-- /.card-body -->

                                                            <div class="card-footer">
                                                                <button type="submit"
                                                                    class="btn btn-primary">Submit</button>
                                                            </div>
                                                            <!-- </form> -->
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save
                                                                changes</button>
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
                                                        <th></th>
                                                        <th>Name</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="cart-block">
                                                    <?php
                                                    $pp2 = $conn->query("SELECT * FROM `cart` WHERE `user`='" . $_SESSION['store_id'] . "' and `ip_add`='" . $ip . "' and `type`='Sales'");

                                                    while ($res = mysqli_fetch_assoc($pp2)) {
                                                        $pro = mysqli_fetch_assoc($conn->query("SELECT * FROM `medicine` WHERE `id`='" . $res['p_id'] . "' and `store`='" . $res['user'] . "'"));
                                                    ?>
                                                    <tr>

                                                        <td><a
                                                                href="actions/invoice.php?remove=<?php echo $res['serial']; ?>&type=Sales"><i
                                                                    class="fas fa-trash text-danger"></i></a></td>
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
                                                    $amount_final = mysqli_fetch_assoc($conn->query("SELECT SUM(totalprice) as total, SUM(qty) as qty FROM `cart` WHERE `user`='" .  $_SESSION['store_id'] . "' and `ip_add`='" . $ip . "'  and `type`='Sales' "));
                                                    ?>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Total</th>
                                                        <th class="TotalAmount"
                                                            data-totalamount="<?php echo  $amount_final['total']; ?>">
                                                            <?php echo  $amount_final['total']; ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
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
                                                                    <label for="name">Discount</label>
                                                                    <input type="number" min="0" max="99"
                                                                        class="form-control discountActivity"
                                                                        id="discount_med" name="discountf">
                                                                </div>
                                                                <div class="col-4">
                                                                    <label>In</label>
                                                                    <select name="discounttypef"
                                                                        class="form-control discountActivity"
                                                                        id="discount_type">
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
                                                            <p class="form-control after-discount" readonly
                                                                data-afterDiscount="0">0.00</p>
                                                            <input type="hidden" id="after-discount"
                                                                name="afterdiscountf" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name">Previous Due</label>
                                                            <p class="form-control" id="previous_due" step='0.01'
                                                                readonly>0.00</p>
                                                            <input type="hidden" name="previousduef" id="previousduef"
                                                                value="0.00">
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
                                                        <div class="form-group">
                                                            <label for="name">Current Due</label>
                                                            <p class="form-control" id="current_due" step='0.01'
                                                                readonly></p>
                                                            <input type="hidden" class="current_due" name="currentduef"
                                                                value="0.00">
                                                            <input type="hidden" class="wallet" name="walletf"
                                                                value="0.00">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-info"
                                                        name="orderSubmit">Order</button>
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
                                            $Allproduct = $conn->query("SELECT * FROM `medicine` where `store`='" . $_SESSION['store_id'] . "'");
                                            while ($res = mysqli_fetch_assoc($Allproduct)) {
                                            ?>
                                            <div class="col-md-4">
                                                <a href="javascript:void(0)" class="add-to-cart"
                                                    data-user="<?php echo $res['store']; ?>"
                                                    data-serial="<?php echo $res["id"]; ?>" data-type="Sales">
                                                    <div class="card">
                                                        <img class="card-img-top"
                                                            src="dist/img/product/<?php echo $res['img']; ?>"
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
    $(document).ready(function() {
        // Product search option
        $(".SearchBox").on("keyup", function(e) {
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
            reeq.done(function(msg) {
                $(".Hiden").hide();
                $(".Show").html(msg);

            });
        });
        // onClick category and show category wish product
        $(".onclick").on("click", function(e) {
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
            reeq.done(function(msg) {
                // console.log(msg);
                $(".Hiden").hide();
                $(".Show").html(msg);
            });
        });
    });

    $(document).ready(function() {
        // product order
        var cart = function(user, type) {
            var req = $.ajax({
                method: "GET",
                url: "ActionOrder/cart_block.php",
                data: {
                    user: user,
                    type: type,
                    fgdf: "jhgfjsd"
                }
            });
            req.done(function(msg) {
                $(".cart-block").html(msg);
            });
        }

        $(document).on("click", ".add-to-cart", function(e) {
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
            reeq.done(function(msg) {
                var obj = JSON.parse(msg);
                $(".TotalAmount").text(obj["Amount"]);
                $(".TotalAmount").val(obj["Amount"]);
                $(".TotalAmount").attr("data-totalamount", obj['Amount']);
                $(".TotalQty").text(obj["qtyT"]);
                $(".TotalQty").val(obj["qtyT"]);
                $(".after-discount").text(obj['Amount']);
                $("#after-discount").val(obj['Amount']);
                cart(user, type);
                if (obj['Chk'] == '0') {
                    $(".id" + ser).prop("disabled", true);
                }
                $(".qtyId" + ser).val(obj["Qty"]);
                $(".qtyId" + ser).attr("data-serial", obj["Serial"]);

            });
        });

    });
    </script>



    <script>
    $(document).ready(function() {
        // Update Qty
        $(document).on("change", ".updateQty", function(e) {
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
            reeq.done(function(msg) {
                // console.log(msg);
                var obj = JSON.parse(msg);
                $(".id" + serial).text(obj['amount']);
                $(".TotalAmount").text(obj['totalAmount']);
                $(".TotalAmount").val(obj['totalAmount']);
                $(".TotalAmount").attr("data-totalamount", obj['totalAmount']);
                $(".TotalQty").text(obj['qtyT']);
                $(".TotalQty").val(obj['qtyT']);
                $(".after-discount").text(obj['totalAmount']);
                $("#after-discount").val(obj['totalAmount']);
            });
        });
    });
    </script>
    <?php include("part/alert.php"); ?>
    <?php include("part/all-js.php"); ?>
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

    <script>
    $(document).ready(function() {
        // click on payment btn
        $(".proceedPayment").on("click", function() {
            $("#discount_med").val('');
            var amount = $(".TotalAmount").attr("data-totalamount");
            $(".after-discount").text(amount);
            $("#after-discount").val(amount);

            var customer = $(".customertypef").val();
            // console.log(customer);
            var reeq = $.ajax({
                method: "GET",
                url: "ActionOrder/payment_process.php",
                data: {
                    customer: customer,
                    payBtn: "payBtn"
                }
            });
            reeq.done(function(msg) {
                // console.log(msg);
                $("#previous_due").text(msg);
                $("#previousduef").val(msg);
            });
        });

        // discount calculate
        $(".discountActivity").on("keyup change", function() {
            var discount = $("#discount_med").val();
            var user = $(".updateQty").attr("data-user");
            var type = $("#discount_type").val();
            var amount = $(".TotalAmount").attr("data-totalamount");
            // console.log(user+" "+discount+" "+amount);
            var reeq = $.ajax({
                method: "GET",
                url: "ActionOrder/payment_process.php",
                data: {
                    discount: discount,
                    user: user,
                    amount: amount,
                    type: type,
                    applyDiscount: "applyDiscount"
                }
            });
            reeq.done(function(msg) {
                // console.log(msg);
                var obj = JSON.parse(msg);
                $(".after-discount").text(obj['amount']);
                $("#after-discount").val(obj['amount']);
            });
        });

        $(".paid-amount").on("keyup change", function() {
            var payable = $("#after-discount").val();
            var paid = $(this).val();
            var due = $('#previous_due').text();
            var customer = $(".customertypef").val();
            var reeq = $.ajax({
                method: "GET",
                url: "ActionOrder/payment_process.php",
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