<?php
// Set up the pagination variables
$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Calculate the starting item of the current page
$offset = ($currentPage - 1) * $itemsPerPage;

// Modify the query to include the LIMIT and OFFSET for pagination
$query = " SELECT o.*, GROUP_CONCAT(CONCAT(od.ProductName, ' (x', od.Quantity, ')') SEPARATOR ', ') AS Items
                                        FROM orders o
                                        JOIN orderdetails od ON o.OrderID = od.OrderID
                                        WHERE o.OrderID LIKE '%$searchTerm%' 
                                        OR o.CustomerID LIKE '%$searchTerm%' 
                                        OR od.ProductName LIKE '%$searchTerm%'
                                        OR o.DeliveryStatus LIKE '%$searchTerm%'
                                        GROUP BY o.OrderID
                                        LIMIT $offset, $itemsPerPage";

$result = mysqli_query($connect, $query);
$size = mysqli_num_rows($result);

// Query to count total records (for pagination calculation)
$totalQuery = "SELECT COUNT(DISTINCT o.OrderID) AS total
                                        FROM orders o
                                        JOIN orderdetails od ON o.OrderID = od.OrderID
                                        WHERE o.OrderID LIKE '%$searchTerm%' 
                                        OR o.CustomerID LIKE '%$searchTerm%' 
                                        OR od.ProductName LIKE '%$searchTerm%'
                                        OR o.DeliveryStatus LIKE '%$searchTerm%'
                                        ";

$totalResult = mysqli_query($connect, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalItems = $totalRow['total'];
$totalPages = ceil($totalItems / $itemsPerPage);