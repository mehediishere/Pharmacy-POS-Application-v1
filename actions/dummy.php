<?php
    session_start();
    if(isset($_GET['reset'])){
        unset($_SESSION['food']);
        unset($_SESSION['itemlist']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Php - Simple shopping cart reference</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <a href="?cart=<?php echo rand(1, 5); ?>" class="btn btn-info me-3">Add to Cart</a>
        <a href="?reset" class="btn btn-warning">Reset</a>
    </div>
    <hr>
    <div class="container my-5">
        <?php
            $color = ['red', 'green', 'blue', 'orange', 'purple', 'sky', 'yellow', 'aliceblue', 'dark', 'gray'];
            if(isset($_GET['cart'])){
                $product = $_GET['cart'];
                foreach($color as $key => $colorValue){
                    if($product == $key){
                        $name = $colorValue;
                        break;
                    }
                }
                $cartArray = [$product=>['id'=>$product, 'name'=>$name]];
                if(empty( $_SESSION['itemlist'])){
                    $_SESSION['itemlist'][$product] = $product;
                    $_SESSION['food'] = $cartArray;
                }else{
                    if(in_array($product, $_SESSION['itemlist'])){
                        $msg = "Already exist";
                    }else{
                        $_SESSION['itemlist'][$product] = $product;
                        $_SESSION["food"] = array_merge($_SESSION["food"],$cartArray); // array_replace() can be use as well. it will preserve "key". unlike array_combine() which reset index
                        $msg = "New";
                    }
                }

                echo $msg ."<br>";
                
                echo "<pre>";
                echo print_r($_SESSION['food']);
                echo "</pre>";
            }
            
            echo "<br><br>";
            
            foreach($color as $key => $colorValue){
                echo "Product ID: ".$key."<br>";
                echo "Product Name: ".$colorValue."<br>";
            }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>