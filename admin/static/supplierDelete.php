<?php
session_start();
include('connect.php');

$ID=$_GET['supplierID'];

$Delete="DELETE FROM supplier WHERE supplierID='$ID' ";
$result=mysqli_query($connect,$Delete);


if($result)
{
	echo "<script>window.alert('Successfully Deleted!')</script>";
	echo "<script>window.location='supplier-list.php'</script>";
}
else
{
	echo "<p>Something went wrong." . mysqli_error($connect) . "</p>";
}
?>