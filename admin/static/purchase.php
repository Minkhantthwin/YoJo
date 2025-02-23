<?php
session_start();
include('connect.php');
include('auto_id.php');
include('Purchase_Functions.php');

if(!isset($_SESSION['AdminID']))
{
	echo "<script>window.location='sigin-in.php'</script>";
}

$AdminID = $_SESSION['AdminID'];
$selectAdmin = "SELECT AdminName FROM admin WHERE AdminID = '$AdminID'";
$resultAdmin = mysqli_query($connect, $selectAdmin);
$rowAdmin = mysqli_fetch_assoc($resultAdmin);
$AdminName = $rowAdmin['AdminName'];


if (isset($_POST['btnAdd'])) {
    $ProductID = $_POST['cboProductID'];
    $PurchasePrice = $_POST['txtPurchasePrice'];
    $PurchaseQuantity = $_POST['txtPurchaseQuantity'];

   
    if ($PurchasePrice < 1) {
        echo "<script>window.alert('Please enter correct price.')</script>";
        echo "<script>window.location='purchase.php'</script>";
    } 
    elseif ($PurchaseQuantity < 1){
        echo "<script>window.alert('Please enter correct Quantity.')</script>";
        echo "<script>window.location='purchase.php'</script>";
   
    }
    else {

        AddProduct($ProductID, $PurchasePrice, $PurchaseQuantity);
    }
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'remove') {
        $ProductID = $_GET['ProductID'];
        RemoveProduct($ProductID);
    } elseif ($_GET['action'] == 'clearall') {
        Clearall();
    }
}

if (isset($_POST['btnSave'])) {
    $txtPurchaseID = $_POST['txtPurchaseID'];
    $txtPurchaseDate = date('Y-m-d', strtotime($_POST['txtPurchaseDate']));
    $cboSupplierID = $_POST['cboSupplierID'];
    $txtTotalQuantity = $_POST['txtTotalQuantity'];
    $txtTotalAmount = $_POST['txtTotalAmount'];


    $StaffID = $_SESSION['AdminID'];
    $Status = "Pending";

    $Insert1 = "INSERT INTO `purchase`(`purchaseCode`, `supplierID`, `adminID`, `purchaseDate`, `totalAmount`, `totalQuantity`, `grandTotal`, `status`) 
                VALUES 
            ('$txtPurchaseID','$cboSupplierID','$StaffID','$txtPurchaseDate','$txtTotalAmount','$txtTotalQuantity','','$Status')
            ";
    $result = mysqli_query($connect, $Insert1);

    $size = count($_SESSION['Purchase_Functions']);

    for ($x = 0; $x < $size; $x++) {
        $ProductID = $_SESSION['Purchase_Functions'][$x]['ProductID'];
        $PurchasePrice = $_SESSION['Purchase_Functions'][$x]['PurchasePrice'];
        $PurchaseQuantity = $_SESSION['Purchase_Functions'][$x]['PurchaseQuantity'];

        $Insert2 = "INSERT INTO `purchasedetail`
				 (`purchaseCode`, `productCode`, `purchasePrice`, `purchaseQuantity`) 
				  VALUES 
				 ('$txtPurchaseID','$ProductID','$PurchasePrice','$PurchaseQuantity')
				 ";
        $result = mysqli_query($connect, $Insert2);

        $UpdateProduct = "UPDATE `product` 
        SET `quantity` = `quantity` + $PurchaseQuantity 
        WHERE `productCode` = '$ProductID'";
        mysqli_query($connect, $UpdateProduct);
    }

    if ($result)  //true
    {
        unset($_SESSION['Purchase_Functions']);

        echo "<script>window.alert('Successfully Purchase!')</script>";
        echo "<script>window.location='purchase-list.php'</script>";
    } else {
        echo "<p>Something went wrong in Purchase Form : " . mysqli_error($connect) . "</p>";
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

	<title>Purchase-Form | HERO-FITNESS</title>

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

					<h1 class="h3 mb-3 text-center">Purchase Form</h1>

					<div class="row">
						<div class="col-12">
                        <div class="card">
								<div class="card-header">
                                <a href="purchase-list.php" class="btn btn-primary">Purchase List -></a>
								</div>
								<div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                        <div class="row mb-2">
                                            <div class="col-6">
                                            <label class="form-label">Purchase-Code</label>
											<input class="form-control form-control-lg" type="text" name="txtPurchaseID" value="<?php echo AutoID('purchase', 'purchaseCode', 'PUR-', 6) ?>" readonly />
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Purchase-Date</label>
											<input class="form-control form-control-lg" type="date" name="txtPurchaseDate" value="<?php echo date('Y-m-d') ?>" readonly/>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                            <label class="form-label">Total-Quantity</label>
											<input class="form-control form-control-lg" type="text"name="txtTotalQuantity" value="<?php echo totalQuantity() ?>" readonly/>
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Total-Amount</label>
											<input class="form-control form-control-lg" type="text"  name="txtTotalAmount" value="<?php echo CalculateTotalAmount() ?>" readonly/>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                            <label class="form-label">Choose Product</label>
                                            <select class="form-select" name="cboProductID">
                                                
                                                <?php
                                                $PQuery = "SELECT * FROM product order by productName ";
                                                $Presult = mysqli_query($connect, $PQuery);
                                                $Pcount = mysqli_num_rows($Presult);

                                                for ($i = 0; $i < $Pcount; $i++) {
                                                    $Parr = mysqli_fetch_array($Presult);

                                                    $cboProductID = $Parr['productCode'];
                                                    $ProductName = $Parr['productName'];

                                                    echo "<option value='$cboProductID'>$cboProductID-$ProductName</option>";
                                                }
                                                ?>
                                            </select>
                                            </div>  
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                            <label class="form-label">Purchase Price</label>
											<input class="form-control form-control-lg" type="number" name="txtPurchasePrice" placeholder="Enter Price" />
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Purchase Quantity</label>
											<input class="form-control form-control-lg" type="number" name="txtPurchaseQuantity" placeholder="Enter Quantity" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 text-center">
                                            <input type="submit" class="btn btn-lg btn-primary" name="btnAdd" value="Add">
                                            <input type="submit" class="btn btn-lg btn-danger" name="btnClear" value="Clear">
                                           
                                            </div>                              
                                        </div>
                                 
								</div>
						</div>
						</div>
					</div>
                    <?php
                    if (!isset($_SESSION['Purchase_Functions'])) {
                        echo "<h3 class='mb-3 text-center'>No Purchase Record Found.</h3>";
                    } else {
                    ?>
					<h1 class="h3 mb-3 text-center">Purchase's Detail</h1>

					<div class="row">
						<div class="col-12">
                        <div class="card">
								<div class="card-body">
                                <table class="table my-0 text-center">
                            <tr>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Purchase Price</th>
                                <th>Purchase Quantity</th>
                                <th>Sub-Total</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            $size = count($_SESSION['Purchase_Functions']);

                            for ($i = 0; $i < $size; $i++) {
                                $ProductID = $_SESSION['Purchase_Functions'][$i]['ProductID'];

                                echo "<tr>";
                                echo "<td>" . $_SESSION['Purchase_Functions'][$i]['ProductID'] . "</td>";
                                echo "<td>" . $_SESSION['Purchase_Functions'][$i]['ProductName'] . "</td>";
                                echo "<td>" . $_SESSION['Purchase_Functions'][$i]['PurchasePrice'] . "</td>";
                                echo "<td>" . $_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'] . "</td>";
                                echo "<td>" . $_SESSION['Purchase_Functions'][$i]['PurchasePrice'] * $_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'] . "</td>";
                                echo "<td> <a href='purchase.php?ProductID=$ProductID&action=remove'class='delete none-line'><i class='align-middle me-2' data-feather='trash-2'></i>Remove</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
								</div>
                                <div class="card-footer">
                                <div class="row mb-3">
                                 <div class="col-6">
                                 <label class="form-label">Choose supplier for purchase</label>
                                 <select class="form-select" name="cboSupplierID">
                                        <?php
                                        $SQuery = "SELECT * FROM supplier WHERE status = 'active'";
                                        $Sresult = mysqli_query($connect, $SQuery);
                                        $Scount = mysqli_num_rows($Sresult);

                                        for ($i = 0; $i < $Scount; $i++) {
                                            $Sarr = mysqli_fetch_array($Sresult);

                                            $cboSupplierID = $Sarr['supplierID'];
                                            $SupplierName = $Sarr['supplierName'];

                                            echo "<option value='$cboSupplierID' selected>$SupplierName</option>";
                                        }
                                        ?>
                                    </select>
                                  </div>
                                 <div class="col-6 text-end">  
                                <input type="submit" class="btn btn-lg btn-primary" name="btnSave" value="Purchase">
                                <a href="purchase.php?action=clearall" class="btn btn-lg btn-primary">Clear All</a>                                    </div>                              
                                </div>
                                </div>
							</div>
						</div>
					</div>
                    <?php
                    }
                    ?>
                  </form>
				</div>
			</main>

		
			<?php include('refactor/footer.php'); ?>
		</div>
	</div>

	<script src="js/app.js"></script>

</body>

</html>