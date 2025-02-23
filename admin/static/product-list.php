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

	<title>Product-list | Hero-Fitness</title>

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

                <h1 class="h3 mb-3 text-center">Product-List</h1>
					<div class="row">
						<div class="col-12">
							<form method="GET">
							<div class="card">
							<div class="card-header">
							<div class="row align-items-center">
								<!-- Left side: Create New Order button -->
								<div class="col-md-6">
									<a href="product.php" class="btn btn-primary">+ Create New Product</a>
								</div>

								<!-- Right side: Search bar -->
								<div class="col-md-6 text-end">
									<div class="input-group">
										<input type="text" name="search" class="form-control bg-light border-1 small" placeholder="Search product..."
											aria-label="Search" value="<?php echo htmlspecialchars($searchTerm); ?>">
										<button class="btn btn-primary" type="submit">
											<i class="align-middle" data-feather="search"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
						</form>
								<div class="card-body">
                                <?php
                            $query = "SELECT p.*, pt.productTypeName 
                                      FROM product p
                                      JOIN product_type pt ON p.productTypeCode = pt.productTypeCode
									   WHERE p.productCode LIKE '%$searchTerm%'
										OR p.productName LIKE '%$searchTerm%'
										OR p.remark LIKE '%$searchTerm%'
										OR pt.productTypeName LIKE '%$searchTerm%'
										GROUP BY p.productCode
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
                                            <th>P-ID</th>
											<th>P-Name</th>
											<th class="d-none d-md-table-cell">P-Type</th>
											<th>Price</th>
											<th>Quantity</th>
                                            <th class="d-none d-md-table-cell">Description</th>
											<th class="d-none d-md-table-cell">Remark</th>
                                            <th class="d-none d-md-table-cell">Image</th>
                                            <th colspan="2">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
												for ($i = 0; $i < $size; $i++) {
												$arr = mysqli_fetch_array( $result);
												$ID = $arr['productCode'];
										    echo "<tr>";
											echo "<td> P-". $ID ."</td> ";	
											echo"<td>". $arr['productName'] ."</td>";
											echo"<td class='d-none d-md-table-cell'>". $arr['productTypeName'] ."</td>";
											echo"<td>". $arr['price'] ."$</td>";
                                            echo"<td>". $arr['quantity'] ."</td>";
											// echo "<td class='d-none d-md-table-cell'>". $arr['description'] ."</td>";
											echo "<td class='d-none d-md-table-cell'>". $arr['remark'] ."</td>";
                                            echo "<td class='d-none d-md-table-cell'>". $arr['photo'] ."</td>";
                                            echo "<td>
                                            <a class='btn btn-success' href='productUpdate.php?productCode=$ID'>Edit</a>
                                            
                                                </td>";
                                             echo "<td>
                                           
                                            <a class='btn btn-danger' href='productDelete.php?productCode=$ID'>Delete</a>
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