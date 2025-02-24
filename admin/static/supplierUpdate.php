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

$ID=$_GET['supplierID'];

if (isset($_POST['btnUpdate']))
{
    $name=$_POST['name'];
    $status=$_POST['status'];
    $email=$_POST['email'];
    $address=$_POST['address'];
    $phone=$_POST['phone'];
      
        $query="UPDATE supplier SET supplierName = '$name', email = '$email', address = '$address', phoneNum = '$phone', status = '$status'
                WHERE supplierID = $ID";
        $result=mysqli_query($connect, $query);
 
        if ($result) {
            echo "<script>window.alert('Supplier has been successfully updated!')</script>";
            echo "<script>window.location='supplier-list.php'</script>";
        }
        else{
            echo "<p>Error in Entry</p>";
        }
      }

      $select = "SELECT * FROM supplier WHERE supplierID='$ID'";
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

	<title>Blank Page | JoJo-Hotpot</title>

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

					<h1 class="h3 mb-3 text-center">Supplier-Update</h1>

					<div class="row">
						<div class="col-12">
                        <div class="card">
								<div class="card-header">
                                <a href="supplier-list.php" class="btn btn-danger"><- Supplier-List</a>
								</div>
								<div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                            <label class="form-label">Supplier-Name</label>
											<input class="form-control form-control-lg" type="text" name="name" placeholder="Enter name..." value="<?php echo $arr['supplierName']; ?>"/>
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
											<input class="form-control form-control-lg" type="number" name="phone" placeholder="Enter phone number.." value="<?php echo $arr['phoneNum']; ?>" />
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Email</label>
                                            <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter email..." value="<?php echo $arr['email']; ?>" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control form-control-lg" rows="2" name="address" placeholder="Enter Address..."><?php echo $arr['address']; ?></textarea>
                                            </div>                              
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-end">
                                            <input type="submit" class="btn btn-lg btn-danger" name="btnUpdate" value="Update">
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