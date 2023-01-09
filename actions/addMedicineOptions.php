<?php 

session_start();
include('../config/db.php');

// -------------- Medicine Category ---------------

if(isset($_POST['submitCategory'])){
    $chk = 0;
    $medicineCategory = $conn->real_escape_string($_POST['medicineCategory']);   //required

    // image 
    $uploadFileRename = "not-available.png";
    $filename = $_FILES["uploadfile"]["name"]; //file name
    if(!empty($filename)){
        $tempname = $_FILES["uploadfile"]["tmp_name"]; //file
        $uploadFileRename = time().rand(00,999).$_SESSION['store_id'].$filename; //rename file
        $folder = "../dist/img/medicine-category/".$uploadFileRename; //root folder destination
    
        $allowTypes = array('jpg','png','jpeg');
        $fileType = pathinfo($filename, PATHINFO_EXTENSION);

        // checking file type for image
        if(!in_array($fileType, $allowTypes)){
            $chk = 1;
            $_SESSION['e-msg']="Only 'jpg','png','jpeg' support.";
            echo "<script>window.history.back();</script>";
            exit();
        }
    }
    // image end

    // Empty input field check 
    if(empty($medicineCategory)){
        $chk=1;
        $_SESSION['e-msg']="Category field can not be empty";
        echo "<script>window.history.back();</script>";
        exit();
    }
    // Empty input field check end


    $medicineCategoryCheck = mysqli_num_rows($conn->query("SELECT `name` FROM `p_medicine_category` where `name`='$medicineCategory' AND `store`='$_SESSION[store_id]'"));
    if($medicineCategoryCheck > 0){
        $chk=1;
        $_SESSION['e-msg']="This category already exist";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if($chk==0){
        $conn->query("INSERT INTO `p_medicine_category`(`store`, `name`, `img`, `date`) VALUES ('$_SESSION[store_id]', '$medicineCategory', '$uploadFileRename', '$date')");          
        $_SESSION['msg'] ="Information submit successfully";
        if(!empty($filename)){
            move_uploaded_file($tempname, $folder);
        }
        header("location:../add-category.php");
        exit();
    }else{
        $_SESSION['msg'] ="Something went wrong. Try later !!!";
        header("location:../add-category.php");
        exit();
    }
}

if(isset($_POST['updateCategory'])){
    $chk = 0;
    $catid = $conn->real_escape_string($_POST['catid']); 
    $medicineCategory = $conn->real_escape_string($_POST['medicineCategory']);
    $img = $conn->real_escape_string($_POST['img']);

    // image 
    $uploadFileRename = $img;
    $filename = $_FILES["uploadfile"]["name"]; //file name
    if(!empty($filename)){
        $tempname = $_FILES["uploadfile"]["tmp_name"]; //file
        $uploadFileRename = time().rand(00,999).$_SESSION['store_id'].$filename; //rename file
        $folder = "../dist/img/medicine-category/".$uploadFileRename; //root folder destination
    
        $allowTypes = array('jpg','png','jpeg');
        $fileType = pathinfo($filename, PATHINFO_EXTENSION);

        // checking file type for image
        if(!in_array($fileType, $allowTypes)){
            $chk = 1;
            $_SESSION['e-msg']="Only 'jpg','png','jpeg' support.";
            echo "<script>window.history.back();</script>";
            exit();
        }
    }
    // image end

    if($chk==0){
        $conn->query("UPDATE `p_medicine_category` SET `name`='$medicineCategory',`img`='$uploadFileRename' WHERE `id`='$catid' AND `store`='$_SESSION[store_id]'");          
        $_SESSION['msg'] ="Information updated successfully";
        if(!empty($filename)){
            move_uploaded_file($tempname, $folder);
        }
        header("location:../manage-category.php");
        exit();
    }
}

// -------------- Medicine Brand ---------------

if(isset($_POST['submitBrand'])){
    $chk = 0;
    $medicineBrand = $conn->real_escape_string($_POST['medicineBrand']);   //required
    $details = $conn->real_escape_string($_POST['detailstext']);   //required

    // image 
    $uploadFileRename = "not-available.png";
    $filename = $_FILES["uploadfile"]["name"]; //file name
    if(!empty($filename)){
        $tempname = $_FILES["uploadfile"]["tmp_name"]; //file
        $uploadFileRename = time().rand(00,999).$filename; //rename file
        $folder = "../dist/img/medicine-brand/".$uploadFileRename; //root folder destination
    
        $allowTypes = array('jpg','png','jpeg');
        $fileType = pathinfo($filename, PATHINFO_EXTENSION);

        // checking file type for image
        if(!in_array($fileType, $allowTypes)){
            $chk = 1;
            $_SESSION['e-msg']="Only 'jpg','png','jpeg' support.";
            echo "<script>window.history.back();</script>";
            exit();
        }
    }
    // image end

    // Empty input field check 
    if(empty($medicineBrand)){
        $chk=1;
        $_SESSION['e-msg']="Brand field can not be empty";
        echo "<script>window.history.back();</script>";
        exit();
    }
    // Empty input field check end


    $check = mysqli_num_rows($conn->query("SELECT `name`, `store` FROM `p_brand` where `name`='$medicineBrand' AND `store`='$_SESSION[store_id]'"));
    if($check > 0){
        $chk=1;
        $_SESSION['e-msg']="This brand already exist";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if($chk==0){
        $insert=$conn->query("INSERT INTO `p_brand` (`store`, `name`, `details`, `img`, `date`) VALUES ('$_SESSION[store_id]', '$medicineBrand', '$details', '$uploadFileRename', '$date')");
        if($insert){            
            $_SESSION['msg'] ="Information submit successfully";
            if(!empty($filename)){
                move_uploaded_file($tempname, $folder);
            }
            header("location:../add-brand.php");
            exit();
        }
    }else{
        $_SESSION['msg'] ="Something went wrong. Try later !!!";
        header("location:../add-brand.php");
        exit();
    }
}


if(isset($_POST['updateBrand'])){
    $chk = 0;
    $id = $conn->real_escape_string($_POST['code']); 
    $name = $conn->real_escape_string($_POST['medicineBrand']);
    $details = $conn->real_escape_string($_POST['details']);
    $img = $conn->real_escape_string($_POST['img']);

    // image 
    $uploadFileRename = $img;
    $filename = $_FILES["uploadfile"]["name"]; //file name
    if(!empty($filename)){
        $tempname = $_FILES["uploadfile"]["tmp_name"]; //file
        $uploadFileRename = time().rand(00,999).$_SESSION['store_id'].$filename; //rename file
        $folder = "../dist/img/medicine-brand/".$uploadFileRename; //root folder destination
    
        $allowTypes = array('jpg','png','jpeg');
        $fileType = pathinfo($filename, PATHINFO_EXTENSION);

        // checking file type for image
        if(!in_array($fileType, $allowTypes)){
            $chk = 1;
            $_SESSION['e-msg']="Only 'jpg','png','jpeg' support.";
            echo "<script>window.history.back();</script>";
            exit();
        }
    }
    // image end

    if($chk==0){
        $conn->query("UPDATE `p_brand` SET `name`='$name', `details`='$details', `img`='$uploadFileRename' WHERE `id`='$id' AND `store`='$_SESSION[store_id]'");          
        $_SESSION['msg'] ="Information updated successfully";
        if(!empty($filename)){
            move_uploaded_file($tempname, $folder);
        }
        header("location:../manage-brand.php");
        exit();
    }
}


// -------------- Medicine unit ---------------

if(isset($_POST['btnSaveMedicineUnit'])){
    $medicineUnit = $conn->real_escape_string($_POST['medicineUnit']); //required
    $chk = 0;
    // Empty input field check 
    if(empty($medicineUnit)){
        $chk=1;
        $_SESSION['msg']="Unit field can not be empty";
        echo "<script>window.history.back();</script>";
        exit();
    }
    // Empty input field check end

    $medicineUnitCheck = mysqli_num_rows($conn->query("SELECT `unit` FROM `medicine_unit` where `unit`='$medicineUnit'"));
    if($medicineUnitCheck > 0){
        $chk=1;
        $_SESSION['msg']="This medicine unit already exist";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if($chk==0){
        $insertmedicineUnit=$conn->query("INSERT INTO `medicine_unit`(`unit`, `date`) VALUES ('$medicineUnit', '$date')");
        if($insertmedicineUnit){            
            $_SESSION['msg'] ="Information submit successfully";
            header("location:../add-unit.php");
            exit();
        }
    }else{
        $_SESSION['msg'] ="Something went wrong. Try later !!!";
        header("location:../add-unit.php");
        exit();
    }
}


// -------------- Medicine type ---------------

if(isset($_POST['btnSaveMedicineType'])){
    $medicineType = $conn->real_escape_string($_POST['medicineType']);   //required
    $chk = 0;
    // Empty input field check 
    if(empty($medicineType)){
        $chk=1;
        $_SESSION['msg']="Type field can not be empty";
        echo "<script>window.history.back();</script>";
        exit();
    }
    // Empty input field check end

    $medicineTypeCheck = mysqli_num_rows($conn->query("SELECT `type` FROM `medicine_type` where `type`='$medicineType'"));
    if($medicineTypeCheck > 0){
        $chk=1;
        $_SESSION['msg']="This medicine type already exist";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if($chk==0){
        $insertmedicineType=$conn->query("INSERT INTO `medicine_type`(`type`, `date`) VALUES ('$medicineType', '$date')");
        if($insertmedicineType){            
            $_SESSION['msg'] ="Information submit successfully";
            header("location:../add-type.php");
            exit();
        }
    }else{
        $_SESSION['msg'] ="Something went wrong. Try later !!!";
        header("location:../add-type.php");
        exit();
    }
}


// -------------- Medicine leaf ---------------

if(isset($_POST['btnSaveMedicineLeaf'])){
    $medicineLeaf = $conn->real_escape_string($_POST['medicineLeaf']);   //required
    $medicineLeafQty = $conn->real_escape_string($_POST['medicineLeafQty']);   //required
    $chk = 0;
    // Empty input field check 
    if(empty($medicineLeaf)){
        $chk=1;
        $_SESSION['msg']="Leaf field can not be empty";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if(empty($medicineLeafQty)){
        $chk=1;
        $_SESSION['msg']="Quantity field can not be empty";
        echo "<script>window.history.back();</script>";
        exit();
    }
    // Empty input field check end

    $medicineLeafCheck = mysqli_num_rows($conn->query("SELECT `leaftype`, `qty` FROM `medicine_leaf` where `leaftype`='$medicineLeaf' AND `qty`='$medicineLeafQty'"));
    if($medicineLeafCheck > 0){
        $chk=1;
        $_SESSION['msg']="Same medicine leaf + quantity already exist";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if($chk==0){
        $insertmedicineType=$conn->query("INSERT INTO `medicine_leaf`(`leaftype`, `qty`, `date`) VALUES ('$medicineLeaf', '$medicineLeafQty', '$date')");
        if($insertmedicineType){            
            $_SESSION['msg'] ="Information submit successfully";
            header("location:../leaf-setting.php");
            exit();
        }
    }else{
        $_SESSION['msg'] ="Something went wrong. Try later !!!";
        header("location:../leaf-setting.php");
        exit();
    }
}


// ------------- Redirect to home page (if anyhow user come to this page without doing any action)

header("location:../index.php");
exit();