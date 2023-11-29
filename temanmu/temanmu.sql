-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Nov 29, 2023 at 03:45 AM
-- Server version: 8.1.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `temanmu`
--

-- --------------------------------------------------------

--
-- Table structure for table `konten`
--

CREATE TABLE `konten` (
  `kontenID` int NOT NULL,
  `isi` text NOT NULL,
  `poin` int NOT NULL DEFAULT '-3',
  `topik` varchar(50) NOT NULL,
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `userID` int NOT NULL,
  `status` varchar(5) NOT NULL DEFAULT 'OPEN',
  `dateCreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likedReply`
--

CREATE TABLE `likedReply` (
  `replyID` int NOT NULL,
  `kontenID` int NOT NULL,
  `username` varchar(30) NOT NULL,
  `userID` int NOT NULL,
  `poin` int NOT NULL DEFAULT '1',
  `dateCreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `userID` int NOT NULL,
  `nilaiUser` int NOT NULL,
  `nilaiKonten` int NOT NULL,
  `nilaiReply` int NOT NULL,
  `nilaiLike` int NOT NULL,
  `totalNilai` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `replyID` int NOT NULL,
  `isi` text NOT NULL,
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `userID` int NOT NULL,
  `kontenID` int NOT NULL,
  `poin` int NOT NULL,
  `dateCreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimoni`
--

CREATE TABLE `testimoni` (
  `testimoniID` int NOT NULL,
  `isi` text NOT NULL,
  `rating` int NOT NULL,
  `userID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tingkatan`
--

CREATE TABLE `tingkatan` (
  `tingkatan` varchar(255) NOT NULL COMMENT 'nama tingkatan',
  `poinMinimum` int NOT NULL COMMENT 'nilai minimum untuk tingkatan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userEmail` varchar(50) NOT NULL COMMENT 'Login email credentials',
  `userName` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'user displayed',
  `userPassword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Login password credentials',
  `dateCreated` date NOT NULL,
  `userID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='must be accessed as few time as possible';

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userEmail`, `userName`, `userPassword`, `dateCreated`, `userID`) VALUES
('john@example.com', 'John Doe', 'hashedpassword', '2023-11-24', 1),
('something@somewhere.com', 'something', '$2y$10$m6yf1DWiJEvkfLMYQDaTMOdPgKSqn.ZYXpmkEo5s6Z53ATKl.eKC.', '2023-11-29', 6),
('m@m.com', 'm', '$2y$10$Z1H.5hWBEI0m/mWlpgbmXup4LdXgtb/rGX0/gAyM2g.P.yAaXorK6', '2023-11-29', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `konten`
--
ALTER TABLE `konten`
  ADD PRIMARY KEY (`kontenID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `likedReply`
--
ALTER TABLE `likedReply`
  ADD KEY `replyID` (`replyID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `kontenID` (`kontenID`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`replyID`),
  ADD KEY `kontenID` (`kontenID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `testimoni`
--
ALTER TABLE `testimoni`
  ADD PRIMARY KEY (`testimoniID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `konten`
--
ALTER TABLE `konten`
  MODIFY `kontenID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `replyID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimoni`
--
ALTER TABLE `testimoni`
  MODIFY `testimoniID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `konten`
--
ALTER TABLE `konten`
  ADD CONSTRAINT `konten_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `likedReply`
--
ALTER TABLE `likedReply`
  ADD CONSTRAINT `likedReply_ibfk_1` FOREIGN KEY (`replyID`) REFERENCES `reply` (`replyID`),
  ADD CONSTRAINT `likedReply_ibfk_2` FOREIGN KEY (`kontenID`) REFERENCES `konten` (`kontenID`);

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`kontenID`) REFERENCES `konten` (`kontenID`),
  ADD CONSTRAINT `reply_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `testimoni`
--
ALTER TABLE `testimoni`
  ADD CONSTRAINT `testimoni_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
