-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 02, 2024 at 06:45 PM
-- Server version: 11.1.2-MariaDB-1:11.1.2+maria~ubu2204
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `certificate`
--

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `certificate_code` varchar(100) NOT NULL,
  `issued_at` timestamp NULL DEFAULT current_timestamp(),
  `certificate_template` varchar(255) DEFAULT NULL,
  `download_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `user_id`, `event_id`, `certificate_code`, `issued_at`, `certificate_template`, `download_count`) VALUES
(15, 4, 6, 'z9LL5c92ht-2024', '2024-11-02 17:16:22', 'template2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `certificate_fields`
--

CREATE TABLE `certificate_fields` (
  `id` int(11) NOT NULL,
  `certificate_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `field_name` varchar(100) NOT NULL,
  `field_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `certificate_fields`
--

INSERT INTO `certificate_fields` (`id`, `certificate_id`, `file_name`, `field_name`, `field_value`) VALUES
(8, 15, 'certificates-1730567782-z9LL5c92ht-2024.png', 'Belajar Golang Dasar', 'daapat menmpelajari amsdnakc');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_description` text DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `organizer` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `event_name`, `event_description`, `event_date`, `organizer`, `created_at`) VALUES
(4, 'Belajar Javascript dasar', 'Sesi belajar javascript dasar bersama ....', '2024-11-05', 'PT. Transpac', '2024-11-02 17:13:24'),
(5, 'Belajar Kotlin', 'Belajar kotlin untuk membuat aplikasi android, dimana kotlin merupakan bahasa yang mirip dengan java dan javascript', '2024-11-22', 'Agus Sucipto', '2024-11-02 17:15:00'),
(6, 'Belajar Golang Dasar', 'anjay', '2024-11-05', 'Chaeza Ibnu Akbar', '2024-11-02 17:15:41');

-- --------------------------------------------------------

--
-- Table structure for table `reset_password`
--

CREATE TABLE `reset_password` (
  `id` int(11) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reset_password`
--

INSERT INTO `reset_password` (`id`, `reset_token`, `email`) VALUES
(1, 'ba8c58e099ca2e43121e3fb08a097fa4a252a2cb675790c7094178ed54448347de7c8f1ef174bf1d', 'ibnu235729@gmail.com'),
(2, '1572cc0192e0856d8206bb7f679ec5d7508b1c11962c9900fc139e7d3e5ab97e6144d9f5801a92b4', 'ibnu235729@gmail.com'),
(3, 'a5ebd9604a7bf942b62a4589ac0cdeda67a9197123d30ede6395708622c7e88bfa9c25a72218fafe', 'ibnu235729@gmail.com'),
(4, '09652b3d5ec284be47c3fc082ad871af1369f57b6d1b065c173fd7978888fa0f554eff14eb7dfe98', 'ibnu235729@gmail.com'),
(5, 'deab6b9902f4e13d9a48d2a90eb84608a85a22ce5e2713cb293ea57494e32b1657e708fa8db69c6d', 'ibnu235729@gmail.com'),
(6, '31b9c9c5a1ddf9646ee93fe980c991983c7555ee2befb7e86cfb7e1021c4bbf7c9dc4ac3c85650f6', 'ibnu235729@gmail.com'),
(7, 'a61e213675e366b8d797654702be0f562d0ea374e0b9f0caca01dbe5acbd5a3a9c49d188da307da5', 'ibnu235729@gmail.com'),
(8, '0bd62017a14e6fd4869903136da540225006577bccaf4c95efa37e96b39b7819245922cb81d450ac', 'ibnu235729@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('participant','admin') DEFAULT 'participant',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nik`, `full_name`, `email`, `phone_number`, `password`, `role`, `created_at`) VALUES
(1, '3175062406070009', 'Chaeza Ibnu Akbar', 'ibnu235729@gmail.com', '0859102628529', '5b196d3ffc913f29ece597fc1489c078;7862c1ff931b93bac74a6ebb7a61b5270082c1bb6eff23ad5d3e72c15e10d72f', 'admin', '2024-10-30 15:23:06'),
(4, '3198472355328', 'Rennard Adityatama', 'rennard@gmail.com', '08123556789', '291ddc90c349b060b5b08c6436a6e1a8;e6b24da9856458ee2f9014b8173fd96155e765395117bddc18a780e58ba240fc', 'participant', '2024-11-02 17:06:59'),
(5, '2192734124439', 'Danish Sulistyo', 'danish123@gmail.com', '086789283424', '88fac62a5fabf0a52618f681121308a7;73af6d1e34023a923cb8f9dc069924332a48564ab0058c9359be1556f4d70208', 'participant', '2024-11-02 17:07:51'),
(6, '2178461948713', 'Ayu Syafira', 'ayu@smkn71jakarta.sch.id', '082163731343', 'f3f99a207ac209fad93556adab125a91;9b8fba96617acd5efaaba7dd06af46d4b0a7522e40fd9389dbc0650c5695b2e7', 'participant', '2024-11-02 17:08:22'),
(7, '21847134698542', 'Laisa Almani', 'laisa@admin.com', '082184687443', 'fdb05dcfeb41d2afaa15e67630065fbb;053282259204fcb97e80744521f34f7cc861e94241f048c52165ddd2d9ed519d', 'admin', '2024-11-02 17:09:00'),
(8, '2748135235275', 'Reyhan Saputra', 'rey@reayhan.blog', '0832994242452', 'e1f758d27a4295866354fe1ffdce5532;3865b46dd69f722b7a503822b6bedc5470b27cdd1a0eb338dfa4c195ede5201d', 'participant', '2024-11-02 17:09:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_code` (`certificate_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `certificate_fields`
--
ALTER TABLE `certificate_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certificate_id` (`certificate_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_password`
--
ALTER TABLE `reset_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `certificate_fields`
--
ALTER TABLE `certificate_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reset_password`
--
ALTER TABLE `reset_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `certificate_fields`
--
ALTER TABLE `certificate_fields`
  ADD CONSTRAINT `certificate_fields_ibfk_1` FOREIGN KEY (`certificate_id`) REFERENCES `certificates` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
