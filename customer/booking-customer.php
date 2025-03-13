<?php
include ('connect.php');
session_start();

if (isset($_POST['btnsave']))
{
    $bookingDate = $_POST['bookingDate'];
    $bookingTime = $_POST['bookingTime'];
    $guests = $_POST['guests'];
    $customerName = $_POST['customerName'];
    $customerPhone = $_POST['customerPhone'];
    $customerEmail = $_POST['customerEmail'];
    $tableID = $_POST['table'];
    $status = 'Pending';

    // Check for existing bookings
    $bookingDateTime = strtotime("$bookingDate $bookingTime");
    $oneHourBefore = date('H:i', strtotime('-1 hour', $bookingDateTime));
    $oneHourAfter = date('H:i', strtotime('+1 hour', $bookingDateTime));

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
        echo "<script>window.location='index.php#book-a-table'</script>";
    }
    else
    {
        $query = "INSERT INTO booking(booking_date, booking_time, guests, CustomerName, CustomerPhone, CustomerEmail, TableID, status) 
                  VALUES ('$bookingDate', '$bookingTime', '$guests', '$customerName', '$customerPhone', '$customerEmail', '$tableID', '$status')";
        $result = mysqli_query($connect, $query);

        if ($result) {
            echo "<script>window.alert('Booking has been successfully registered!')</script>";
            echo "<script>window.location='index.php'</script>";
        }
        else {
            echo "<script>window.alert('Error in booking. Please try again.')</script>";
            echo "<script>window.location='index.php#book-a-table'</script>";
        }
    }
}
else {
    echo "<script>window.location='index.php'</script>";
}
?>