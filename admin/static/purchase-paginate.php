<?php
// Set up the pagination variables
$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Calculate the starting item of the current page
$offset = ($currentPage - 1) * $itemsPerPage;

// Modify the query to include the LIMIT and OFFSET for pagination
$query = "SELECT p.*, GROUP_CONCAT(CONCAT(pr.productName, ' (x', pd.purchaseQuantity, ')') SEPARATOR ', ') AS Items
          FROM purchase p
          JOIN purchasedetail pd ON p.purchaseCode = pd.purchaseCode
          JOIN product pr ON pd.productCode = pr.productCode
          WHERE p.purchaseCode LIKE '%$searchTerm%'
             OR p.purchaseDate LIKE '%$searchTerm%'
             OR p.status LIKE '%$searchTerm%'
             OR pr.productName LIKE '%$searchTerm%'
          GROUP BY p.purchaseCode
          LIMIT $offset, $itemsPerPage";

$result = mysqli_query($connect, $query);
$size = mysqli_num_rows($result);

// Query to count total records (for pagination calculation)
$totalQuery = "SELECT COUNT(DISTINCT p.purchaseCode) AS total
               FROM purchase p
               JOIN purchasedetail pd ON p.purchaseCode = pd.purchaseCode
               JOIN product pr ON pd.productCode = pr.productCode
               WHERE p.purchaseCode LIKE '%$searchTerm%'
                  OR p.purchaseDate LIKE '%$searchTerm%'
                  OR p.status LIKE '%$searchTerm%'
                  OR pr.productName LIKE '%$searchTerm%'";

$totalResult = mysqli_query($connect, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalItems = $totalRow['total'];
$totalPages = ceil($totalItems / $itemsPerPage);