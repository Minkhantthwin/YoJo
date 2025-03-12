<?php
include('connect.php');

$guests = isset($_GET['guests']) ? (int)$_GET['guests'] : 0;

echo "<option value=''>Choose Table</option>";

if ($guests > 0) {
    $query = "SELECT * FROM tables WHERE Capacity >= '$guests' ORDER BY TableID";
    $result = mysqli_query($connect, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row['TableID'] . "'>" . 
                 $row['TableNumber'] . " (Capacity: " . $row['Capacity'] . 
                 ", Location: " . $row['Location'] . ")</option>";
        }
    } else {
        echo "<option disabled>No tables available for this party size</option>";
    }
}
?>