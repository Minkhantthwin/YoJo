<?php

session_start();
include('connect.php');

$ID = $_GET['BookingID'];

if(!isset($_SESSION['AdminID']))
{
	echo "<script>window.location='sigin-in.php'</script>";
}

$AdminID = $_SESSION['AdminID'];

$selectAdmin = "SELECT AdminName FROM admin WHERE AdminID = '$AdminID'";
$resultAdmin = mysqli_query($connect, $selectAdmin);
$rowAdmin = mysqli_fetch_assoc($resultAdmin);
$AdminName = $rowAdmin['AdminName'];



// Fetch booking details
// Update the query
$query = "SELECT b.*, t.TableNumber 
          FROM booking b 
          JOIN tables t ON b.TableID = t.TableID 
          WHERE b.BookingID = '$ID'";
$result = mysqli_query($connect, $query);
$booking = mysqli_fetch_assoc($result);

// Handle form submission
if(isset($_POST['btnUpdate'])) {
    $newStatus = $_POST['status'];
  
    $updateQuery = "UPDATE booking 
                   SET status = '$newStatus'
                   WHERE BookingID = '$ID'";
    
    if(mysqli_query($connect, $updateQuery)) {
        echo "<script>window.alert('Booking updated successfully!')</script>";
        echo "<script>window.location='booking-list.php'</script>";
    } else {
        echo "<script>window.alert('Error updating booking.')</script>";
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

					<h1 class="h3 mb-3 text-center">Update-Booking</h1>

					<div class="row">
						<div class="col-12">
						<div class="card">
							<div class="card-header">
							<div class="row align-items-center">
								<!-- Left side: Create New Order button -->
								<div class="col-md-6">
									<a href="booking-list.php" class="btn btn-danger"><- Booking-List</a>
								</div>

							
							</div>
						</div>
		
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label">Customer Name</label>
                                                <input type="text" class="form-control" value="<?php echo $booking['CustomerName']; ?>" readonly />
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" value="<?php echo $booking['CustomerPhone']; ?>" readonly />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control" value="<?php echo $booking['CustomerEmail']; ?>" readonly />
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Table Number</label>
                                                <input type="text" class="form-control" value="<?php echo $booking['TableNumber']; ?>" readonly />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label">Booking Date</label>
                                                <input type="text" class="form-control" value="<?php echo $booking['booking_date']; ?>" readonly />
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Booking Time</label>
                                                <input type="text" class="form-control" value="<?php echo $booking['booking_time']; ?>" readonly />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label">Number of Guests</label>
                                                <input type="number" class="form-control" name="guests" value="<?php echo $booking['guests']; ?>" max="8" readonly/>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Status</label>
                                                <select class="form-select" name="status" required>
                                                    <option value="Pending" <?php if($booking['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                                    <option value="Confirmed" <?php if($booking['status'] == 'Confirmed') echo 'selected'; ?>>Confirmed</option>
                                                    <option value="Completed" <?php if($booking['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                                                    <option value="Cancelled" <?php if($booking['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 text-end">
                                                <a href="booking-list.php" class="btn btn-secondary">Back</a>
                                                <button type="submit" name="btnUpdate" class="btn btn-danger">Update Booking</button>
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

</html>