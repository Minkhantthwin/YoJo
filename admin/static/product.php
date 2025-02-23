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

if (isset($_POST['btnsave'])) {

    $code=$_POST['code'];
    $name=$_POST['name'];
    $price=$_POST['price'];
    $quantity=$_POST['quantity'];
    $des=$_POST['des'];
    $remark=$_POST['remark'];    
    $fileimage1 = $_FILES['fileimage1']['name']; // e.g., abc.jpg
    $folder1 = "products/";                       // Relative path for first target folder
    $folder2 = "C:/xampp/htdocs/hero/static/products/"; // Absolute path for second target folder
    
    // Define full paths for both copies
    $filePath1 = $folder1 . '_' . $fileimage1; // hero_admin/pages/products/_abc.jpg
    $filePath2 = $folder2 . '_' . $fileimage1; // hero/static/products/_abc.jpg
    
    // Copy to the first folder
    $copied1 = copy($_FILES['fileimage1']['tmp_name'], $filePath1);
    
    // Copy to the second folder
    $copied2 = copy($_FILES['fileimage1']['tmp_name'], $filePath2);
    
    // Check if both copies succeeded
    if (!$copied1 || !$copied2) {
        echo "<p>Cannot upload item photo to one or more destinations.</p>";
        exit();
    } else {
        echo "<p>Photo uploaded successfully to both destinations.</p>";
    }
    
    
      $select = "SELECT * FROM product WHERE ProductName='$name'";
      $ret=mysqli_query($connect,$select);
      $count=mysqli_num_rows($ret);
 
      if ($count>0)
      {
        echo "<p>This product already exists!, Please Choose another name!</p>";
        exit();
      }
      else
      {
        $query="INSERT INTO product(productTypeCode, productName, price, quantity, description, remark, photo) values('$code','$name','$price','$quantity','$des','$remark','$fileimage1')";
        $result=mysqli_query($connect, $query);
 
        if ($result) {
            echo "<script>window.alert('Your product has been successfully registered!')</script>";
            echo "<script>window.location='product.php'</script>";
          
        }
        else{
            echo "<p>Error in Entry</p>";
        }
      }
}

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

	<title>Product-Form | HERO FITNESS</title>

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

					<h1 class="h3 mb-3 text-center">Product-Form</h1>
                    
					<div class="row">
						<div class="col-12">
                        <div class="card">
								<div class="card-header">
                                <a href="product-list.php" class="btn btn-primary">Product List -></a>
								</div>
								<div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                            <label class="form-label">Product-Name</label>
											<input class="form-control form-control-lg" type="text" name="name" placeholder="Enter your product" />
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Price</label>
											<input class="form-control form-control-lg" type="number" name="price" placeholder="Enter price " />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                            <label class="form-label">Quantity</label>
											<input class="form-control form-control-lg" type="number" name="quantity" placeholder="Enter quantity" />
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Remark</label>
											<input class="form-control form-control-lg" type="text" name="remark" placeholder="Enter remark" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
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
                                            <div class="col-6">
                                            <label class="form-label">Image</label>
											<input class="form-control form-control-lg" type="file" name="fileimage1" placeholder="Enter " />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control form-control-lg" rows="2" name="des" placeholder="Enter Description"></textarea>
                                            </div>                              
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-end">
                                            <input type="submit" class="btn btn-lg btn-primary" name="btnsave" value="Register">
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