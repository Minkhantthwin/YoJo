<?php
session_start();
include('connect.php');

if (isset($_POST['btnsave']))
{
    $name=$_POST['txtname'];
    $phone=$_POST['txtphone'];
    $address=$_POST['txtaddress'];
    $nrc= $_POST['txtnrc'];
    $email=$_POST['txtemail'];
    $password=$_POST['txtpassword'];

    $select = "SELECT * FROM customer WHERE Email='$email'";
    $ret=mysqli_query($connect,$select);
    $count=mysqli_num_rows($ret);

      if ($count>0)
      {
        echo "<script>window.alert(Account with this gmail already exists.)</script>";
        exit();
      }
      else
      {
        $query="INSERT INTO customer(CustomerName, NRC, Address, Phone, Email, Password) values('$name','$nrc','$address','$phone','$email','$password')";
        $result=mysqli_query($connect, $query);

        if ($result) {
            echo "<script>window.alert('Your account has been successfully registered!')</script>";
            echo "<script>window.location='sign-in.php'</script>";
        }
        else{
            echo "<p>Error in Entry</p>";
        }
      }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Sign In - JoJo Hotpot</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <style>
    .form-check-input:checked {
      background-color: #ce1212;
      border-color: #ce1212;
    }
    .btn-danger {
      background-color: #ce1212;
      border-color: #ce1212;
    }
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .form-control {
      border-radius: 5px;
    }
    .form-label {
      font-weight: bold;
    }
    .btn-danger {
      border-radius: 5px;
    }
  </style>

</head>

<body class="starter-page-page">

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename"><span class="text-danger">J</span>oJo</h1>
        <span>.</span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
         
         
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      
    </div>
  </header>

  <main class="main">
  
    

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>JoJo-Hotpot</h2>
        <p><span>Sign</span> <span class="description-title">Up</span></p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up">
      <div class="row">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">
						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form method="POST">
										<div class="mb-3">
											<label class="form-label">Full name</label>
											<input class="form-control form-control-lg" type="text" name="txtname" placeholder="Enter your name" />
										</div>
										<div class="mb-3">
											<label class="form-label">Phone-Number</label>
											<input class="form-control form-control-lg" type="text" name="txtphone" placeholder="Enter your ph-no." />
										</div>
										<div class="mb-3">
											<label class="form-label">Address</label>
											<input class="form-control form-control-lg" type="text" name="txtaddress" placeholder="Enter your address" />
										</div>
										<div class="mb-3">
											<label class="form-label">NRC</label>
											<input class="form-control form-control-lg" type="text" name="txtnrc" placeholder="Eg. 12/BaHaNa(N)...." />
										</div>
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="txtemail" placeholder="Enter your email" />
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="txtpassword" placeholder="Enter password" />
										</div>
										<div class="d-grid gap-2 mt-3">
                                            <input type="submit" class="btn btn-lg btn-danger" name="btnsave" value="Sign up">
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="text-center m-3">
							Already have account? <a href="sign-in.php">Log In</a>
						</div>
					</div>
				</div>
			</div>
    </div>

    </section><!-- /Starter Section Section -->

  </main>

  <!-- <footer id="footer" class="footer dark-background">

    <div class="container copyright text-center mt-2">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">JoJo</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">Me</a>
      </div>
    </div>

  </footer> -->

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>