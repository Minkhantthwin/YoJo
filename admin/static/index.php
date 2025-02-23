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

include('order-paginate.php');

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

	<title>Dashboard | JoJo-Hotpot</title>

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

					<h1 class="h3 mb-3">Admin-List</h1>

					<div class="row">
						<div class="col-12">
						<?php
                            $query1 = "SELECT * FROM admin ";
							$result1 = mysqli_query($connect, $query1);
							$size1 = mysqli_num_rows($result1);

							if ($size1 < 1) {
							echo "<p>No Record Found!</p>";
							} else {
							?>    
							<div class="card">
								<div class="card-header">
								<div class="row align-items-center">
								
								<div class="col-md-6">
									<a href="sign-up.php" class="btn btn-danger"><i class="align-middle" data-feather="log-in"></i> Sign Up</a>
								</div>
	
							</div>
								</div>
								<div class="card-body">
								<table class="table my-0">
									<thead>
										<tr>
											<th>ID</th>
											<th>Name</th>
											<th>Email</th>
											<th>Phone</th>
											<th class="d-none d-md-table-cell">NRC</th>
											<th class="d-none d-md-table-cell">Password</th>
										</tr>
									</thead>
									<tbody>
										
										<?php
												for ($i = 0; $i < $size1; $i++) {
												$array = mysqli_fetch_array( $result1);
												$ID = $array['AdminID'];
												echo "<tr>";
												echo "<td> A-". $ID ."</td> ";	
											echo"<td>". $array['AdminName'] ."</td>";
											echo"<td>". $array['Email'] ."</td>";
											echo"<td>". $array['Phone'] ."</td>";
											echo "<td class='d-none d-md-table-cell'>". $array['NRC'] ."</td>";
											echo "<td class='d-none d-md-table-cell'>". $array['Password'] ."</td>";
									     	    echo "</tr>";	    
											} 
											?>
									
											<?php
											}
											?>
									</tbody>
								</table>
								</div>
							</div>
						</div>
					</div>
					<h1 class="h3 mb-3">Order-List</h1>
					<div class="row">

						<div class="col-12">
					
							<div class="card">
							<div class="card-header">
							<div class="row align-items-center">
								<!-- Left side: Create New Order button -->
							

								<!-- Right side: Search bar -->
								<div class="col-md-12 text-end">
									<div class="input-group">
										<input type="text" name="search" class="form-control bg-light border-1 small" placeholder="Search purchase..."
											aria-label="Search" value="<?php echo htmlspecialchars($searchTerm); ?>">
										<button class="btn btn-danger" type="submit">
											<i class="align-middle" data-feather="search"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
								<div class="card-body">
								<table class="table table-hover my-0 text-center">
								<thead>
                    <tr>
                        <th>Order-ID</th>
                        <th>C-ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>D-Status</th>
                        <th>Products</th>
                        <th>Detail</th>
                    </tr>
                </thead>
              
            <tbody>
            <tr>
            <?php
                            while ($arr = mysqli_fetch_assoc($result)) {
                                $OrderID = $arr['OrderID'];
                                $CustomerID = $arr['CustomerID'];

                                echo "<tr>";
                                echo "<td>" . $OrderID . "</td>";
                                echo "<td> C-" . $CustomerID . "</td>";
                                echo "<td>" . $arr['OrderDate'] . "</td>";  
                                echo "<td>" . $arr['Status'] . "</td>";
                                echo "<td>" . $arr['DeliveryStatus'] . "</td>";
                                echo "<td>" . $arr['Items'] . "</td>";

                                echo"<td>";

                                
                                 echo "<a class='btn btn-info' href='orderDetail.php?OrderID=$OrderID'>-></a>";
                                
                              
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
								</table>
								<div class="row align-items-center mb-3">
							<div class="col-12 text-center">
							<div class="btn-group mt-3" role="group" aria-label="Pagination">
    <!-- Previous Button -->
    <button type="button" class="btn btn-dark"
        <?php if ($currentPage <= 1) { echo 'disabled'; } ?>
        onclick="window.location.href='?page=<?php echo $currentPage - 1; ?>&search=<?php echo urlencode($searchTerm); ?>'">
        <i class="align-middle" data-feather="arrow-left-circle"></i>
    </button>
    
    <!-- Current Page Number -->
    <button type="button" class="btn btn-danger">
        <?php echo $currentPage; ?>
    </button>

    <!-- Next Button -->
    <button type="button" class="btn btn-dark" 
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