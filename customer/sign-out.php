<?php
session_start();
session_destroy();

echo "<script>window.alert('Logout Success')</script>";
echo "<script>window.location='index.php'</script>";

?>
