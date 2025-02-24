<?php
session_start();
include('connect.php');

$ID=$_GET['productCode'];

$Delete="DELETE FROM product WHERE productCode='$ID' ";
$result=mysqli_query($connect,$Delete);


if($result)
{
	echo "<script>window.alert('Successfully Deleted!')</script>";
	echo "<script>window.location='product-list.php'</script>";
}
else
{
	echo "<p>Something went wrong." . mysqli_error($connect) . "</p>";
}
?>