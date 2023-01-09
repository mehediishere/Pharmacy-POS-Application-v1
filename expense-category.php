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

    <div class="content-wrapper">
      <section class="container-fluid">
        <div class="row">
          <div class="card card-default col-md-12 col-lg-9">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header py-2">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                      <h6 class="fs-17 font-weight-600 mb-0">Add Expense Category</h6>
                      </div>
                      <div class="text-right">
                        <a href="manage-expense.php" class="btn btn-warning btn-sm mr-1"><i class="fas fa-align-justify mr-1"></i>Manage Expense</a>
                        <a href="expense-category.php" class="btn btn-success btn-sm mr-1"><i class="fas fa-align-justify mr-1"></i>Manage Category</a>
                        <a href="expense.php" class="btn btn-info btn-sm mr-1"><i class="fas fa-align-justify mr-1"></i>Add Expense</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <form action="actions/expense.php" method="POST">
                      <div class="row">
                        <div class="col-md-4">
                          <input type="text" class="form-control" placeholder="Enter Expense Category" name="expenseC">
                        </div>
                        <div class="col-md-4">
                          <button type="submit" class="btn btn-info" name="submitEC"><i class="fa fa-save"></i> Save </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Expense List</h3>
                  </div>
                  <div class="card-body">
                    <table id="example1" class="table table-bordered">
                      <thead>
                        <tr class="bg-info">
                          <th style="width:10%;">SL</th>
                          <th>Category</th>
                          <th style="width:20%;">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            $n = 0;
                            $sql = $conn->query("SELECT * FROM `p_expense_category` WHERE `store` = '$_SESSION[store_id]'");
                            while($row = mysqli_fetch_assoc($sql)){
                          ?>
                        <tr>
                          <th><?php echo ++$n; ?></th>
                          <td>
                            <input type="text" class="d-block form-control bg-white border-0 category<?php echo $row['id'] ?>" value="<?php echo $row['category'] ?>" readonly>
                          </td>
                          <td>
                            <a type="button" class="btn btn-info btn-sm edit category-edit-btn-bg<?php echo $row['id'] ?>" data-code="<?php echo $row['id'] ?>"><i class="category-edit-icon<?php echo $row['id'] ?> fa fa-edit"></i> </a>
                            <a href="actions/remove.php?remove&code=<?php echo base64_encode($row['id']); ?>&wr=<?php echo base64_encode("p_expense_category"); ?>" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ads start  -->
          <div class="d-none d-lg-block col-lg-3">
            <div class="card">
              <a href="#"> <img src="dist/img/clinic.jpg" alt="" class="img-fluid"> </a>
            </div>
          </div>
          <!-- ads end  -->
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
    $(function() {
        $(".select2").select2();
        $(".select2bs4").select2({
            theme: "bootstrap4",
        });
    });
  </script>

  <script>
    $(function() {
      $('.edit').on('click', function(){
        var code = $(this).data('code');
        
        $('.category'+code).toggleClass('border-0 ');
        $('.category'+code).attr('readonly', function(_, attr){ return !attr});;
        
        $('.category-edit-icon'+code).toggleClass('fa-edit fa-check');
        $('.category-edit-btn-bg'+code).toggleClass('btn-info btn-success');
        
        if($(this).hasClass('change')){
          var value = $('.category'+code).val();
          // console.log(code+" "+value);
          var reeq = $.ajax({
            method: "GET",
            url: "ajaxreq/smallUpdate.php",
            data: {
              code: code,
              value: value,
              updateExpenseCategory: "updateExpenseCategory"
            }
          });
        }

        $('.category-edit-btn-bg'+code).toggleClass('change ');
      });

    });
  </script>

</body>
</html>