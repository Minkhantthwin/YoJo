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

$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';

include('purchase-paginate.php');

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

	<title>Purchase-List | Hero-Fitness</title>

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

					<h1 class="h3 mb-3 text-center">Purchase-List</h1>

					<div class="row">
						<div class="col-12">
						<div class="card">
					<div class="card-header">
						<form method="GET">
							<div class="row align-items-center">
								<div class="col-md-6">
									<a href="purchase.php" class="btn btn-primary">+ Purchase</a>
								</div>
								<div class="col-md-6 text-end">
									<div class="input-group">
										<input type="text" name="search" class="form-control bg-light border-1 small" placeholder="Search purchase..."
											aria-label="Search" value="<?php echo htmlspecialchars($searchTerm); ?>">
										<button class="btn btn-primary" type="submit">
											<i class="align-middle" data-feather="search"></i>
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>

					<!-- Display Table -->
					<div class="card-body">
						<table class="table my-0 text-center">
							<thead>
								<tr>
									<th>ID</th>
									<th>Purchase-Date</th>
									<th>Total-Amount</th>
									<th>Quantity</th>
									<th>Purchased-Products</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if ($size < 1) {
									echo "<tr><td colspan='7'>No Record Found!</td></tr>";
								} else {
									while ($arr = mysqli_fetch_assoc($result)) {
										echo "<tr>";
										echo "<td>" . $arr['purchaseCode'] . "</td>";
										echo "<td>" . $arr['purchaseDate'] . "</td>";
										echo "<td>" . $arr['totalAmount'] . " $</td>";
										echo "<td>" . $arr['totalQuantity'] . "</td>";
										echo "<td>" . $arr['Items'] . "</td>";
										echo "<td>" . $arr['status'] . "</td>";
										echo "<td><a class='btn btn-info' href='purchaseDetail.php?purchaseCode=" . $arr['purchaseCode'] . "'>Detail</a></td>";
										echo "</tr>";
									}
								}
								?>
							</tbody>
						</table>
						<div class="row align-items-center">
							<div class="col-12 text-center">
							<div class="btn-group mt-3" role="group" aria-label="Pagination">
							<!-- Previous Button -->
							<button type="button" class="btn btn-secondary"
								<?php if ($currentPage <= 1) { echo 'disabled'; } ?> 
								onclick="window.location.href='?page=<?php echo $currentPage - 1; ?>&search=<?php echo urlencode($searchTerm); ?>'">
								<i class="align-middle" data-feather="arrow-left-circle"></i>
							</button>
							
							<!-- Current Page Number -->
							<button type="button" class="btn btn-primary">
								<?php echo $currentPage; ?>
							</button>

							<!-- Next Button -->
							<button type="button" class="btn btn-secondary" 
								<?php if ($currentPage >= $totalPages) { echo 'disabled'; } ?> 
								onclick="window.location.href='?page=<?php echo $currentPage + 1; ?>&search=<?php echo urlencode($searchTerm); ?>'">
								<i class="align-middle" data-feather="arrow-right-circle"></i>
							</button>
						</div>
							</div>
						</div>
        <!-- Pagination Buttons -->
					
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