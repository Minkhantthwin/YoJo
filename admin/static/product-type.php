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

 
if (isset($_POST['btnsave']))
{
    $name=$_POST['productTypeName'];
    $status=$_POST['status'];

    
      $select = "SELECT * FROM product_type WHERE productTypeName='$name'";
      $ret=mysqli_query($connect,$select);
      $count=mysqli_num_rows($ret);
 
      if ($count>0)
      {
        echo "<p>This product type already exists!, Please Choose another name!</p>";
        exit();
      }
      else
      {
        $query="INSERT INTO product_type(productTypeName, status) values('$name','$status')";
        $result=mysqli_query($connect, $query);
 
        if ($result) {
            echo "<script>window.alert('Your product type has been successfully registered!')</script>";
            echo "<script>window.location='product-type.php'</script>";
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

					<h1 class="h3 mb-3 text-center">Product-Type Form</h1>

					<div class="row">
						<div class="col-12">
                        <div class="card">
								<div class="card-header">
                                <a href="product-type-list.php" class="btn btn-primary">Product-Type-List -></a>
								</div>
								<div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                            <label class="form-label">Product-Type</label>
											<input class="form-control form-control-lg" type="text" name="productTypeName" placeholder="Enter product-type" />
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Status</label>
											<select class="form-select" name="status">
                                            <option selected>In-Stock</option>
                                            <option>Pending</option>
                                            </select>
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