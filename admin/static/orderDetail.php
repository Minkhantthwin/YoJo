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

$OrderID = $_GET['OrderID'];

$query = "  SELECT o.*, GROUP_CONCAT(CONCAT(od.ProductName, ' (x', od.Quantity, ')') SEPARATOR ', ') AS Items, c.CustomerName, c.Phone
FROM orders o
JOIN orderdetails od ON o.OrderID = od.OrderID
JOIN customer c ON o.CustomerID = c.CustomerID
WHERE o.OrderID = '$OrderID' ";

$result = mysqli_query($connect, $query);
$arr = mysqli_fetch_array($result);

if (isset($_POST['btnDelivery'])) {
    $delivery = $_POST['cbodelivery'];

    $UpdateDelivery = "UPDATE orders
    SET DeliveryStatus='$delivery'
    WHERE OrderID = '$OrderID'";

    $result_delivery = mysqli_query($connect, $UpdateDelivery);

    if ($result_delivery) {
        echo "<script>window.alert('Delivery Updated.')</script>";
        echo "<script>window.location='orderDetail.php?OrderID=$OrderID'</script>";
    }
}

if (isset($_POST['btnStatus'])) {
    $status = $_POST['cboStatus'];

    $UpdateStatus = "UPDATE orders
    SET Status='$status'
    WHERE OrderID = '$OrderID'";

    $result_status = mysqli_query($connect, $UpdateStatus);

    if ($result_status) {
        echo "<script>window.alert('Order Status Updated.')</script>";
        echo "<script>window.location='orderDetail.php?OrderID=$OrderID'</script>";
    }
}

?>
<!DOCTYPE htmb>
<htmb lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, htmb, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.htmb" />

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

					<h1 class="h3 mb-5 text-center"><?php echo $OrderID ?>'s Detail</h1>

					<div class="row">
						<div class="col-12">
						<div class="card">
							<div class="card-header">
							<div class="row align-items-center">
								<!-- Left side: Create New Order button -->
								<div class="col-md-6">
									<a href="index.php" class="btn btn-primary"><- Order-List</a>
								</div>

								<!-- Right side: Search bar -->
							
							</div>
						</div>
								<div class="card-body">
                                <form class="user" method="post">
                              
                              <div class="form-group row">
                              <div class="col-3 mb-3">
                                      <label for="Items" class="mb-2">Customer-ID</label>
                                      <input type="text" class="form-control form-control-user" id="Items"
                                          placeholder="Customer-ID" name="txtbrand" value="C-<?php echo $arr['CustomerID'] .' (' . $arr['CustomerName'] . ')'; ?>" readonly>
                                  </div>
                                  <div class="col-3 mb-3">
                                      <label for="Items" class="mb-2">Phone</label>
                                      <input type="text" class="form-control form-control-user" id="Items"
                                          placeholder="Customer-ID" name="txtbrand" value="<?php echo $arr['Phone']; ?>" readonly>
                                  </div>
                                  <div class="col-6">
                                  <label for="Items" class="mb-2">Products</label>
                                  <input type="text" class="form-control" id="Items"
                                  placeholder="Customer-ID" name="txtbrand" value="<?php echo $arr['Items']; ?>" readonly>
                                         <!-- <table class="form-control-user">
                                                <td><?php echo $arr['Items']; ?></td>
                                         </table> -->
                                  </div>
                              </div>
                              <div class="form-group row">
                              <div class="col-3 mb-3">
                                      <label for="Items" class="mb-2">Total Amount</label>
                                      <input type="text" class="form-control form-control-user" id="Items"
                                          placeholder="Customer-ID" name="txtbrand" value="<?php echo $arr['TotalAmount']; ?> $" readonly>
                                  </div>
                                  <div class="col-3">
                                  <label for="Items" class="mb-2">VAT</label>
                                      <input type="text" class="form-control form-control-user" id="Items"
                                          placeholder="Items" name="txtbrand" value="<?php echo $arr['VAT']; ?> $" readonly>
                                  </div>
                                  <div class="col-3">
                                  <label for="Items" class="mb-2">Total Quantity</label>
                                      <input type="text" class="form-control form-control-user" id="Items"
                                          placeholder="Items" name="txtbrand" value="<?php echo $arr['TotalQuantity']; ?> (products)" readonly>
                                  </div>
                                  <div class="col-3">
                                  <label for="Items" class="mb-2">GrandTotal</label>
                                      <input type="text" class="form-control form-control-user" id="Items"
                                          placeholder="Items" name="txtbrand" value="<?php echo $arr['GrandTotal']; ?> $" readonly>
                                  </div>
                              </div>
                              <div class="form-group row">
                              <div class="col-8 mb-3">
                                      <label for="Items" class="mb-2">Direction</label>
                                      <input type="text" class="form-control form-control-user" id="Items"
                                          placeholder="Customer-ID" name="txtbrand" value="<?php echo $arr['Direction']; ?>" readonly>
                                  </div>
                                  <div class="col-4">
                                  <label for="Items" class="mb-2">Payment-Type</label>
                                      <input type="text" class="form-control form-control-user" id="Items"
                                          placeholder="Items" name="txtbrand" value="<?php echo $arr['PaymentType']; ?>" readonly>
                                  </div>
                                
                              </div>
                              <div class="form-group row">
                              <div class="col-6 mb-3">
                                      <label for="Items" class="mb-2">Optional-Direction</label>
                                      <input type="text" class="form-control form-control-user" id="Items"
                                          placeholder="Customer-ID" name="txtbrand" value="<?php echo $arr['OptionalDirection']; ?>" readonly>
                                  </div>
                                  <div class="col-6">
                                  <label for="Items" class="mb-2">Additional Comment</label>
                                      <input type="text" class="form-control form-control-user" id="Items"
                                          placeholder="Items" name="txtbrand" value="<?php echo $arr['Comments']; ?>" readonly>
                                  </div>
                                
                              </div>        
                              <div class="form-group row">
                              <div class="col-6 mb-3">
                              <label for="Items" class="mb-1">Delivery-Status</label>
                              <select name="cbodelivery" class="form-select">
                                  <option value="<?php echo $arr['DeliveryStatus']; ?>" selected><?php echo $arr['DeliveryStatus']; ?></option>
                                  <?php
                                  // Toggle between "Pending" and "Confirmed"
                                  if ($arr['DeliveryStatus'] == 'Pending') {
                                      echo '<option value="Confirmed">Confirmed</option>';
                                  } else {
                                      echo '<option value="Pending">Pending</option>';
                                  }
                                  ?>
                              </select>
                          </div>

                                  <div class="col-6">
                                  <label for="Items" class="mb-1"></label>
                                  <input type="submit" class="btn btn-info btn-user btn-block mt-4" name="btnDelivery" value="Update Status">
                                  </div>
                                
                              </div>        
                              <div class="form-group row">
                              <div class="col-sm-6 mb-3 mb-sm-0">
                              <label for="Items" class="mb-1">Order-Status</label>
                              <select name="cboStatus" class="form-select">
                                  <option value="<?php echo $arr['Status']; ?>" selected><?php echo $arr['Status']; ?></option>
                                  <?php
                                  // Toggle between "Pending" and "Confirmed"
                                  if ($arr['Status'] == 'Accepted') {
                                      echo '<option value="Declined">Declined</option>';
                                  } else {
                                      echo '<option value="Accepted">Accepted</option>';
                                  }
                                  ?>
                              </select>
                          </div>

                                  <div class="col-6">
                                  <label for="Items" class="mb-2"></label>
                                  <input type="submit" class="btn btn-info btn-user btn-block mt-4" name="btnStatus" value="Update Status">
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

</htmb>