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
    $name=$_POST['txtname'];
    $phone=$_POST['txtphone'];
    $address=$_POST['txtaddress'];
    $nrc= $_POST['txtnrc'];
    $email=$_POST['txtemail'];
    $password=$_POST['txtpassword'];

    $select = "SELECT * FROM customer WHERE Email='$email'";
    $ret=mysqli_query($connect,$select);
    $count=mysqli_num_rows($ret);

      if ($count>0)
      {
        echo "<script>window.alert(Account with this gmail already exists.)</script>";
        exit();
      }
      else
      {
        $query="INSERT INTO customer(CustomerName, NRC, Address, Phone, Email, Password) values('$name','$nrc','$address','$phone','$email','$password')";
        $result=mysqli_query($connect, $query);

        if ($result) {
            echo "<script>window.alert('Your account has been successfully registered!')</script>";
            echo "<script>window.location='customer-list.php'</script>";
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

	<title>HERO-FITNESS</title>

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

					<h1 class="h3 mb-3 text-center">Member-Registration</h1>

					<div class="row">
						<div class="col-12">
						<div class="card">
							<div class="card-header">
							<div class="row align-items-center">
								<!-- Left side: Create New Order button -->
								<div class="col-md-6">
									<a href="customer-list.php" class="btn btn-primary">Member-list -></a>
								</div>

								<!-- Right side: Search bar -->
							</div>
						</div>
						<div class="card-body">
									<form method="POST">
										<div class="mb-3">
											<label class="form-label">Full name</label>
											<input class="form-control form-control-lg" type="text" name="txtname" placeholder="Enter your name" />
										</div>
										<div class="mb-3">
											<label class="form-label">Phone-Number</label>
											<input class="form-control form-control-lg" type="text" name="txtphone" placeholder="Enter your ph-no." />
										</div>
										<div class="mb-3">
											<label class="form-label">Address</label>
											<input class="form-control form-control-lg" type="text" name="txtaddress" placeholder="Enter your address" />
										</div>
										<div class="mb-3">
											<label class="form-label">NRC</label>
											<input class="form-control form-control-lg" type="text" name="txtnrc" placeholder="Eg. 12/BaHaNa(N)...." />
										</div>
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="txtemail" placeholder="Enter your email" />
										</div>
										<div class="mb-4">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="txtpassword" placeholder="Enter password" />
										</div>
										<div class="d-grid gap-2 mt-3">
                                            <input type="submit" class="btn btn-lg btn-primary" name="btnsave" value="Sign up">
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