<?php
include('connect.php');

$guests = isset($_GET['guests']) ? (int)$_GET['guests'] : 0;

if ($guests > 0) {
    $query = "SELECT * FROM tables 
             WHERE Capacity >= ? 
             ORDER BY TableID";
             
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "i", $guests);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $tables = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $tables[] = $row;
    }
    
    header('Content-Type: application/json');
    echo json_encode($tables);
}
?>