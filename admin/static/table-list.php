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

	<title>Table List | JOJO-Hotpot</title>

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
					<h1 class="h3 mb-3 text-center">Table List</h1>

					<div class="row">
						<div class="col-12">
						<div class="card">
							<div class="card-header">
							<form method="GET">
								<div class="row align-items-center">
									<div class="col-md-6">
										<a href="table.php" class="btn btn-danger">+ New Table</a>
									</div>
									<div class="col-md-6 text-end">
										<div class="input-group">
											<input type="text" name="search" class="form-control bg-light border-1 small" 
											           placeholder="Search table..." value="<?php echo htmlspecialchars($searchTerm); ?>">
											<button class="btn btn-danger" type="submit">
												<i class="align-middle" data-feather="search"></i>
											</button>
										</div>
									</div>
								</div>
							</form>
						</div>
							<div class="card-body">
							    <?php
							    $query = "SELECT * FROM tables";
							    if (!empty($searchTerm)) {
							        $query .= " WHERE TableNumber LIKE '%$searchTerm%'";
							    }
							    $result = mysqli_query($connect, $query);
							    $count = mysqli_num_rows($result);

							    if ($count < 1) {
							        echo "<p class='text-center'>No Tables Found!</p>";
							    } else {
							    ?>
							    <table class="table my-0 text-center">
							        <thead>
							            <tr>
							                <th>Table ID</th>
							                <th>Table Number</th>
							                <th>Location</th>
							                <th>Action</th>
							            </tr>
							        </thead>
							        <tbody>
							            <?php
							            while ($row = mysqli_fetch_assoc($result)) {
							                echo "<tr>";
							                echo "<td>" . $row['TableID'] . "</td>";
							                echo "<td>" . $row['TableNumber'] . "</td>";
							                echo "<td>" . ($row['Location'] ? $row['Location'] : 'Not Specified') . "</td>";
							                echo "<td>
							                        <a href='table-update.php?TableID=" . $row['TableID'] . "' class='btn btn-success btn-sm'>Edit</a>
							                        <a href='table-delete.php?TableID=" . $row['TableID'] . "' class='btn btn-danger btn-sm' 
							                           onclick='return confirm(\"Are you sure you want to delete this table?\")'>Delete</a>
							                      </td>";
							                echo "</tr>";
							            }
							            ?>
							        </tbody>
							    </table>
							    <?php
							    }
							    ?>
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