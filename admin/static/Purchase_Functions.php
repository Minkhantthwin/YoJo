<?php  

function AddProduct($ProductID,$PurchasePrice,$PurchaseQuantity)
{
	
    include('connect.php');
	$query="SELECT * FROM product WHERE productCode='$ProductID' ";
	$result=mysqli_query($connect,$query); 
	$count=mysqli_num_rows($result);
	$arr=mysqli_fetch_array($result);

	if ($count < 1) 
	{
		echo "<script>window.alert('Product no found.')</script>";
		echo "<script>window.location='purchase.php'</script>";
	}

	if ($PurchaseQuantity < 1) 
	{
		echo "<script>window.alert('Please enter correct Quantity.')</script>";
		echo "<script>window.location='purchase.php'</script>";
	}

	if(isset($_SESSION['Purchase_Functions'])) 
	{
		$Index=IndexOf($ProductID);

		if($Index == -1) 
		{
			$size=count($_SESSION['Purchase_Functions']);

			$_SESSION['Purchase_Functions'][$size]['ProductID']=$ProductID;
			$_SESSION['Purchase_Functions'][$size]['PurchasePrice']=$PurchasePrice;
			$_SESSION['Purchase_Functions'][$size]['PurchaseQuantity']=$PurchaseQuantity;

			$_SESSION['Purchase_Functions'][$size]['ProductName']=$arr['productName'];
			$_SESSION['Purchase_Functions'][$size]['ProductImage1']=$arr['photo'];
		}
		else
		{
			$_SESSION['Purchase_Functions'][$Index]['PurchaseQuantity']+=$PurchaseQuantity;
		}
	}
	else
	{
		$_SESSION['Purchase_Functions']=array();

		$_SESSION['Purchase_Functions'][0]['ProductID']=$ProductID;
		$_SESSION['Purchase_Functions'][0]['PurchasePrice']=$PurchasePrice;
		$_SESSION['Purchase_Functions'][0]['PurchaseQuantity']=$PurchaseQuantity;

		$_SESSION['Purchase_Functions'][0]['ProductName']=$arr['productName'];
		$_SESSION['Purchase_Functions'][0]['ProductImage1']=$arr['photo'];

	
	}
	echo "<script>window.location='purchase.php'</script>";
}

function IndexOf($ProductID)
{
	if (!isset($_SESSION['Purchase_Functions'])) 
	{
		return -1;
	}

	$size=count($_SESSION['Purchase_Functions']);

	if($size < 1) 
	{
		return -1;
	}
	else
	{
		for ($i=0; $i < $size; $i++) 
		{ 
			if($ProductID == $_SESSION['Purchase_Functions'][$i]['ProductID']) 
			{
				return $i;
			}	
		}
		return -1;
	}
}

function RemoveProduct($ProductID)
{
	$Index=IndexOf($ProductID);

	unset($_SESSION['Purchase_Functions'][$Index]);
	$_SESSION['Purchase_Functions']=array_values($_SESSION['Purchase_Functions']);

	echo "<script>window.location='purchase.php'</script>";
}


function Clearall()
{
	unset($_SESSION['Purchase_Functions']);
	echo "<script>window.location='purchase.php'</script>";
}

function CalculateTotalAmount()
{
	if(!isset($_SESSION['Purchase_Functions'])) 
	{
		$TotalAmount=0;
		return $TotalAmount;
	}
	else
	{
		$TotalAmount=0;

		$size=count($_SESSION['Purchase_Functions']);

		for ($i=0; $i < $size; $i++) 
		{ 
			$PurchaseQuantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];
			$PurchasePrice=$_SESSION['Purchase_Functions'][$i]['PurchasePrice'];

			$TotalAmount += $PurchasePrice * $PurchaseQuantity;
		}

		return $TotalAmount;
	}
}

function totalQuantity(){
	if(!isset($_SESSION['Purchase_Functions'])) 
	{
		$TotalAmount=0;
		return $TotalAmount;
	}
	else
	{
		$TotalAmount=0;

		$size=count($_SESSION['Purchase_Functions']);

		for ($i=0; $i < $size; $i++) 
		{ 
			$PurchaseQuantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];
			
			$TotalAmount += $PurchaseQuantity;
		}

		return $TotalAmount;
	}
}
?>