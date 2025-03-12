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

// In the PHP section, update the insert query
if (isset($_POST['btnsave']))
{
    $tableNumber = $_POST['tableNumber'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];

    $select = "SELECT * FROM tables WHERE TableNumber='$tableNumber'";
    $ret = mysqli_query($connect, $select);
    $count = mysqli_num_rows($ret);

    if ($count > 0)
    {
        echo "<script>window.alert('This table number already exists! Please choose another number.')</script>";
    }
    else
    {
        $query = "INSERT INTO tables(TableNumber, Location, Capacity) VALUES ('$tableNumber', '$location', '$capacity')";
        $result = mysqli_query($connect, $query);

        if ($result) {
            echo "<script>window.alert('Table has been successfully registered!')</script>";
            echo "<script>window.location='table-list.php'</script>";
        }
        else {
            echo "<script>window.alert('Error in registration!')</script>";
        }
    }
}

// In the form section
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

	<title>JOJO-Hotpot</title>

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

					<h1 class="h3 mb-3 text-center">Table Registration</h1>

					<div class="row">
						<div class="col-12">
						<div class="card">
							<div class="card-header">
							<div class="row align-items-center">
								<!-- Left side: Create New Order button -->
								<div class="col-md-6">
									<a href="table-list.php" class="btn btn-danger">Table List -></a>
								</div>

								<!-- Right side: Search bar -->
							
							</div>
						</div>
						<div class="card-body">
                                    <form method="POST">
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label class="form-label">Table Number</label>
                                                <input class="form-control form-control-lg" type="text" name="tableNumber" placeholder="Enter table number..." required />
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label">Location</label>
                                                <select class="form-select form-select-lg" name="location" required>
                                                    <option value="">Select Location</option>
                                                    <option value="Indoor">Indoor</option>
                                                    <option value="Outdoor">Outdoor</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label">Capacity</label>
                                                <input class="form-control form-control-lg" type="number" name="capacity" 
                                                       min="2" max="8" value="4" required />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-end">
                                                <input type="submit" class="btn btn-lg btn-danger" name="btnsave" value="Register">
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