-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 24, 2025 at 03:32 AM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u851624587_serbiziodb1`
--
CREATE DATABASE IF NOT EXISTS `u851624587_serbiziodb1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `u851624587_serbiziodb1`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin_sean', 'serbizioadmin'),
(2, 'admin_julio', 'serbizioadmin2'),
(3, 'admin_casey', 'serbizioadmin3');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `contractor_id` int(11) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `status` enum('Pending','Confirmed','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `industry` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_num` varchar(15) NOT NULL,
  `region` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `industry`, `position`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `mobile_num`, `region`, `city`, `profile_image`, `reset_token`, `reset_token_expiry`, `created_at`, `updated_at`) VALUES
(3, 'Corbilt', 'Construction', 'recruiter', 'Ronaldo ', 'Reyes', 'Abadia', 'ronaldoabadiareyes@gmail.com', '$2y$10$Xi06cQWwEBX8aGgTFweFMOy7WsgUaESvHC9L89Er10PrfS2h3X4/y', '09959377918', 'Luzon', 'San Mateo', 'uploads/67419ba7a0f6f-IMG_20241121_070726.jpg', NULL, NULL, '2024-11-23 09:08:55', '2024-11-23 09:08:55'),
(4, '', 'Education', 'owner', 'Markchester', 'Borbe', 'Cos', 'borbemaryann29@gmail.com', '$2y$10$cT9JCIeaLrwlJlvNevXDs.RQhdVsL94ReCW/H3uWfOt1fKlJmyWE2', '09307601607', 'Luzon', 'Cavite City', '', NULL, NULL, '2024-12-02 00:25:20', '2024-12-02 00:25:20'),
(5, '', 'Household', 'recruiter', 'Sean', '', 'Reyes', 'torrentialroar@gmail.com', '$2y$10$kZA4FlWwhwKU.XbTOIFQH.tVnuGNBd4zpfjkuVjxwAHWIR8BmZCVy', '9956410538', 'Luzon', 'Las Piñas City', '', NULL, NULL, '2024-12-09 23:32:42', '2024-12-09 23:32:42'),
(6, '', 'Security', 'recruiter', 'Casey', '', 'Dowling', '21-0123c@sgen.edu.ph', '$2y$10$wsArrzUEOkVZXlBWiDFTRe/kyd3avqTk3XDmHoqpljwIDYv92wNd.', '+639278378769', 'Luzon', 'Las Piñas City', '', NULL, NULL, '2024-12-10 00:35:49', '2024-12-10 00:35:49'),
(7, 'Solenergy', 'Construction', 'recruiter', 'Arvie Glenn', 'Singca', 'Ramos', 'arvieglenn30@gmail.com', '$2y$10$dXfdWC4JZ03lJBeddEdh1uqvyvr4Ng0zDy/LtaBuFAo4c7dEHWDmG', '09672186274', 'Luzon', 'Bataan (Balanga, Mariveles, etc.)', 'uploads/67965bf0b320d-inbound4914944103504864497.jpg', NULL, NULL, '2025-01-26 15:59:44', '2025-01-26 15:59:44'),
(8, 'Tokwing infinite ', 'Transportation', 'head_hunter', 'Ricardo', 'Manicani ', 'Canoza', 'canozaricardo2@gmail.com', '$2y$10$M1zL1960Zc7HkmbMQTQqAewYMC510403G01VB7JhB8A0zu0XYOaoG', '9456386622', 'Luzon', 'Cavite City', 'uploads/679980863c19a-inbound3815056953823950298.jpg', NULL, NULL, '2025-01-29 01:12:38', '2025-01-29 01:12:38'),
(9, 'Al khateeb united trading company ', 'Construction', 'owner', 'Edwin ', 'Tinsay ', 'Bandang ', 'edwinbandang8@gmail.com', '$2y$10$r9Bpqh7vcwHFfXMCqCJJ9e5C/YhHUqtC0j6kR0FNqawAPFcXLQxYm', '09678247410', 'Visayas', 'Iloilo City', 'uploads/6799b84a2ec7f-inbound6934030922650187386.jpg', NULL, NULL, '2025-01-29 05:10:34', '2025-01-29 05:10:34'),
(10, '  Ib8 construction ', 'Construction', 'recruiter', 'Jeffrey ', 'Adao', 'Resolis', 'jresolis695@gmail.com', '$2y$10$8vTpoOIfhn5LKT8ZjXdn7eCBdJ4zujpL9eeG9/HQ.ulnMcdN5ZUly', '09666757874', 'Luzon', 'Dasmariñas City', '', NULL, NULL, '2025-01-29 06:21:24', '2025-01-29 06:21:24'),
(11, 'Saudi binladin company', 'Construction', 'head_hunter', 'Rowel', 'Potutan ', 'Calo-oy ', 'calooyrowell2@gmail.com', '$2y$10$RPu5I5IjSZZd74P9rRk46.jOx0/gmzlAvoN1Ztix1jGPnWb3P7F4u', '09515630428', 'Mindanao', 'Polomolok', 'uploads/679c1351abb33-inbound1095445682153860616.jpg', NULL, NULL, '2025-01-31 00:03:29', '2025-01-31 00:03:29'),
(12, 'Sinotech', 'Construction', 'recruiter', 'PatrickJoseph', '', 'Aliod', 'aliodpatrick@gmail.com', '$2y$10$MCmMiYhdkRg7Vlhyc/XpU.b539GdDEtRI23fo6Acjl8bu0IYvYfeq', '09602636134', 'Luzon', 'Cavite City', 'uploads/67a225e514d3f-inbound2641869298527644346.jpg', NULL, NULL, '2025-02-04 14:36:21', '2025-02-04 14:36:21'),
(13, 'Sinotech', 'Construction', 'recruiter', 'PatrickJoseph', '', 'Aliod', 'aliodpatrick@gmail.com', '$2y$10$4xVoUWdE042sxtECQuE/weneGeQYNDARL.pTZq/k3fw.PxqNwqXMC', '09602636134', 'Luzon', 'Cavite City', 'uploads/67a226b773f08-inbound2420123389927244534.jpg', NULL, NULL, '2025-02-04 14:39:51', '2025-02-04 14:39:51'),
(14, 'Iconex', 'Construction', 'head_hunter', 'Gian Carlo', '', 'Sto. Domingo', 'stodomingogiancarlo6@gmail.com', '$2y$10$V3u1xUqEt2Vc2CraPwSnX.L80BW.aAxZJLJrKZBjvrPp1z2DKia/.', '+639653084714', 'Luzon', 'Cavite City', '', NULL, NULL, '2025-02-06 05:47:30', '2025-02-06 05:47:30'),
(15, 'Amcaaj International Recruitment Agency Inc.', 'Domestic', 'hr', 'Chyna', '', 'Jimenez', 'amcaaj.ira@gmail.com', '$2y$10$ExwXP9oTYqMyrU2zYar55OZEeQLthP/XECZqlC1lvOeISdrJ7YpWW', '09997149794', 'Luzon', 'Makati City', '', NULL, NULL, '2025-02-17 06:42:22', '2025-02-17 06:42:22'),
(17, 'Alice', 'Select Industry', 'Select Position', 'TestUser', 'Hello', 'TestUser', 'oefzhvis@do-not-respond.me', '$2y$10$8vKwhlOQMK5peDZwPBJlYOFb1P/tpuHaZDs2mKYj0dzVPrzbf7ucC', '+64 7064578', 'Select Region', 'Select City', 'uploads/profile.webp', NULL, NULL, '2025-03-05 09:08:45', '2025-03-05 09:08:45'),
(18, 'MCS PRIME', 'Construction', 'owner', 'Margaret', '', 'Reyes', 'margaret.tuliao@gmail.com', '$2y$10$YkwfpcK.OFGJ4pdxuQEd3O.G4w8RUUNG1tm1bx05jMpcAJ.lPLOVi', '09085611971', 'Luzon', 'Muntinlupa City', 'uploads/profile.webp', NULL, NULL, '2025-03-21 06:08:21', '2025-03-21 06:08:21'),
(21, '', 'Construction', 'owner', 'MARGARET', '', 'REYES', 'margaret.tuliao@gmail.com', '$2y$10$PmCZbCuyLXGFKbDCNVK.DO2Q1Nne9p.u3PlHBAC.f.xdseA12loIW', '09454623087', 'Luzon', 'Manila', 'uploads/profile.webp', NULL, NULL, '2025-03-21 07:24:36', '2025-03-21 07:24:36'),
(22, 'BuildCorp', 'Construction', 'HR Manager', 'Juan', 'Santos', 'Dela Cruz', 'juan.delacruz@buildcorp.com', '$2y$10$TD4taCT9ZxOYH6F5PEW0pOSwWEve05bEL.vG5le1x72QsYjBbyvtK', '09171234567', 'Luzon', 'Quezon City', 'uploads/dummy_profile.jpg', NULL, NULL, '2025-04-04 06:53:24', '2025-04-04 07:01:53');

-- --------------------------------------------------------

--
-- Table structure for table `company_requests`
--

CREATE TABLE `company_requests` (
  `id` int(11) NOT NULL,
  `request_date` datetime NOT NULL DEFAULT current_timestamp(),
  `company_name` varchar(255) NOT NULL,
  `requested_by` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('pending','in progress','completed') NOT NULL DEFAULT 'pending',
  `budget_allocation` decimal(10,2) NOT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `complaint_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `complainant_name` varchar(255) NOT NULL,
  `status` enum('Pending','Resolved','In Progress') NOT NULL DEFAULT 'Pending',
  `reference_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `user_id`, `complaint_text`, `created_at`, `complainant_name`, `status`, `reference_id`) VALUES
(3, NULL, 'Test only', '2024-08-02 02:07:10', 'Test', 'Resolved', '1234567');

-- --------------------------------------------------------

--
-- Table structure for table `contractors`
--

CREATE TABLE `contractors` (
  `id` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `contractor_name` varchar(255) NOT NULL,
  `contractor_email` varchar(255) NOT NULL,
  `contractor_phone` varchar(20) NOT NULL,
  `contractor_password` varchar(255) NOT NULL,
  `contractor_address` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `job_position` varchar(100) DEFAULT NULL,
  `job_description` text DEFAULT NULL,
  `payment_channel` varchar(50) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `agency_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contractors`
--

INSERT INTO `contractors` (`id`, `phone`, `created_at`, `contractor_name`, `contractor_email`, `contractor_phone`, `contractor_password`, `contractor_address`, `photo`, `job_position`, `job_description`, `payment_channel`, `account_number`, `reset_token`, `reset_token_expiry`, `agency_name`) VALUES
(16, NULL, '2024-08-12 04:12:34', 'Maria Santos', '', '09999999999', '12345678', 'Calamba City, Laguna', 'uploads/girl3.webp', 'Yaya', 'No Description', 'gcash', '3698521478', NULL, NULL, 'Maria Household Services');

-- --------------------------------------------------------

--
-- Table structure for table `contractor_post`
--

CREATE TABLE `contractor_post` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `provider_name` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `duration` enum('Per Month','Per Day','Per Hour') NOT NULL,
  `agency_name` varchar(255) NOT NULL,
  `category` enum('Household','Personal','Transport','Construction','BPO','Restaurant','General') NOT NULL,
  `image_url` text DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `email` varchar(255) DEFAULT NULL,
  `contractor_phone` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contractor_post`
--

INSERT INTO `contractor_post` (`id`, `service_name`, `provider_name`, `details`, `amount`, `duration`, `agency_name`, `category`, `image_url`, `timestamp`, `email`, `contractor_phone`) VALUES
(1, 'Yaya', 'Maria Santos', 'Baby sitting', 1500.00, 'Per Day', 'None', 'Household', NULL, '2024-08-14 15:33:50', 'test6@gmail.com', '09999999999'),
(2, 'Yaya', 'Maria Santos', 'Professional Baby sitter for almost 4 years.', 20000.00, 'Per Month', 'None', 'Household', NULL, '2024-08-31 18:06:53', 'test6@gmail.com', '09999999999'),
(3, 'Nanny Services', 'Maria Santos', 'Can provide quality and professional services', 1800.00, 'Per Day', 'None', 'Household', 'uploads/yayamaid.jpg', '2024-09-20 16:09:06', 'test6@gmail.com', '09999999999'),
(4, 'Caregiver', 'Maria Santos', 'Providing services for the elderly', 1500.00, 'Per Day', 'None', 'Household', 'uploads/yayamaid.jpg', '2024-09-20 20:02:41', 'test6@gmail.com', '09999999999'),
(6, 'All-Around Maid', 'Maria Santos', 'Professional services for all around services', 8000.00, 'Per Month', 'Maria Household Services', 'Household', 'uploads/yayamaid.jpg', '2024-09-26 20:50:48', 'noemail@gmail.com', '09999999999');

-- --------------------------------------------------------

--
-- Table structure for table `individuals`
--

CREATE TABLE `individuals` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_num` varchar(15) NOT NULL,
  `region` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `id_photo` varchar(255) DEFAULT NULL,
  `industry` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `individuals`
--

INSERT INTO `individuals` (`id`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `mobile_num`, `region`, `city`, `profile_image`, `resume`, `id_photo`, `industry`, `position`, `created_at`, `updated_at`, `reset_token`, `reset_token_expiry`, `status`) VALUES
(4, 'Michale laurence', 'Guido', 'Jareno', 'michaellaurencejareno@gmail.com', '$2y$10$hJjBlhj9i2Oklk4NdwxnX./UZbtRIIssWYJtx5hXwOak0dqYi.Azq', '09773962544', 'Luzon', 'Marikina City', 'uploads/Resize_20221227_120434_4404.jpg', 'uploads/Michale Laurence G.docx', '', 'Construction', 'Site Supervisor', '2024-11-23 08:22:42', '2024-11-23 08:22:42', NULL, NULL, 'pending'),
(7, 'romel', 'miranda', 'emanel', 'romelemanel6@gmail.com', '$2y$10$jaSS4VTwPsx2AXK/3tFbbeZf02DeT4XZWqm2/ZESg1lq9ChrhNmH2', '09977208710', 'Luzon', 'Bacoor City', 'uploads/1000016184.jpg', '', '', 'Construction', 'Carpenter', '2024-11-23 11:02:30', '2024-11-23 11:02:30', NULL, NULL, 'pending'),
(9, 'Sean', '', 'Reyes', 'torrentialroar@gmail.com', '$2y$10$YpmRqDbfMMGpJdT7kLCAA.ZgQI05Fad.vskVlhtXDU9nvJBxTCTbK', '9956410538', 'Luzon', 'Las Piñas City', 'uploads/profile.webp', '', '', 'Household', 'Cook', '2024-12-09 23:30:37', '2025-02-20 11:56:36', NULL, NULL, 'pending'),
(10, 'Casey', '', 'Dowling', '', '$2y$10$3gGr/6/CD5fQVTjM.Y1dOO9KyCMID0fxJHvn9/xIG3J68zsbMR1ma', '+639278378769', 'Luzon', 'Las Piñas City', 'uploads/profile.webp', '', '', 'Healthcare', 'Nurse', '2024-12-10 00:34:45', '2025-02-20 11:56:36', NULL, NULL, 'pending'),
(139, 'Demi Pearl Marie', '', 'Dalman', 'mariedalman07@gmail.com', '$2y$10$bgMFK6rFaAtnv1ewRZEgHO8KRYZNUoNsq.AnoeSdUSM0.NOPH/5sq', '+639566683751', 'Mindanao', 'Malaybalay City', 'uploads/profile.webp', '', '', 'Tourism', 'Hotel Receptionist', '2025-01-23 07:28:00', '2025-02-20 11:56:36', NULL, NULL, 'pending'),
(140, 'Demi Pearl Marie', '', 'Dalman', 'mariedalman07@gmail.com', '$2y$10$GrHEpLcixUqJVoixtvBXMOrnlBnasAfIlXXtzVDjCC9LD1VCvZbsS', '+639566683751', 'Mindanao', 'Malaybalay City', 'uploads/profile.webp', '', '', 'Tourism', 'Hotel Receptionist', '2025-01-23 07:29:16', '2025-02-20 11:56:36', NULL, NULL, 'pending'),
(141, 'Edwil', 'E', 'Penaserada', 'edwilpenaserada27@gmail.com', '$2y$10$Rl5aKElqP4sL.ZaTznO9N.m/dibI47jUp4vmTdW.WvhGYeiI53c.O', '09291779573', 'Mindanao', 'Davao City', 'uploads/profile.webp', 'uploads/inbound4605743872681155862.pdf', '', 'Transportation', 'Logistics Coordinator', '2025-01-26 15:59:06', '2025-02-20 11:56:36', NULL, NULL, 'pending'),
(142, 'Wilfredo', 'Mendoza', 'Martin', 'wilfredomartin1969@gmail.com', '$2y$10$RhBfMNjUfvIi5cSHspkOiew0Li/T0gZVxHxPBE2Bgm5Ia6Ml/LRrC', '09297311719', 'Luzon', 'Malolos City', 'uploads/inbound3939739870268826839.jpg', '', 'uploads/inbound6457030298641645664.jpg', 'Construction', 'Electrician', '2025-01-26 17:10:53', '2025-01-26 17:10:53', NULL, NULL, 'pending'),
(143, 'Bernard', 'Colon', 'Gabas', 'bernardgabas919@gmail.com', '$2y$10$1nCD76FaX6a6NK.NZpfsWujQ77rwDAJ/LnyMW4S7/SokqWSpJbMlC', '+1639632066164', 'Luzon', 'San Jose del Monte', 'uploads/inbound5506487802620710046.jpg', 'uploads/inbound2883747302905810008.pdf', 'uploads/inbound9059302410138367983.jpg', 'Construction', 'Mason', '2025-01-26 19:51:42', '2025-01-26 19:51:42', NULL, NULL, 'pending'),
(144, 'Rowel', 'Potutan', 'Calo-oy', 'calooyrowell2@gmail.com', '$2y$10$GjgD1mzuCd3Xw5IF5Ac6x.IWbXAWlxshDdUCC1jp6uWeoapqe4RFm', '09515630428', 'Mindanao', 'Polomolok', 'uploads/inbound809052259533620411.jpg', 'uploads/inbound1618122452131937245.docx', 'uploads/inbound1519017666725501037.jpg', 'Construction', 'Electrician', '2025-01-26 20:39:48', '2025-01-26 20:39:48', NULL, NULL, 'pending'),
(145, 'Rowel', 'Potutan', 'Calo-oy', 'calooyrowell2@gmail.com', '$2y$10$Z4aL/R3VXs.b8WyLRlbiOeiERCtmmceOPiQ4M4PtlhD3y9gUstUEy', '09515630428', 'Mindanao', 'Polomolok', 'uploads/inbound1647190453881472309.jpg', 'uploads/inbound8332370633192158549.docx', 'uploads/inbound677386735844336814.jpg', 'Construction', 'Electrician', '2025-01-26 20:42:33', '2025-01-26 20:42:33', NULL, NULL, 'pending'),
(146, 'Lordrich', 'Mansalay', 'Dingle', '', '$2y$10$QtdKZN5dBBI1fU0zdsU9euUTE1uua00kt0yCZk03CrM6OKZcl0zmq', '09360569315', 'Luzon', 'Pasay City', 'uploads/profile.webp', '', '', 'Construction', 'Mason', '2025-01-27 04:22:57', '2025-02-20 11:56:36', NULL, NULL, 'pending'),
(147, 'Richel', 'Trojillo', 'Romarate', 'romaraterichel2@gmail.com', '$2y$10$xmpftB9bWlGv9HWOaFZc8egSwoPTMHJG90CcEm9uY/vc0BMbMLI0q', '+639270423722', 'Visayas', 'Iloilo City', 'uploads/inbound9100144585435000835.jpg', 'uploads/inbound2150432141105311564.pdf', 'uploads/inbound3829319548375571676.jpg', 'Construction', 'Carpenter', '2025-01-27 07:47:00', '2025-01-27 07:47:00', NULL, NULL, 'pending'),
(148, 'Richel', 'Trojillo', 'Romarate', 'romaraterichel2@gmail.com', '$2y$10$p7gQOmhmLSeQqD1UEE0P7e5UmBxpaDHHQrwXBdR5tLjtzhMD3V0DW', '+639270423722', 'Visayas', 'Iloilo City', 'uploads/profile.webp', '', '', 'Construction', 'Carpenter', '2025-01-27 07:49:57', '2025-02-20 11:56:36', NULL, NULL, 'pending'),
(149, 'Richel', 'Trojillo', 'Romarate', 'romaraterichel2@gmail.com', '$2y$10$1fP7BISEdH/toWOtoZBZFe2s1pLaDrIdcRsk9PiX/MnbkAtNN7owS', '+639270423722', 'Visayas', 'Iloilo City', 'uploads/IMG20250121043509.jpg', 'uploads/Resume.pdf', '', 'Construction', 'Carpenter', '2025-01-27 07:52:58', '2025-01-27 07:52:58', NULL, NULL, 'pending'),
(150, 'Gilbert', 'Dision', 'Galvadores', 'gilbertgalvadores2@gmail.com', '$2y$10$2wbnPsqdyzKDVkoep6/kveA7oGT6z/Q1sMOfryEKkpt78x18tD49K', '09753419704', 'Mindanao', 'Cagayan de Oro City', 'uploads/inbound6784393222683900110.jpg', 'uploads/inbound1001416600839511781.pdf', 'uploads/inbound5294369303940084361.png', 'Construction', 'Carpenter', '2025-01-27 14:22:22', '2025-01-27 14:22:22', NULL, NULL, 'pending'),
(151, 'Luis', 'Salimbot', 'Amor', 'amorluis0515@gmail.com', '$2y$10$6GsXzrv81Qotfw3KC0I8Qea8d0zA83KHAEjLYsvQL27eG3wmEZi9i', '09363870146', 'Luzon', 'Valenzuela City', 'uploads/inbound1368719629133110169.jpg', 'uploads/inbound1527441639194418047.pdf', 'uploads/inbound1945036789784535760.jpg', 'Construction', 'Mason', '2025-01-28 11:30:47', '2025-01-28 11:30:47', NULL, NULL, 'pending'),
(152, 'Jeffrey', 'Adao', 'Resolis', 'jresolis695@gmail.com', '$2y$10$Q6Sb32bm95reb4wHex/ereuhk77S718IAPHCwcyWvEv/ZGLbXz6qS', '09666757874', 'Luzon', 'Cavite City', 'uploads/profile.webp', '', '', 'Construction', 'Mason', '2025-01-29 04:57:45', '2025-02-20 11:56:36', NULL, NULL, 'pending'),
(153, 'Freddie', 'Andaya', 'Patubo', 'freddiepatubo23@gmail.com', '$2y$10$vyxZLvPTwMzAhNBk1eM.t.8i8DsJSSIVCi8WkHvhT8OypPe0KOCAe', '09275376963', 'Luzon', 'Urdaneta City', 'uploads/inbound6581653270290174458.jpg', 'uploads/inbound2002682027042004375.docx', '', 'Construction', 'Carpenter', '2025-01-29 05:02:07', '2025-01-29 05:02:07', NULL, NULL, 'pending'),
(154, 'Aurelio Jr', 'Gahe', 'Bagarino', 'jhunbagarino1976@gmail.com', '$2y$10$uBlgh5wUwLjLWLuzMylcwO9C2A/PjqSR5Latl0GYPpHe3iBT2vHPe', '09538705832', 'Visayas', 'Tacloban City', 'uploads/8431622F-40B7-47E9-B095-5BD10B4A1E61.jpeg', '', '', 'Transportation', 'Truck Driver', '2025-01-29 05:41:12', '2025-01-29 05:41:12', NULL, NULL, 'pending'),
(155, 'Aurelio Jr', 'Gahe', 'Bagarino', 'jhunbagarino1976@gmail.com', '$2y$10$uVWBPJTys6XkWsOLay//ReUvju.JZSmKj9H1a1I5URoAYzmB8diw.', '09538705832', 'Visayas', 'Tacloban City', 'uploads/8431622F-40B7-47E9-B095-5BD10B4A1E61.jpeg', '', '', 'Transportation', 'Truck Driver', '2025-01-29 05:41:19', '2025-01-29 05:41:19', NULL, NULL, 'pending'),
(156, 'Adelmo', 'Turla', 'Destor', '', '$2y$10$cxP.efCw2WC/T0YGaLclvek3mTbVG30VBijI90Y9hav7CXOdrX1QS', '+63 9695122848', 'Luzon', 'Tarlac City', 'uploads/inbound3675219396847559892.jpg', 'uploads/inbound3413677894337942021.pdf', 'uploads/inbound8689136006727584676.jpg', 'Transportation', 'Truck Driver', '2025-01-29 05:56:07', '2025-01-29 05:56:07', NULL, NULL, 'pending'),
(157, 'Jeffrey', 'Caquilala', 'Encarquez', 'jeffreyencarquez@gmail.com', '$2y$10$VXG9SDhu3PV.qyE.LPe6rufi0V5lia7Ax8IJCB6ILaiRQtpfLbOca', '09517051116', 'Mindanao', 'Iligan City', 'uploads/inbound6925651428806166287.jpg', '', 'uploads/inbound6801251495093525798.jpg', 'Transportation', 'Truck Driver', '2025-02-01 09:35:22', '2025-02-01 09:35:22', NULL, NULL, 'pending'),
(158, 'Gian Carlo', 'Estorosos', 'Sto. Domingo', 'stodomingogiancarlo6@gmail.com', '$2y$10$NnaC1Q6Fp1hBdA/UWHRQX.qe9hzuUF413BaXvT9Y0HT1KqZl1.4iW', '+639653084714', 'Luzon', 'Cavite City', 'uploads/inbound5195508532648111538.jpg', '', 'uploads/inbound6635377929820860573.jpg', 'Construction', 'Site Supervisor', '2025-02-03 01:53:53', '2025-02-03 01:53:53', NULL, NULL, 'pending'),
(159, 'Gian Carlo', 'Estorosos', 'Sto. Domingo', 'stodomingogiancarlo6@gmail.com', '$2y$10$JdfYB14vC26XPWjqmbiLMe4v/kVZ4Kh/IgXi4.Y0kLL/5wylSbyMO', '09653084714', 'Luzon', 'Cavite City', 'uploads/profile.webp', '', '', 'Construction', 'Site Supervisor', '2025-02-03 01:58:29', '2025-02-20 11:56:36', NULL, NULL, 'pending'),
(160, 'PatrickJoseph', '', 'Aliod', 'aliodpatrick@gmail.com', '$2y$10$q.i9Sx35A9NmHXZbVYrssufUkyQWSToUjBbgxQSUMRZHDJaoTXO6u', '09602636134', 'Luzon', 'Cavite City', 'uploads/Snapchat-816254440.jpg', '', '', 'Household', 'Housekeeper', '2025-02-04 14:57:20', '2025-02-04 14:57:20', NULL, NULL, 'pending'),
(161, 'Gian Carlo', '', 'Sto. Domingo', 'stodomingogiancarlo6@gmail.com', '$2y$10$IDMHH9JD5ki92.jbDspF9uqI.MoP6pogi7e.BCvUXibECnAyrJRb2', '+639653084714', 'Luzon', 'Cavite City', 'uploads/profile.webp', '', '', 'Construction', 'Site Supervisor', '2025-02-06 05:46:16', '2025-02-20 11:56:36', NULL, NULL, 'pending'),
(162, 'Julius Rod', 'Jodilla', 'Dayag', 'jrodayag@gmail.com', '$2y$10$8osLFpabfiG658wHiO0bJeMct.uXvc4zUgQRWeDQvVAxLPN/NVaqm', '09777607261', 'Luzon', 'Quezon City', 'uploads/inbound5957266661786741650.jpg', 'uploads/inbound8389816871580578497.pdf', '', 'IT', 'IT Support', '2025-02-07 14:08:42', '2025-02-07 14:08:42', NULL, NULL, 'pending'),
(163, 'NESTOR', '', 'OBILLO', 'nestorobillo27@gmail.com', '$2y$10$Hns2Ea23M5lR2iQ5F5jb1e3xBrtdOKXq98M/qBKubssHy0cJHCK4.', '+639771250576', 'Luzon', 'Makati City', 'uploads/profile.webp', '', '', 'Construction', 'Carpenter', '2025-02-08 12:10:52', '2025-02-20 11:56:36', NULL, NULL, 'pending'),
(164, 'Arvie', 'Halili', 'Pelayo', 'arviepelayo05@gmail.com', '$2y$10$ijQz3ZUq3HhAd1lBHQSn1e9gNjca6sGQlETdnJdKr274vwzKXFPQ6', '09602817016', 'Luzon', 'Manila', 'uploads/profile.webp', '', '', 'IT', 'IT Support', '2025-02-08 12:11:03', '2025-02-20 11:56:36', NULL, NULL, 'pending'),
(165, 'Jan Ray Alexes', 'Abaniel', 'Tiglao', 'troying00@gmail.com', '$2y$10$n7BEXF7mHVBxLxC5dD7ibu6HiI1Oii574YVWqpO3W63h80oHzz0Xa', '09098735882', 'Luzon', 'Manila', 'uploads/20250126_150150.jpg', 'uploads/Resume_20250204_164516_0000.pdf', 'uploads/20250201_144937.jpg', 'Construction', 'Mason', '2025-02-09 09:35:06', '2025-02-09 09:35:06', NULL, NULL, 'pending'),
(166, 'Crispin Jr', 'Dilla', 'Presbitero', 'sircbiserp08@gmail.com', '$2y$10$ZI8Y7TnprDRUanIzgNp0G.cYeZo4aAJR3qZ9f4KdoNYQeA02H22vq', '09121233190', 'Luzon', 'Laguna (Santa Cruz, San Pablo, etc.)', 'uploads/inbound2937861070139774014.jpg', '', '', 'Manufacturing', 'Machine Operator', '2025-02-10 02:39:59', '2025-02-10 02:39:59', NULL, NULL, 'pending'),
(167, 'Joel', 'Lanuzo', 'Serafico', 'seraficojoel37@gmail.com', '$2y$10$EVd8dsXa0LTjDQX5J27sX.nY01be8LDYuCjkiIPRZrb97bqeUn9FG', '09503376331', 'Luzon', 'Laguna (Santa Cruz, San Pablo, etc.)', 'uploads/inbound3745031903049558153.jpg', 'uploads/inbound2363736366606488664.docx', 'uploads/inbound7048367198471407348.jpg', 'Construction', 'Carpenter', '2025-02-12 07:37:57', '2025-02-12 07:37:57', NULL, NULL, 'pending'),
(168, 'Kristian', 'Macias', 'Galin', 'kristiangalin04@gmail.com', '$2y$10$gaOhMmv1hubHqJz/cFMD4eNJa0.B5wdiBCv1oicQYLTB6UKnwYTWu', '09217618987', 'Luzon', 'Taguig City', 'uploads/profile.webp', '', '', 'Domestic', 'Gardener', '2025-02-19 05:45:36', '2025-02-20 11:56:36', NULL, NULL, 'pending'),
(169, 'Kristian', 'Macias', 'Galin', '', '$2y$10$DWCiweD.AtTChSpWpvNCv.PyDuxg2YI7AHXpKzck9pBNMlBGdQLZ2', '09217618987', 'Luzon', 'Taguig City', 'uploads/profile.webp', '', '', 'Domestic', 'Gardener', '2025-02-19 05:47:02', '2025-02-20 11:56:36', NULL, NULL, 'pending'),
(170, 'MyName', 'John', 'TestUser', 'juhmythg@do-not-respond.me', '$2y$10$7kqR5sYZ7MEP84IgEvDkVecq8T7NTRdIBee.q5yFoenBO3P2kaEeC', '+34 5350948', 'Select Region', 'Select City', 'uploads/profile.webp', '', '', 'Select Industry', 'Select Position', '2025-03-05 09:08:45', '2025-03-05 09:08:45', NULL, NULL, 'pending'),
(172, 'Maria', 'Santos', 'Dela Cruz', 'maria.delacruz@example.com', '$2y$10$TD4taCT9ZxOYH6F5PEW0pOSwWEve05bEL.vG5le1x72QsYjBbyvtK', '09171234567', 'Luzon', 'Manila', 'uploads/profile123.jpg', 'uploads/resume123.pdf', 'uploads/id123.jpg', 'Construction', 'Carpenter', '2025-04-04 08:26:37', '2025-04-04 08:26:37', NULL, NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `job_openings`
--

CREATE TABLE `job_openings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `workers_needed` int(11) NOT NULL,
  `budget_per_worker` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_openings`
--

INSERT INTO `job_openings` (`id`, `title`, `description`, `workers_needed`, `budget_per_worker`, `start_date`) VALUES
(1, 'Software Engineer', 'A full-time job to develop mobile applications, focusing on Android and iOS platforms. Experience with Kotlin, Java, and Swift is required.', 3, 5000.00, '2024-12-01'),
(2, 'Web Developer', 'A contract position to develop websites for e-commerce businesses. Experience with HTML, CSS, JavaScript, and React is preferred.', 2, 3500.00, '2024-12-10'),
(4, 'Project Manager', 'Lead a team of developers, ensuring timely delivery of software projects. Must have experience in Agile methodology and excellent communication skills.', 1, 6000.00, '2024-12-15'),
(5, 'Graphic Designer', 'A creative position to design graphics for marketing materials and websites. Proficiency in Adobe Photoshop and Illustrator is required.', 2, 4000.00, '2024-12-05'),
(6, 'Mobile App Developer', 'Develop and maintain mobile applications for a variety of industries. Must have expertise in Flutter or React Native.', 2, 4500.00, '2024-12-20'),
(7, 'UI/UX Designer', 'Design user interfaces and experiences for web and mobile applications. A good understanding of user-centered design principles is required.', 2, 3500.00, '2024-12-10'),
(8, 'Network Administrator', 'Ensure the smooth operation of the company’s computer networks. Experience with LAN/WAN management and network security protocols is essential.', 1, 5000.00, '2024-11-28'),
(10, 'Human Resources Manager', 'Responsible for recruiting, onboarding, and employee relations. Must have at least 5 years of experience in HR management.', 1, 5500.00, '2024-12-01'),
(11, 'Web Developer', 'We are looking for an experienced web developer to join our team. The candidate should have expertise in front-end and back-end development with proficiency in HTML, CSS, JavaScript, PHP, and MySQL.', 3, 15000.00, '2025-01-15'),
(12, 'Web Developers', 'Need 3 Skilled Developers specializing in PHP, mySQL', 3, 15000.00, '2025-01-11');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `chat_id` varchar(255) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender`, `receiver`, `message`, `chat_id`, `timestamp`) VALUES
(1, 'Coach Test', 'Maria Santos', 'hi', '', '2024-08-15 17:57:21'),
(2, 'Coach Test', 'Maria Santos', 'hi', 'Coach Test_Maria Santos', '2024-08-15 18:10:27'),
(3, 'Coach Test', 'Maria Santos', 'hi', '165794718-194049439', '2024-08-15 18:27:29'),
(4, 'Coach Test', 'Maria Santos', 'hi', '165794718-194049439', '2024-08-15 18:32:39'),
(5, 'Coach Test', 'Maria Santos', 'im on my way', '165794718-194049439', '2024-08-15 18:32:50'),
(6, 'Coach Test', 'Maria Santos', 'hello', '165794718-194049439', '2024-08-15 18:40:59'),
(7, 'Coach Test', 'Maria Santos', 'hi', '165794718-194049439', '2024-08-15 18:44:00'),
(8, 'Maria Santos', 'Coach Test', 'hello', '194049439-165794718', '2024-08-31 10:45:50'),
(9, 'Maria Santos', 'Coach Test', 'hi', '969489783-165794718', '2024-08-31 10:54:48'),
(12, 'Coach Test', 'Maria Santos', 'hi', '165794718-194049439', '2024-08-31 13:05:49'),
(13, 'Coach Test', 'Maria Santos', 'hi', '165794718-194049439', '2024-08-31 14:17:52'),
(15, 'Maria Santos', 'Coach Test', 'hi', '194049439-165794718', '2024-08-31 17:26:40'),
(16, 'Coach Test', 'Maria Santos', 'hi', '165794718-194049439', '2024-09-01 03:47:31'),
(17, 'Coach Test', 'Maria Santos', 'hello', '165794718-194049439', '2024-09-01 03:48:17'),
(18, 'Coach Test', 'Maria Santos', 'again', '165794718-194049439', '2024-09-01 03:55:49'),
(19, 'Maria Santos', 'Coach Test', '😁😁😁', '194049439-165794718', '2024-09-20 20:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `mobile_num` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `message`, `date`, `mobile_num`) VALUES
(1, 'Welcome', 'Thank you for signing up!', '2024-08-14 14:50:51', '639652560752'),
(8, 'Welcome', 'Thank you for signing up!', '2024-09-20 12:01:17', 'rainbowfam05@gmail.com'),
(9, 'Welcome', 'Thank you for signing up!', '2024-09-21 08:08:26', 'allenwarren_reyes@yahoo.com'),
(10, 'Welcome', 'Thank you for signing up!', '2024-09-21 08:53:17', 'torrentialroar@gmail.com'),
(11, 'Welcome', 'Thank you for signing up!', '2024-09-21 09:23:19', '21-0123c@sgen.edu.ph'),
(12, 'Payment Successful', 'Your payment of P1800 has been successfully processed on Sep 26, 2024.', '2024-09-26 11:04:02', '639652560752'),
(13, 'Payment Successful', 'Your payment of P20000 has been successfully processed on Sep 26 2024.', '2024-09-26 11:10:21', '639652560752'),
(14, 'Payment Successful', 'Your payment of P20000 has been successfully processed on 2024-26-09.', '2024-09-26 11:15:48', '639652560752'),
(15, 'Welcome', 'Thank you for signing up!', '2024-09-26 12:49:45', '9652560754'),
(16, 'Welcome', 'Thank you for signing up!', '2024-09-26 13:32:01', '9652560755');

-- --------------------------------------------------------

--
-- Table structure for table `otp_requests`
--

CREATE TABLE `otp_requests` (
  `id` int(11) NOT NULL,
  `mobile_num` varchar(15) NOT NULL,
  `otp` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `contact_per` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `account_num` varchar(255) NOT NULL,
  `payment_channel` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `name`, `email`, `phone`, `contact_per`, `address`, `account_num`, `payment_channel`, `created_at`) VALUES
(1, 'test agency', 'test@test.com', '09075214643', 'test user3', 'diamond st platinum', '12345254875', 'bank', '2024-08-06 21:02:56');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payer_name` varchar(255) NOT NULL,
  `reference_id` varchar(255) NOT NULL,
  `payment_date` varchar(100) NOT NULL,
  `status` enum('paid','pending','refunded') DEFAULT 'pending',
  `booking_id` varchar(255) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `mobile_num` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bookings`
--

CREATE TABLE `tbl_bookings` (
  `id` int(11) NOT NULL,
  `booking_id` int(20) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `service_booked` varchar(255) NOT NULL,
  `contractor_name` varchar(255) NOT NULL,
  `booked_date` date NOT NULL,
  `booked_time` time NOT NULL,
  `length_of_service` varchar(255) NOT NULL,
  `contractor_rate` varchar(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `service_status` enum('Pending','In Progress','Complete','Cancelled') DEFAULT 'Pending',
  `customer_rate` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_num` varchar(255) NOT NULL,
  `contractor_mobile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_bookings`
--

INSERT INTO `tbl_bookings` (`id`, `booking_id`, `client_name`, `service_booked`, `contractor_name`, `booked_date`, `booked_time`, `length_of_service`, `contractor_rate`, `total_amount`, `service_status`, `customer_rate`, `email`, `mobile_num`, `contractor_mobile`) VALUES
(1, 120321456, 'Test Client', 'Yaya', 'Maria Santos', '2024-08-16', '08:00:00', '3 days', '', 1500.00, 'In Progress', '', 'csv2021tech@gmail.com', '', ''),
(2, 2147483647, 'Coach Test', 'Yaya', 'Maria Santos', '2024-08-17', '01:30:00', 'parttime', '', 1500.00, 'Pending', '', '', 'csv2021tech@gmail.com', 'test6@gmail.com'),
(3, 2147483647, 'Coach Test', 'Yaya', 'Maria Santos', '2024-08-16', '01:50:00', 'parttime', '', 1500.00, 'In Progress', '', '', 'csv2021tech@gmail.com', 'test6@gmail.com'),
(4, 2147483647, 'Coach Test', 'Caregiver', 'Maria Santos', '2024-09-26', '10:16:00', 'Per Day', '', 1500.00, 'Pending', '', '', 'No email address', 'test6@gmail.com'),
(5, 2147483647, 'Coach Test', 'Nanny Services', 'Maria Santos', '2024-09-28', '01:00:00', 'Per Day', '', 1800.00, 'Pending', '', '', '639652560752', '09999999999'),
(6, 2147483647, 'Coach Test', 'Caregiver', 'Maria Santos', '2024-09-28', '03:00:00', 'Per Day', '', 1500.00, 'In Progress', '', '', '639652560752', '09999999999'),
(7, 2147483647, 'Coach Test', 'Yaya', 'Maria Santos', '2024-09-30', '08:00:00', 'Per Month', '', 20000.00, 'Pending', '', '', '639652560752', '09999999999'),
(8, 2147483647, 'Coach Test', 'Yaya', 'Maria Santos', '2024-09-30', '08:00:00', 'Per Month', '', 20000.00, 'Pending', '', '', '639652560752', '09999999999');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `name` varchar(255) NOT NULL,
  `mobile_num` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `name`, `mobile_num`, `address`, `profile_image`, `reset_token`, `reset_token_expiry`) VALUES
(3, 'Test Only', 'csv2021tech@gmail.com', '$2y$10$nqsMApZn0CHAcF5HZQBSJ.rFws2/3YqvKJy8uBwdD.Kag5TgAP7bW', '2024-08-07 04:24:12', 'Coach Test', '639652560752', 'Nova QC', '', '660d2a608e5d5b928002e7a72dee37c5f8966b4125e87a440fcb5806acf9ba00cd543eaaad9940f62e37f87b55b421fa8ca7', '2024-08-07 09:23:29'),
(4, 'SeanWalden', '21-0096c@sgen.edu.ph', '$2y$10$TJPm6fvctRziynvxjgWzE.LfK4FcHal8/jkl52NiSw2PyILMpGMeO', '2024-09-08 01:54:00', 'Sean', '09956410538', 'Las Piñas', NULL, NULL, NULL),
(22, 'warren', 'allenwarren_reyes@yahoo.com', '$2y$10$CuIqAW.Kx5nKwdeb2ID7XOrfZlfl8QzFhXLaBy1xJyVUXgwlO/iBK', '2024-09-21 00:08:26', 'warren reyes', '09052233932', 'las pinas', NULL, NULL, NULL),
(23, 'denwallz', 'torrentialroar@gmail.com', '$2y$10$H/VPhU4b1ByxnqVODHSId.iAs64Nn8h8JJCWzqzyEjqIOwafPoj.m', '2024-09-21 00:53:17', 'Sean Reyes', '9956410538', 'Las Piñas', NULL, NULL, NULL),
(24, 'H2O_Ghost', '21-0123c@sgen.edu.ph', '$2y$10$WYMyHXftpvEDdsYtYc40uedTOZcxxp9rJBHiwiuS7ZqOoEzZ5jGNS', '2024-09-21 01:23:20', 'Casey E. Dowling', '927 837 8769', 'Las Piñas', NULL, NULL, NULL),
(25, 'Test', 'noemail@gmail.com', '$2y$10$fmb.Fd5CwrK5EfYL8Myz3OAbH4cmuNF/1JxisBKCIUSUKhMiTfyWC', '2024-09-26 11:51:24', 'Testing Only', '9652560752', 'Quezon City', NULL, NULL, NULL),
(39, 'Testing', 'noemail@gmail.com', '$2y$10$23d/8buTcfTEmFzrlfybSOL/FYkh3qDnep9zpznJNXZInFATOjHd6', '2024-09-26 12:49:46', 'Coach Testing', '9652560754', 'Quezon City', NULL, NULL, NULL),
(40, 'John', 'noemail@gmail.com', '$2y$10$C4p2KrdRJ3wHuHZnI84jhO70IdrP8ndHyUojBO40ep4/SVvAXsCKK', '2024-09-26 13:32:02', 'John Test', '9652560755', 'Quezon City', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `contractor_id` (`contractor_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_requests`
--
ALTER TABLE `company_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contractors`
--
ALTER TABLE `contractors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contractor_email` (`contractor_email`);

--
-- Indexes for table `contractor_post`
--
ALTER TABLE `contractor_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `individuals`
--
ALTER TABLE `individuals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_openings`
--
ALTER TABLE `job_openings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_requests`
--
ALTER TABLE `otp_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile_num` (`mobile_num`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `mobile_num` (`mobile_num`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `company_requests`
--
ALTER TABLE `company_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contractors`
--
ALTER TABLE `contractors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `contractor_post`
--
ALTER TABLE `contractor_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `individuals`
--
ALTER TABLE `individuals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `job_openings`
--
ALTER TABLE `job_openings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `otp_requests`
--
ALTER TABLE `otp_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`contractor_id`) REFERENCES `contractors` (`id`);

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
