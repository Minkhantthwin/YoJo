-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2025 at 10:10 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yojo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `AdminName` varchar(255) DEFAULT NULL,
  `NRC` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `AdminName`, `NRC`, `Phone`, `Address`, `Email`, `Password`) VALUES
(1, 'Nyan Lin Htet', '12/testing', '09770321163', 'Time City, 4th Floor', 'zack21@gmail.com', 'zack123'),
(2, 'Minkhantthwin', '12/testing', '097999', 'No.51(B) Inya Myaing Street, Golden Valley (1), Bahan, Yangon', 'minkhantthwin17@gmail.com', 'minkhant123');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `BookingID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `TableID` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `guests` int(11) NOT NULL CHECK (`guests` > 0),
  `status` enum('Pending','Confirmed','Cancelled','Completed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`BookingID`, `CustomerID`, `TableID`, `booking_date`, `booking_time`, `guests`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 2, '2025-03-11', '14:30:00', 3, 'Confirmed', '2025-03-09 16:01:50', '2025-03-11 12:54:07'),
(2, 5, 2, '2025-03-10', '15:24:00', 3, 'Pending', '2025-03-09 17:04:46', '2025-03-09 17:04:46');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `CustomerName` varchar(50) NOT NULL,
  `NRC` varchar(50) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Address` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `MembershipID` int(11) DEFAULT NULL,
  `Start_Date` date DEFAULT NULL,
  `End_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `CustomerName`, `NRC`, `Phone`, `Address`, `Email`, `Password`, `MembershipID`, `Start_Date`, `End_Date`) VALUES
(5, 'Minkhantthwin', '12/testing', '097999', 'No.51(B) Inya Myaing Street, G', 'minkhantthwin17@gmail.com', '123', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderID` varchar(15) NOT NULL,
  `productCode` int(11) NOT NULL,
  `Price` int(11) DEFAULT NULL,
  `Quantity` float DEFAULT NULL,
  `productName` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` varchar(15) NOT NULL,
  `OrderDate` date DEFAULT NULL,
  `TotalAmount` float DEFAULT NULL,
  `TotalQuantity` int(11) DEFAULT NULL,
  `GrandTotal` float DEFAULT NULL,
  `VAT` float DEFAULT NULL,
  `PaymentType` varchar(50) DEFAULT NULL,
  `Direction` varchar(255) DEFAULT NULL,
  `DeliveryStatus` varchar(50) DEFAULT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `TownshipID` int(11) DEFAULT NULL,
  `OptionalDirection` varchar(255) DEFAULT NULL,
  `Comments` varchar(255) DEFAULT NULL,
  `Evidence` text DEFAULT NULL,
  `Status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productCode` int(11) NOT NULL,
  `productTypeCode` int(11) NOT NULL,
  `productName` varchar(30) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `remark` varchar(200) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productCode`, `productTypeCode`, `productName`, `price`, `quantity`, `description`, `remark`, `photo`) VALUES
(1, 2, 'Pork-Slice', 3000, 40, 'Pork-Slice Hotpot', 'Local-sourced', 'Pork.jpg'),
(2, 4, 'Beef Slice', 4000, 40, 'Thin Beef Slice.', 'Imported', 'Beef.jpg'),
(3, 5, 'Fish-Fillet', 3500, 40, 'Fish slices for seafood hotpot.', 'Local-sourced', 'fish.jpg'),
(4, 6, 'Thailand Bok Choy', 1000, 20, 'Bok Choy from Thailand', 'Imported', 'bok choy.jpg'),
(5, 1, 'Chicken', 2500, 20, 'Chicken Slices.', 'Local-sourced', 'chicken.jpg'),
(6, 7, 'Mala Xiang Guo', 25000, 50, 'Mala Paste, Spicy, Numbing, Pork, Chicken & Vegetables.', 'Local-sourced', 'Mala.jpg'),
(7, 8, 'Hot-Pot Mala Set', 40000, 50, 'Hot-Pot Set with Mala broth and 3 meats.', 'Local-sourced', 'hot-pot-8281w.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `productTypeCode` int(11) NOT NULL,
  `productTypeName` varchar(30) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`productTypeCode`, `productTypeName`, `status`) VALUES
(1, 'Chicken', 'In-Stock'),
(2, 'Pork', 'In-Stock'),
(3, 'Drinks', 'In-Stock'),
(4, 'Beef', 'In-Stock'),
(5, 'Seafood', 'In-Stock'),
(6, 'Non-Meat', 'In-Stock'),
(7, 'Side-Dishes', 'In-Stock'),
(8, 'Hotpot-sets', 'In-Stock');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchaseCode` varchar(30) NOT NULL,
  `supplierID` int(11) NOT NULL,
  `adminID` int(11) NOT NULL,
  `purchaseDate` date NOT NULL,
  `totalAmount` int(11) NOT NULL,
  `totalQuantity` int(11) NOT NULL,
  `grandTotal` int(11) NOT NULL,
  `status` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchaseCode`, `supplierID`, `adminID`, `purchaseDate`, `totalAmount`, `totalQuantity`, `grandTotal`, `status`) VALUES
(' PUR-000001', 1, 2, '2025-02-23', 40000, 20, 0, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `purchasedetail`
--

CREATE TABLE `purchasedetail` (
  `purchaseCode` varchar(30) DEFAULT NULL,
  `productCode` int(11) DEFAULT NULL,
  `purchasePrice` int(11) DEFAULT NULL,
  `purchaseQuantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchasedetail`
--

INSERT INTO `purchasedetail` (`purchaseCode`, `productCode`, `purchasePrice`, `purchaseQuantity`) VALUES
(' PUR-000001', 1, 2000, 20);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewID` int(11) NOT NULL,
  `Review` text DEFAULT NULL,
  `CustomerName` varchar(255) DEFAULT NULL,
  `CustomerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplierID` int(11) NOT NULL,
  `supplierName` varchar(30) NOT NULL,
  `phoneNum` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplierID`, `supplierName`, `phoneNum`, `email`, `address`, `status`) VALUES
(1, 'John', '09799481977', 'John@gmail.com', 'Yangon, Downtown\r\nTesting', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `TableID` int(11) NOT NULL,
  `TableNumber` varchar(50) NOT NULL,
  `Location` varchar(50) DEFAULT NULL,
  `Capacity` int(11) NOT NULL DEFAULT 4
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`TableID`, `TableNumber`, `Location`, `Capacity`) VALUES
(1, 'Table 1', 'Outdoor', 4),
(2, 'Table 2', 'Indoor', 4),
(3, 'Table 3', 'Outdoor', 8),
(4, 'Table 4', 'Indoor', 6);

-- --------------------------------------------------------

--
-- Table structure for table `township`
--

CREATE TABLE `township` (
  `TownshipID` int(11) NOT NULL,
  `TownshipName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `township`
--

INSERT INTO `township` (`TownshipID`, `TownshipName`) VALUES
(1, 'Bahan'),
(2, 'Thingangyun'),
(3, 'North Dagon');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `TableID` (`TableID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderID`,`productCode`) USING BTREE;

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productCode`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`productTypeCode`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchaseCode`);

--
-- Indexes for table `purchasedetail`
--
ALTER TABLE `purchasedetail`
  ADD KEY `purchaseCode` (`purchaseCode`),
  ADD KEY `productCode` (`productCode`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `fk_Customer_ID` (`CustomerID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplierID`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`TableID`);

--
-- Indexes for table `township`
--
ALTER TABLE `township`
  ADD PRIMARY KEY (`TownshipID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `productTypeCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `TableID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `township`
--
ALTER TABLE `township`
  MODIFY `TownshipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`TableID`) REFERENCES `tables` (`TableID`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_Customer_ID` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
