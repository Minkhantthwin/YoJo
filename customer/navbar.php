<?php
if (isset($_SESSION['CustomerID'])) {
    $CustomerID = $_SESSION['CustomerID'];
    $selectCustomer = "SELECT * FROM customer WHERE CustomerID = '$CustomerID'";
    $resultCustomer = mysqli_query($connect, $selectCustomer);
    $rowCustomer = mysqli_fetch_assoc($resultCustomer);
    $CustomerName = $rowCustomer['CustomerName'];
    $CustomerEmail = $rowCustomer['Email'];
    $Phone = $rowCustomer['Phone'];
    $Address = $rowCustomer['Address'];
}
?>
<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">

        <h1 class="sitename"><span class="text-danger">J</span>oJo</h1>
        <span>.</span>
      </a>

      <nav id="navmenu" class="navmenu">
      <?php if (isset($_SESSION['CustomerID'])) {
                ?>
        <ul>
          <li><a href="#hero" class="active">Home<br></a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#menu">Menu</a></li>
          <li><a href="#gallery">Reviews</a></li>
          <li><a href="#contact">Contacts</a></li>
          <li class="dropdown"><a href="#"><span>Profile</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Profile</a></li>
              <li><a href="#">My Orders</a></li>
              <li><a href="#">My Bookings</a></li>
              <li><a href="sign-out.php">Sign out</a></li>
            </ul>
          </li>
          </ul>
          <?php } else { ?>
            <ul>
            <li><a href="#hero" class="active">Home<br></a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#menu">Menu</a></li>
          <li><a href="#gallery">Reviews</a></li>
          <li><a href="#contact">Contacts</a></li>
          <li><a href="sign-in.php">Sign-in</a></li>
            </ul>
          <?php } ?>
   
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="index.html#book-a-table">Book a Table</a>

    </div>
  </header>