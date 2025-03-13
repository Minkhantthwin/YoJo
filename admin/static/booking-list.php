<?php

session_start();
include('connect.php');

if(!isset($_SESSION['AdminID']))
{
    echo "<script>window.location='sign-in.php'</script>";
}

$AdminID = $_SESSION['AdminID'];

$selectAdmin = "SELECT AdminName FROM admin WHERE AdminID = '$AdminID'";
$resultAdmin = mysqli_query($connect, $selectAdmin);
$rowAdmin = mysqli_fetch_assoc($resultAdmin);
$AdminName = $rowAdmin['AdminName'];

$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';

// Pagination settings
$recordsPerPage = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $recordsPerPage;

// Query with search and pagination
// Update the main query
$query = "SELECT b.*, t.TableNumber 
          FROM booking b 
          JOIN tables t ON b.TableID = t.TableID";

if (!empty($searchTerm)) {
    $query .= " WHERE b.CustomerName LIKE '%$searchTerm%' 
                OR b.CustomerPhone LIKE '%$searchTerm%'
                OR b.booking_date LIKE '%$searchTerm%' 
                OR b.status LIKE '%$searchTerm%'";
}

$query .= " ORDER BY b.created_at DESC LIMIT $offset, $recordsPerPage";

// Execute the main query
$result = mysqli_query($connect, $query);

// Update total records query
$totalQuery = "SELECT COUNT(*) as total FROM booking b";
if (!empty($searchTerm)) {
    $totalQuery .= " WHERE b.CustomerName LIKE '%$searchTerm%' 
                     OR b.CustomerPhone LIKE '%$searchTerm%'
                     OR b.booking_date LIKE '%$searchTerm%' 
                     OR b.status LIKE '%$searchTerm%'";
}
$totalResult = mysqli_query($connect, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);
$currentPage = $page;
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
					<h1 class="h3 mb-3 text-center">Booking List</h1>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<form method="GET">
										<div class="row align-items-center">
											<div class="col-md-6">
												<a href="booking.php" class="btn btn-danger">+ New Booking</a>
											</div>
											<div class="col-md-6 text-end">
												<div class="input-group">
													<input type="text" name="search" class="form-control bg-light border-1 small" 
															placeholder="Search booking..." value="<?php echo htmlspecialchars($searchTerm); ?>">
													<button class="btn btn-danger" type="submit">
														<i class="align-middle" data-feather="search"></i>
													</button>
												</div>
											</div>
										</div>
									</form>
								</div>

								<div class="card-body">
									<table class="table my-0 text-center">
										<thead>
											<tr>
												<th>Booking ID</th>
												<th>Customer Name</th>
												<th>Phone</th>
												<th>Table</th>
												<th>Date</th>
												<th>Time</th>
												<th>Guests</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if (mysqli_num_rows($result) < 1) {
												echo "<tr><td colspan='9'>No Record Found!</td></tr>";
											} else {
												while ($row = mysqli_fetch_assoc($result)) {
													echo "<tr>";
													echo "<td>" . $row['BookingID'] . "</td>";
													echo "<td>" . $row['CustomerName'] . "</td>";
													echo "<td>" . $row['CustomerPhone'] . "</td>";
													echo "<td>" . $row['TableNumber'] . "</td>";
													echo "<td>" . $row['booking_date'] . "</td>";
													echo "<td>" . $row['booking_time'] . "</td>";
													echo "<td>" . $row['guests'] . "</td>";
													echo "<td>" . $row['status'] . "</td>";
													echo "<td>
															<a class='btn btn-secondary btn-sm' href='booking-detail.php?BookingID=" . $row['BookingID'] . "'>Detail</a>
														</td>";
													echo "</tr>";
												}
											}
											?>
										</tbody>
									</table>

									<!-- Pagination -->
									<div class="row align-items-center">
										<div class="col-12 text-center">
											<div class="btn-group mt-3" role="group" aria-label="Pagination">
												<button type="button" class="btn btn-secondary"
													<?php if ($currentPage <= 1) { echo 'disabled'; } ?> 
													onclick="window.location.href='?page=<?php echo $currentPage - 1; ?>&search=<?php echo urlencode($searchTerm); ?>'">
													<i class="align-middle" data-feather="arrow-left-circle"></i>
												</button>
												
												<button type="button" class="btn btn-danger">
													<?php echo $currentPage; ?>
												</button>

												<button type="button" class="btn btn-secondary" 
													<?php if ($currentPage >= $totalPages) { echo 'disabled'; } ?> 
													onclick="window.location.href='?page=<?php echo $currentPage + 1; ?>&search=<?php echo urlencode($searchTerm); ?>'">
													<i class="align-middle" data-feather="arrow-right-circle"></i>
												</button>
											</div>
										</div>
									</div>
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