<?php

session_start();
include('connect.php');

if(!isset($_SESSION['AdminID']))
{
	echo "<script>window.location='sigin-in.php'</script>";
}

$AdminID = $_SESSION['AdminID'];

$selectAdmin = "SELECT AdminName FROM admin WHERE AdminID = '$AdminID'";
$resultAdmin = mysqli_query($connect, $selectAdmin);
$rowAdmin = mysqli_fetch_assoc($resultAdmin);
$AdminName = $rowAdmin['AdminName'];

$ID=$_GET['productCode'];

if (isset($_POST['btnUpdate'])) {

    $code=$_POST['code'];
    $name=$_POST['name'];
    $price=$_POST['price'];
    $quantity=$_POST['quantity'];
    $des=$_POST['des'];
    $remark=$_POST['remark'];    
 
        $query="UPDATE product SET
            productTypeCode='$code',
            productName='$name',
            price='$price',
            description='$des',
            quantity='$quantity',
            remark='$remark'
            WHERE productCode='$ID'";
        $result=mysqli_query($connect, $query);
 
        if ($result) {
            echo "<script>window.alert('Your product has been successfully updated!')</script>";
            echo "<script>window.location='product-list.php'</script>";
          
        }
        else{
            echo "<p>Error in Entry</p>";
        }
      }

	  $select = "SELECT * FROM product WHERE productCode='$ID'";
      $ret=mysqli_query($connect,$select);
	  $arr=mysqli_fetch_array($ret);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>Blank Page | AdminKit Demo</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
	<?php include('refactor/sidebar.php'); ?>
		<div class="main">
		<?php include('refactor/navbar.php'); ?>

			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Admin-List</h1>

					<div class="row">
						<div class="col-12">
						<div class="card">
								<div class="card-header">
                                <a href="product-list.php" class="btn btn-primary"> <- Product List</a>
								</div>
								<div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                            <label class="form-label">Product-Name</label>
											<input class="form-control form-control-lg" type="text" name="name" placeholder="Enter your product" value="<?php echo $arr['productName'] ?>" />
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Price</label>
											<input class="form-control form-control-lg" type="number" name="price" placeholder="Enter price" value="<?php echo $arr['price'] ?>" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                            <label class="form-label">Quantity</label>
											<input class="form-control form-control-lg" type="number" name="quantity" placeholder="Enter quantity" value="<?php echo $arr['quantity'] ?>" />
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Remark</label>
											<input class="form-control form-control-lg" type="text" name="remark" placeholder="Enter remark" value="<?php echo $arr['remark'] ?>" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                            <label class="form-label">Product-Type</label>
                                            <select class="form-select mb-3" name="code">
                                            <option selected>Choose Product-Type</option>
                                            <?php
                                            $query2 = "SELECT * FROM product_type where status='In-Stock' order by productTypeName";
                                            $ret = mysqli_query($connect, $query2);
                                            $size = mysqli_num_rows($ret);

                                            for ($i = 0; $i < $size; $i++) {
                                                $row = mysqli_fetch_array($ret);
                                                $cobProductTypeCode = $row['productTypeCode'];

                                                echo "<option value='$cobProductTypeCode'>" . $row['productTypeName'] . "</option>";
                                            }
                                            ?>
                                            </select>
                                            </div>
                                          
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control form-control-lg" rows="2" name="des" placeholder="Enter Description"><?php echo $arr['description'] ?></textarea>
                                            </div>                              
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-end">
                                            <input type="submit" class="btn btn-lg btn-primary" name="btnUpdate" value="Update">
                                            </div>                              
                                        </div>
                                    </form>
								</div>
						</div>
						</div>
					</div>
					
					

				</div>
			</main>
			<?php include('refactor/footer.php'); ?>
		</div>
	</div>

	<script src="js/app.js"></script>

</body>

</html>