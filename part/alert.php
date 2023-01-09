<!-- SweetAlert2 -->
<link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
	<?php
	if(isset($_SESSION['e-msg']))
  { ?>
		Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
        }).fire({
            icon: "error",
            title: "<?php echo $_SESSION['e-msg'];?>",
          });
	  <?php unset($_SESSION['e-msg']); 
  }elseif(isset($_SESSION['msg'])){ ?>
		Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
        }).fire({
            icon: "success",
            title: "<?php echo $_SESSION['msg'];?>",
          });
	  <?php unset($_SESSION['msg']);
  }elseif(isset($_SESSION['i-msg'])){ ?>
		Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
        }).fire({
            icon: "info",
            title: "<?php echo $_SESSION['i-msg'];?>",
          });
	  <?php unset($_SESSION['i-msg']); 
  } ?>
</script>