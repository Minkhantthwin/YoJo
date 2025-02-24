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

$ID = $_GET['purchaseCode'];

$query = "SELECT p.*, GROUP_CONCAT(CONCAT(pr.productName, ' (x', pd.purchaseQuantity, ')') SEPARATOR ', ') AS Items
FROM purchase p
JOIN purchasedetail pd ON p.purchaseCode = pd.purchaseCode
JOIN product pr ON pd.productCode = pr.productCode
WHERE p.purchaseCode = '$ID'
GROUP BY p.purchaseCode
";
$result = mysqli_query($connect, $query);
$arr = mysqli_fetch_assoc($result);
$size = mysqli_num_rows($result);

if (isset($_POST['btnUpdate'])) {
    $delivery = $_POST['cbostatus'];

    $UpdateDelivery = "UPDATE purchase
    SET status='$delivery'
    WHERE purchaseCode = '$ID'";

    $result_delivery = mysqli_query($connect, $UpdateDelivery);

    if ($result_delivery) {
        echo "<script>window.alert('Status Updated.')</script>";
        echo "<script>window.location='purchaseDetail.php?purchaseCode=$ID'</script>";
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

	<title>Purchase-Form | JoJo-Hotpot</title>

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

					<h1 class="h3 mb-3 text-center"><?php echo $ID ?>'s Details</h1>

					<div class="row">
						<div class="col-12">
                        <div class="card">
								<div class="card-header">
                                <a href="purchase-list.php" class="btn btn-danger"> <- Purchase List</a>
								</div>
								<div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                        <div class="row mb-2">
                                            <div class="col-6">
                                            <label class="form-label">Purchase-Code</label>
											<input class="form-control form-control-lg" type="text" name="txtPurchaseID" value="<?php echo $ID ?>" readonly />
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Purchase-Date</label>
											<input class="form-control form-control-lg" type="date" name="txtPurchaseDate" value="<?php echo $arr['purchaseDate']; ?>" readonly/>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                            <label class="form-label">Total-Quantity</label>
											<input class="form-control form-control-lg" type="text"name="txtTotalQuantity" value="<?php echo $arr['totalAmount']; ?>" readonly/>
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Total-Amount</label>
											<input class="form-control form-control-lg" type="text"  name="txtTotalAmount" value="<?php echo $arr['totalQuantity']; ?>" readonly/>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label">Purchased Products</label>
											<input class="form-control form-control-lg" type="text" name="txtPurchasePrice" placeholder="Enter Price" value="<?php echo $arr['Items']; ?>"  readonly/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                           
                                            <div class="col-12">
                                            <label class="form-label">Status</label>
                                            <select name="cbostatus" class="form-select">
                                            <option value="<?php echo $arr['status']; ?>" selected><?php echo $arr['status']; ?></option>
                                            <?php
                                            // Toggle between "Pending" and "Confirmed"
                                            if ($arr['status'] == 'Pending') {
                                                echo '<option value="Confirmed">Confirmed</option>';
                                            } else {
                                                echo '<option value="Pending">Pending</option>';
                                            }
                                            ?>
                                        </select>
                                            </div>
                                            <div class="col-12">
                                            <input type="submit" class="btn btn-lg btn-danger mt-3" name="btnUpdate" value="Update Status">
                                            </div>
                                        </div>
                                 
								</div>
						</div>
						</div>
					</div>
                </form>
				</div>
			</main>

		
			<?php include('refactor/footer.php'); ?>
		</div>
	</div>

	<script src="js/app.js"></script>

</body>

</html>