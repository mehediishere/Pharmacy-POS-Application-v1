<?php
session_start();
include("../config/db.php");

if(isset($_POST['request'])){
    $request = $_POST['request'];
    $result = $conn->query("SELECT * FROM `p_damage_product` WHERE `store` = '$_SESSION[store_id]' AND `product` = '$request'");
    $count = mysqli_num_rows($result);
}
?>


<?php
    if($count > 0){
        $n = 0;
        while($row = mysqli_fetch_assoc($result)){
?>
        <tr>
        <td><?php echo ++$n; ?></td>
        <td><?php echo $row['date']; ?></td>
        <td><?php echo $row['product']; ?></td>
        <td><?php echo $row['total_qty']; ?></td>
        <td><?php echo $row['damage_qty']; ?></td>
        <td><?php echo $row['cost']; ?></td>
        <td><?php echo $row['note']; ?></td>
        <td class="print_hidden">
            <div class="btn-group">
            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                aria-expanded="false">
                <i class="fa fa-cogs"></i>
            </button>
            <div class="dropdown-menu" x-placement="bottom-start">
                <a class="dropdown-item" href="">
                <i class="fa fa-pencil-square-o text-warning"></i>
                Edit
                </a>
                <a class="dropdown-item delete" href="">
                <i class="fa fa-trash text-danger"></i>
                Delete
                </a>
            </div>
            </div>
        </td>
        </tr>
<?php }
}else{?>
        <tr>
            <td colspan="8">No Data Found!!</td>
        </tr>
<?php } ?>