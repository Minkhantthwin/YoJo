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

	<title>Supplier-List | JoJo-Hotpot</title>

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

					<h1 class="h3 mb-3 text-center">Supplier-List</h1>

					<div class="row">
						<div class="col-12">
						<div class="card">
							<div class="card-header">
							<div class="row align-items-center">
								<!-- Left side: Create New Order button -->
								<div class="col-md-6">
									<a href="supplier.php" class="btn btn-danger">+ Add Supplier</a>
								</div>

								<!-- Right side: Search bar -->
							
							</div>
						</div>
                                <div class="card-body">
                                <?php
                            $query = "SELECT * FROM supplier
                                     ";
							$result = mysqli_query($connect, $query);
							$size = mysqli_num_rows($result);

							if ($size < 1) {
							echo "<p>No Record Found!</p>";
							} else {
							?>    
								<table class="table my-0 text-center">
									<thead>
										<tr>
                                            <th>Supplier-ID</th>
											<th>Name</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th colspan="2">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
												for ($i = 0; $i < $size; $i++) {
												$arr = mysqli_fetch_array( $result);
												$ID = $arr['supplierID'];
										    echo "<tr>";
											echo "<td> S-". $ID ."</td> ";	
											echo"<td>". $arr['supplierName'] ."</td>";
                                            echo"<td>". $arr['email'] ."</td>";
											echo"<td>". $arr['address'] ."</td>";
                                            echo"<td>". $arr['status'] ."</td>";
                                            echo "<td>
                                            <a class='btn btn-success' href='supplierUpdate.php?supplierID=$ID'>Edit</a>
                                            
                                                </td>";
                                             echo "<td>
                                           
                                            <a class='btn btn-dark' href='supplierDelete.php?supplierID=$ID'>Delete</a>
                                                </td>";   
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
					
					

				</div>
			</main>

		
			<?php include('refactor/footer.php'); ?>
		</div>
	</div>

	<script src="js/app.js"></script>

</body>

</html>