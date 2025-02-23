<?php
$limit = 5; // Number of entries per page

// Get the current guest page or set default guest page as 1
if (isset($_GET['guestPage'])) {
    $guestPage = $_GET['guestPage'];
} else {
    $guestPage = 1;
}
$guestOffset = ($guestPage - 1) * $limit;

// Get the current member page or set default member page as 1
if (isset($_GET['memberPage'])) {
    $memberPage = $_GET['memberPage'];
} else {
    $memberPage = 1;
}
$memberOffset = ($memberPage - 1) * $limit;

// Get total number of guest members (MembershipID is NULL)
$queryTotalGuest = "SELECT COUNT(*) as total FROM customer WHERE MembershipID IS NULL";
$resultTotalGuest = mysqli_query($connect, $queryTotalGuest);
$totalGuestRows = mysqli_fetch_assoc($resultTotalGuest)['total'];
$totalGuestPages = ceil($totalGuestRows / $limit);

// Get guest member records with LIMIT and OFFSET
$queryGuest = "SELECT * FROM customer WHERE MembershipID IS NULL LIMIT $limit OFFSET $guestOffset";
$resultGuest = mysqli_query($connect, $queryGuest);

// Get total number of registered members (MembershipID is NOT NULL)
$queryTotalMember = "SELECT COUNT(*) as total FROM customer WHERE MembershipID IS NOT NULL AND MembershipID != ''";
$resultTotalMember = mysqli_query($connect, $queryTotalMember);
$totalMemberRows = mysqli_fetch_assoc($resultTotalMember)['total'];
$totalMemberPages = ceil($totalMemberRows / $limit);

// Get registered member records with LIMIT and OFFSET
$queryMember = "SELECT * FROM customer WHERE MembershipID IS NOT NULL AND MembershipID != '' LIMIT $limit OFFSET $memberOffset";
$resultMember = mysqli_query($connect, $queryMember);
