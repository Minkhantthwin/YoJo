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
    $name=$_POST['name'];
    $status=$_POST['status'];
    $email=$_POST['email'];
    $address=$_POST['address'];
    $phone=$_POST['phone'];

      $select = "SELECT * FROM supplier WHERE email='$email'";
      $ret=mysqli_query($connect,$select);
      $count=mysqli_num_rows($ret);
 
      if ($count>0)
      {
        echo "<p>This name already exists!, Please Choose another name!</p>";
        exit();
      }
      else
      {
        $query="INSERT INTO supplier(supplierName, phoneNum, email, address, status) values('$name','$phone','$email','$address','$status')";
        $result=mysqli_query($connect, $query);
 
        if ($result) {
            echo "<script>window.alert('Supplier has been successfully registered!')</script>";
            echo "<script>window.location='supplier.php'</script>";
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

					<h1 class="h3 mb-3 text-center">Supplier-Registration</h1>

					<div class="row">
						<div class="col-12">
						<div class="card">
							<div class="card-header">
							<div class="row align-items-center">
								<!-- Left side: Create New Order button -->
								<div class="col-md-6">
									<a href="supplier-list.php" class="btn btn-primary">Supplier-list -></a>
								</div>

								<!-- Right side: Search bar -->
							
							</div>
						</div>
								<div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                            <label class="form-label">Supplier-Name</label>
											<input class="form-control form-control-lg" type="text" name="name" placeholder="Enter name..." />
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Status</label>
											<select class="form-select" name="status">
                                            <option selected>active</option>
                                            <option>in-active</option>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                            <label class="form-label">Phone-Number</label>
											<input class="form-control form-control-lg" type="number" name="phone" placeholder="Enter phone number.." />
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Email</label>
                                            <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter email..." />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control form-control-lg" rows="2" name="address" placeholder="Enter Address..."></textarea>
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