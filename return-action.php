<?php
    session_start();
    if(!isset($_SESSION['store_id'])) {
        header("location:login.php");
        exit();
    }else{
        if(!isset($_GET['invoice']) || empty($_GET['invoice'])){
            header("location:return.php");
            exit();
        }else{
            include('config/db.php');
            $invoice = $_GET['invoice'];
            $customer = $_GET['customer'];
            $invoiceDetails = mysqli_fetch_assoc($conn->query("SELECT * FROM `p_invoice_summary` WHERE `invoice` = '$invoice'"));

            // emptying return cart 
            unset($_SESSION["return_item"]);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pharmacy</title>

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
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <form action="actions/return.php" method="POST">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Basic Details</h3>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <th>Invoice:</th>
                                                <td>
                                                    <?php echo $invoice; ?>
                                                    <input type="hidden" name="re_invoice" value="<?php echo $invoice;?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Customer Name:</th>
                                                <td>
                                                    <?php echo $customer; ?>
                                                    <input type="hidden" name="re_customer" value="<?php echo $customer;?>">
                                                    <input type="hidden" name="re_customer_code" value="<?php echo $invoiceDetails['client'];?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Product Price <small>(without %)</small> :</th>
                                                <td class="productPrice">
                                                    <?php echo $invoiceDetails['total_price']; ?>
                                                    <input type="hidden" name="re_total" value="<?php echo $invoiceDetails['total_price'];?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Discount</th>
                                                <td class="discount" data-discount="<?php echo $invoiceDetails['discount'];?>" data-discountType="<?php echo $invoiceDetails['discount_type'];?>">
                                                    <?php echo $invoiceDetails['discount']." (".$invoiceDetails['discount_type'].")"; ?>
                                                    <input type="hidden" name="re_discount" value="<?php echo $invoiceDetails['discount']." (".$invoiceDetails['discount_type'].")";?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Total Receivable <small>(after %)</small> :</th>
                                                <td>
                                                    <?php 
                                                        if($invoiceDetails['discount_type'] == "flat"){
                                                            $receivable = $invoiceDetails['total_price'] - $invoiceDetails['discount'];
                                                        }else{
                                                                $receivable = $invoiceDetails['total_price'] - ($invoiceDetails['total_price']*($invoiceDetails['discount']/100));
                                                        }
                                                        echo "$receivable";
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Total Paid:</th>
                                                <td class="totalPaid">
                                                <?php echo $invoiceDetails['paid']; ?>
                                                <input type="hidden" name="re_paid" value="<?php echo $invoiceDetails['paid'];?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Due:</th>
                                                <td>
                                                    <span class="due">
                                                    <?php echo $invoiceDetails['due']; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <!-- <tr>
                                                <th>Returned Product Value</th>
                                                <td>
                                                    0
                                                    <input type="text" class="previous_returned_product_value" value="0"
                                                        hidden="">
                                                </td>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Return Poduct</h3>
                                </div>
                                <div class="card-body">
                                    <!-- <form action="" method="POST" class="return_form"> -->
                                        <table id="example1" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="max-width:10%;">No.</th>
                                                    <th>Name</th>
                                                    <th>Unit Price</th>
                                                    <th>Ordered Quantity</th>
                                                    <th>Return Quantity</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $n = 0;
                                                    $totalQty = 0;
                                                    $sql = $conn->query("SELECT * FROM `p_invoice` WHERE `invoice` = '$invoice' AND `store` = '$_SESSION[store_id]'");
                                                    while($row = mysqli_fetch_assoc($sql)){
                                                        $totalQty += $row['qty'];
                                                ?>
                                                <tr>
                                                    <td><?php echo ++$n; ?></td>
                                                    <td class="cl<?php echo $row['id']; ?>2" data-product="<?php echo $row['product']; ?>"> <?php echo $row['product']; ?> </td>
                                                    <td> <?php echo $row['price']; ?> </td>
                                                    <td class="odq<?php echo $row['id']; ?>"> <?php echo $row['qty']; ?> </td>
                                                    <td> 
                                                        <input type="number" name="qty" class="form-control qty returnQty cl<?php echo $row['id']; ?>3" value="0" min="0" max="<?php echo $row['qty']; ?>"
                                                        data-product_id="<?php echo $row['id']; ?>" data-price="<?php echo $row['price']; ?>"> 
                                                    </td>
                                                    <td> 
                                                        <p class="totalprice cl<?php echo $row['id']; ?>">0</p>
                                                        <input type="hidden" class="cl<?php echo $row['id']; ?>" name="med<?php echo $row['product']; ?>" value="">
                                                    </td>
                                                    <td> <button type="button" class="btn btn-danger btn-sm no-return" data-product_id="<?php echo $row['id']; ?>" data-price="<?php echo $row['price']; ?>" data-returnQtyField="cl<?php echo $row['id']; ?>3"> <i class="fa fa-times"></i> No Return </button> </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:right;" colspan="6">Total:</td>
                                                    <td>
                                                        <span class="return_total_price">0.00</span>
                                                        <input type="hidden" name="return_total_price" class="return_total_price">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:right;" colspan="6">Discount:</td>
                                                    <td>
                                                        <span class="discount_amount">58</span>
                                                        <input type="text" name="calculated_discount" class="calculated_discount" value="0" hidden="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:right;" colspan="6">After Discount:</td>
                                                    <td>
                                                        <span class="return_product_value">0.00</span>
                                                        <input type="hidden" name="return_product_value" class="return_product_value">
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="">Considering The Paid Amount &amp; Discount Amount --
                                                        You Should Return:</label>
                                                    <h4 class="cus_should_payable">0.00</h4>
                                                    <input type="hidden" name="cus_should_payable" class="cus_should_payable">

                                                    <input type="number" name="should_pay" value="0"
                                                        class="form-control cus_should_pay" hidden="">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <label for="">Decided to Pay</label>
                                                <input type="text" name="payable_to_customer" value="0" class="form-control decided_to_pay" min="0">
                                                <!-- <label style="margin-top:20px; font-size:1.3em">
                                                    <input type="checkbox" class="form-control"
                                                        style="height:15px; width:15px; display:inline;"
                                                        name="pay_customer">
                                                    Make Payment
                                                </label> -->
                                            </div>
                                        </div>
                                        <input type="submit" value="Return Product" class="btn btn-info return_to_customer" name="return_to_customer" style="margin-top:20px;">
                                    <!-- </form> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
	<!-- Footer -->
	<?php include("part/footer.php");?>
	<!-- Footer End -->
    </div>

	<!-- All JS -->
	<?php include("part/all-js.php");?>
	<!-- All JS end -->
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
            var invoice = <?php echo $invoice ?>;

            var aa = $(".productPrice").text();
            // $(".return_total_price").text(aa);
            // $(".return_total_price").val(aa);

            var discount = $(".discount").attr("data-discount");
            var discountType = $(".discount").attr("data-discountType");
            $(".discount_amount").text(discount+" ("+discountType+")");
            
            $(".returnQty").on("change", function(){
                var qty = $(this).val();
                var product = $(this).attr("data-product_id");
                var product_name = $(".cl"+product+"2").attr("data-product");
                var orderQty = $(".odq"+product).text();
                var price = $(this).attr("data-price");
                // var crr = "cl"+product;
                $(".cl"+product).val(qty*price);
                $(".cl"+product).text(qty*price);

                // Total return quantity
                var totalReturnQty = 0;
                $('.returnQty').each(function(){
                    totalReturnQty += parseFloat($(this).val());
                });
                
                var sum = 0;
                $('.totalprice').each(function()
                {
                    sum += parseFloat($(this).text());
                });
                $(".return_total_price").text(sum);
                $(".return_total_price").val(sum);
                
                var vl;
                if(discountType == "flat"){
                    var perQty = parseFloat(discount) / parseFloat(<?php echo $totalQty ?>);
                    var returnQtyPriceTotal = totalReturnQty * perQty;
                    vl = (sum - returnQtyPriceTotal).toFixed(2);
                }else{
                    vl = sum - (sum*(discount/100));
                }
                $(".return_product_value").text(vl);
                $(".return_product_value").val(vl);

                var totalPaid = $(".totalPaid").text();
                // $(".cus_should_payable").text(totalPaid - vl);
                $(".cus_should_payable").text(vl);
                $(".cus_should_payable").val(vl);

                // console.log(invoice+" "+product+" "+product_name+" "+price+" "+orderQty+" "+qty);
                var reeq = $.ajax({
                    method: "GET",
                    url: "ajaxreq/returnProduct.php",
                    data: {
                        invoice: invoice,
                        product_id: product,
                        product_name: product_name,
                        price: price,
                        orderQty: orderQty,
                        returnQty: qty,
                        applyReturn: "applyReturn"
                    }
                });
                // reeq.done(function(data) {
                //     console.log(data);
                // });
            });


            $(".no-return").on("click", function(){
                var inputField = $(this).attr("data-returnQtyField");
                var product = $(this).attr("data-product_id");
                var product_name = $(".cl"+product+"2").attr("data-product");
                $("."+inputField).val(0);
                var aa = $(".productPrice").text(); // total price without discount
                var price = $(this).attr("data-price");
                // console.log(invoice);
                var qty = 0;

                $(".cl"+product).val(qty*price);
                $(".cl"+product).text(qty*price);
                
                var sum = 0;
                $('.totalprice').each(function()
                {
                    sum += parseFloat($(this).text());
                });
                $(".return_total_price").text(sum);
                $(".return_total_price").val(sum);
                
                var vl;
                if(discountType == "flat"){
                    vl = sum - discount;
                }else{
                    vl = sum - (sum*(discount/100));
                }
                $(".return_product_value").text(vl);
                $(".return_product_value").val(vl);

                var totalPaid = $(".totalPaid").text();
                // $(".cus_should_payable").text(totalPaid - vl);
                $(".cus_should_payable").text(vl);
                $(".cus_should_payable").val(vl);

                var reeq = $.ajax({
                    method: "GET",
                    url: "ajaxreq/returnProduct.php",
                    data: {
                        invoice: invoice,
                        product_name: product_name,
                        removeFromReturn: "removeFromReturn"
                    }
                });
                reeq.done(function(data) {
                    console.log(data);
                });
            });

        });
    </script>

</body>

</html>