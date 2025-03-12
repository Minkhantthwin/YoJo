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

if (isset($_POST['btnsave']))
{
    $bookingDate = $_POST['bookingDate'];
    $bookingTime = $_POST['bookingTime'];
    $guests = $_POST['guests'];
    $customerID = $_POST['customer'];
    $tableID = $_POST['table']; // Fixed the name attribute to match the form
    $status = 'Pending';

    // Check if the table is already booked for the same date and time
    $select = "SELECT * FROM booking 
               WHERE TableID='$tableID' 
               AND booking_date='$bookingDate' 
               AND booking_time='$bookingTime'";
    $ret = mysqli_query($connect, $select);
    $count = mysqli_num_rows($ret);

    // Convert booking time to timestamps for comparison
    $bookingDateTime = strtotime("$bookingDate $bookingTime");
    $oneHourBefore = date('H:i', strtotime('-1 hour', $bookingDateTime));
    $oneHourAfter = date('H:i', strtotime('+1 hour', $bookingDateTime));

    // Check if the table is already booked within the one-hour window
    $select = "SELECT * FROM booking 
               WHERE TableID = '$tableID' 
               AND booking_date = '$bookingDate'
               AND booking_time BETWEEN '$oneHourBefore' AND '$oneHourAfter'
               AND status != 'Cancelled'";
    $ret = mysqli_query($connect, $select);
    $count = mysqli_num_rows($ret);

    if ($count > 0)
    {
        echo "<script>window.alert('This table is not available at this time. Please choose a different time with at least 1 hour gap from existing bookings.')</script>";
    }
    else
    {
        $query = "INSERT INTO booking(booking_date, booking_time, guests, CustomerID, TableID, status) 
                  VALUES ('$bookingDate', '$bookingTime', '$guests', '$customerID', '$tableID', '$status')";
        $result = mysqli_query($connect, $query);

        if ($result) {
            echo "<script>window.alert('Booking has been successfully registered!')</script>";
            echo "<script>window.location='booking-list.php'</script>";
        }
        else {
            echo "<script>window.alert('Error in booking. Please try again.')</script>";
        }
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

	<title>JoJo-Hotpot</title>

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

					<h1 class="h3 mb-3 text-center">Booking-Customer</h1>

					<div class="row">
						<div class="col-12">
						<div class="card">
							<div class="card-header">
							<div class="row align-items-center">
								<!-- Left side: Create New Order button -->
								<div class="col-md-6">
									<a href="booking-list.php" class="btn btn-danger">Booking-list-></a>
								</div>

								<!-- Right side: Search bar -->
							
							</div>
						</div>
								<div class="card-body">
								 <form method="POST">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                            <label class="form-label">Booking-Date</label>
                                            <input type="date" class="form-control form-control-lg" name="bookingDate" placeholder="Enter booking-date" />
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Booking-Time</label>
                                            <input type="time" class="form-control form-control-lg" name="bookingTime" placeholder="Enter booking-time" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                            <label class="form-label">Guests</label>
                                            <input type="number" class="form-control form-control-lg" name="guests" placeholder="Number of guests" max="8" />
                                            </div>
                                            <div class="col-6">
                                            <label class="form-label">Booking-Customer</label>
                                            <select class="form-select mb-3" name="customer">
                                            <option selected>Choose Customer</option>
                                            <?php
                                            $query2 = "SELECT * FROM customer order by CustomerName";
                                            $ret = mysqli_query($connect, $query2);
                                            $size = mysqli_num_rows($ret);

                                            for ($i = 0; $i < $size; $i++) {
                                                $row = mysqli_fetch_array($ret);
                                                $CustomerID = $row['CustomerID'];

                                                echo "<option value='$CustomerID'>" . $row['CustomerName'] . "</option>";
                                            }
                                            ?>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                            <label class="form-label">Tables</label>
                                            <select class="form-select mb-3" name="table" required>
                                            <option value="">Choose Table</option>
                                            <?php
                                            $guests = isset($_POST['guests']) ? (int)$_POST['guests'] : 0;
                                            $query2 = "SELECT * FROM tables 
                                                     WHERE Capacity >= '$guests' 
                                                     ORDER BY TableID";
                                            $ret = mysqli_query($connect, $query2);
                                            $size = mysqli_num_rows($ret);

                                            if ($size > 0) {
                                                while ($row = mysqli_fetch_array($ret)) {
                                                    $ID = $row['TableID'];
                                                    echo "<option value='$ID'>" . $row['TableNumber'] . 
                                                         " (Capacity: " . $row['Capacity'] . 
                                                         ", Location: " . $row['Location'] . ")</option>";
                                                }
                                            } else {
                                                echo "<option disabled>No tables available for this party size</option>";
                                            }
                                            ?>
                                            </select>
                                            </div>
                                        </div>    
										<div class="row mb-2">
                                            <div class="col-12 text-end">
                                            <input type="submit" class="btn btn-lg btn-danger" name="btnsave" value="Book">
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

// Add this before closing </body> tag
<script>
document.querySelector('input[name="guests"]').addEventListener('change', function() {
    const guestsCount = this.value;
    const tableSelect = document.querySelector('select[name="table"]');
    
    fetch(`get_tables.php?guests=${guestsCount}`)
        .then(response => response.text())
        .then(data => {
            tableSelect.innerHTML = data;
        });
});
</script>

</body>

</html>