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

include('customer-paginate.php');

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

					<h1 class="h3 mb-3 text-center">Guest-Member-List</h1>

					<div class="row">
						<div class="col-12">
						<?php
                            $query = "SELECT * FROM customer WHERE MembershipID IS NULL";
							$result = mysqli_query($connect, $query);
							$size = mysqli_num_rows($result);

							if ($size < 1) {
							echo "<p>No Record Found!</p>";
							} else {
							?>    
						<div class="card">
							<div class="card-header">
							<div class="row align-items-center">
								<!-- Left side: Create New Order button -->
								<div class="col-md-6">
									<a href="customer.php" class="btn btn-primary">Registration</a>
								</div>

								<!-- Right side: Search bar -->
								
							</div>
						</div>
						<div class="card-body">
								<table class="table mb-3 text-center">
									<thead>
										<tr>
											<th>ID</th>
											<th>Name</th>
											<th>Email</th>
											<th>Phone</th>
											<th class="d-none d-md-table-cell">NRC</th>
											<th class="d-none d-md-table-cell">Password</th>
											<th>Update</th>
										</tr>
									</thead>
									<tbody>
										
									<?php
									if (mysqli_num_rows($resultGuest) > 0) {
										while ($arr = mysqli_fetch_array($resultGuest)) {
											echo "<tr>";
											echo "<td> C-" . $arr['CustomerID'] . "</td>";
											echo "<td>" . $arr['CustomerName'] . "</td>";
											echo "<td>" . $arr['Email'] . "</td>";
											echo "<td>" . $arr['Phone'] . "</td>";
											echo "<td class='d-none d-md-table-cell'>" . $arr['NRC'] . "</td>";
											echo "<td class='d-none d-md-table-cell'>" . $arr['Password'] . "</td>";
											echo "<td><a class='btn btn-info' href='customer-membership.php?CustomerID=" . $arr['CustomerID'] . "'>Membership</a></td>";
											echo "</tr>";
										}
									}
									?>								
											<?php
											}
											?>
									</tbody>
								</table>
								<div class="row align-items-center">
									<div class="col-12 text-center">
									<!-- Pagination for Guest Members using Button Group -->
								<div class="btn-group mb-3" role="group" aria-label="Guest members pagination">
									<!-- Previous Button -->
									<button type="button" class="btn btn-secondary"
										<?php if ($guestPage <= 1) { echo 'disabled'; } ?> 
										onclick="window.location.href='?guestPage=<?php echo $guestPage - 1; ?>'">
										<i class="align-middle" data-feather="arrow-left-circle"></i>
									</button>
									
									<!-- Page Numbers -->
									<button type="button" class="btn btn-primary">
										<?php echo $guestPage; ?>
									</button>

									<!-- Next Button -->
									<button type="button" class="btn btn-secondary" 
										<?php if ($guestPage >= $totalGuestPages) { echo 'disabled'; } ?> 
										onclick="window.location.href='?guestPage=<?php echo $guestPage + 1; ?>'">
										<i class="align-middle" data-feather="arrow-right-circle"></i>
									</button>
								</div>
									</div>
								</div>
								</div>
							</div>
						</div>
					</div>

					<?php
		$query = "SELECT * FROM customer
		          WHERE MembershipID IS NOT NULL AND MembershipID != ''";
		$result = mysqli_query($connect, $query);
		$size = mysqli_num_rows($result);
		$arr = mysqli_fetch_array( $result);

		if ($size < 1) {
			echo "<h3 class='mb-3 text-center'>There are no registered members.</h3>";
		} else {
		?>    				
<h1 class="h3 mb-3 text-center">Member-list</h1>

<div class="row">
	<div class="col-12">
	
	<div class="card">
		<div class="card-header">
		<div class="row align-items-center">
			<!-- Left side: Create New Order button -->
			<div class="col-md-6">
				<a href="customer.php" class="btn btn-primary">Registration</a>
			</div>

			<!-- Right side: Search bar -->
			
		</div>
	</div>
	<div class="card-body">
			<table class="table mb-3 text-center">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Membership</th>
						<th class="d-none d-md-table-cell">Start-Date</th>
						<th class="d-none d-md-table-cell">End-Date</th>
						<th>Update</th>
					</tr>
				</thead>
				<tbody>
					
				<?php
					if (mysqli_num_rows($resultMember) > 0) {
						while ($arr = mysqli_fetch_array($resultMember)) {
							echo "<tr>";
							echo "<td> C-" . $arr['CustomerID'] . "</td>";
							echo "<td>" . $arr['CustomerName'] . "</td>";
							echo "<td>" . $arr['Email'] . "</td>";
							echo "<td>" . $arr['Phone'] . "</td>";
							echo "<td>" . $arr['MembershipID'] . "</td>";
							echo "<td class='d-none d-md-table-cell'>" . $arr['Start_Date'] . "</td>";
							echo "<td class='d-none d-md-table-cell'>" . $arr['End_Date'] . "</td>";
							echo "<td><a class='btn btn-info' href='customer-membership.php?CustomerID=" . $arr['CustomerID'] . "'>Membership</a></td>";
							echo "</tr>";
						}
					}
					?>
						<?php
						}
						?>
				</tbody>
			</table>
			<div class="row align-items-center">
				<div class="col-12 text-center">
				<!-- Pagination for Registered Members using Button Group -->
				<div class="btn-group mb-3" role="group" aria-label="Registered members pagination">
					<!-- Previous Button -->
					<button type="button" class="btn btn-secondary"
						<?php if ($memberPage <= 1) { echo 'disabled'; } ?> 
						onclick="window.location.href='?memberPage=<?php echo $memberPage - 1; ?>'">
						<i class="align-middle" data-feather="arrow-left-circle"></i>
					</button>
					
					<!-- Current Page Number -->
					<button type="button" class="btn btn-primary">
						<?php echo $memberPage; ?>
					</button>

					<!-- Next Button -->
					<button type="button" class="btn btn-secondary" 
						<?php if ($memberPage >= $totalMemberPages) { echo 'disabled'; } ?> 
						onclick="window.location.href='?memberPage=<?php echo $memberPage + 1; ?>'">
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