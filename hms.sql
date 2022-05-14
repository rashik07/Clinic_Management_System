-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2022 at 12:36 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctor_id` int(11) NOT NULL,
  `doctor_user_added_id` int(11) NOT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `doctor_description` varchar(255) DEFAULT NULL,
  `doctor_specialization` varchar(255) DEFAULT NULL,
  `doctor_experience` varchar(255) DEFAULT NULL,
  `doctor_age` varchar(255) DEFAULT NULL,
  `doctor_email` varchar(255) DEFAULT NULL,
  `doctor_dob` varchar(255) DEFAULT NULL,
  `doctor_gender` varchar(255) DEFAULT NULL,
  `doctor_blood_group` varchar(255) DEFAULT NULL,
  `doctor_visit_fee` varchar(255) DEFAULT NULL,
  `doctor_phone` varchar(255) DEFAULT NULL,
  `doctor_emergency_phone` varchar(255) DEFAULT NULL,
  `doctor_address` varchar(255) DEFAULT NULL,
  `doctor_status` varchar(255) DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `document_url` varchar(255) DEFAULT NULL,
  `doctor_creation_time` datetime DEFAULT current_timestamp(),
  `doctor_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctor_id`, `doctor_user_added_id`, `doctor_name`, `doctor_description`, `doctor_specialization`, `doctor_experience`, `doctor_age`, `doctor_email`, `doctor_dob`, `doctor_gender`, `doctor_blood_group`, `doctor_visit_fee`, `doctor_phone`, `doctor_emergency_phone`, `doctor_address`, `doctor_status`, `photo_url`, `document_url`, `doctor_creation_time`, `doctor_modification_time`) VALUES
(1, 2, 'Dr rais', '', '', '', '', '', '', '', '', '500', '', '', '', 'active', '', '', '2022-04-25 13:18:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `indoor_bed`
--

CREATE TABLE `indoor_bed` (
  `indoor_bed_id` int(11) NOT NULL,
  `indoor_bed_user_added_id` int(11) NOT NULL,
  `indoor_bed_category_id` int(11) NOT NULL,
  `indoor_bed_name` varchar(255) NOT NULL,
  `indoor_bed_room_no` varchar(255) DEFAULT NULL,
  `indoor_bed_price` varchar(255) DEFAULT NULL,
  `indoor_bed_status` varchar(255) DEFAULT NULL,
  `indoor_bed_creation_time` datetime DEFAULT current_timestamp(),
  `indoor_bed_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `indoor_bed`
--

INSERT INTO `indoor_bed` (`indoor_bed_id`, `indoor_bed_user_added_id`, `indoor_bed_category_id`, `indoor_bed_name`, `indoor_bed_room_no`, `indoor_bed_price`, `indoor_bed_status`, `indoor_bed_creation_time`, `indoor_bed_modification_time`) VALUES
(1, 1, 1, '101', '1100', '1000', 'available', '2022-05-11 12:14:41', '2022-05-11 12:14:41'),
(2, 1, 2, '201', '2100', '1500', 'available', '2022-05-11 12:14:41', '2022-05-11 12:14:41'),
(3, 1, 3, '301', '3100', '2500', 'available', '2022-05-11 12:14:41', '2022-05-11 12:14:41'),
(4, 1, 4, '401', '4100', '2000', 'available', '2022-05-11 12:14:41', '2022-05-11 12:14:41');

-- --------------------------------------------------------

--
-- Table structure for table `indoor_bed_category`
--

CREATE TABLE `indoor_bed_category` (
  `indoor_bed_category_id` int(11) NOT NULL,
  `indoor_bed_category_user_added_id` int(11) NOT NULL,
  `indoor_bed_category_name` varchar(255) NOT NULL,
  `indoor_bed_category_description` varchar(255) NOT NULL,
  `indoor_bed_category_status` varchar(255) DEFAULT NULL,
  `indoor_bed_category_creation_time` datetime DEFAULT current_timestamp(),
  `indoor_bed_category_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `indoor_bed_category`
--

INSERT INTO `indoor_bed_category` (`indoor_bed_category_id`, `indoor_bed_category_user_added_id`, `indoor_bed_category_name`, `indoor_bed_category_description`, `indoor_bed_category_status`, `indoor_bed_category_creation_time`, `indoor_bed_category_modification_time`) VALUES
(1, 1, 'Ward-Male', 'General Male Ward', 'active', '2022-05-11 12:14:41', '2022-05-11 12:14:41'),
(2, 1, 'Ward-Female', 'General Female Ward', 'active', '2022-05-11 12:14:41', '2022-05-11 12:14:41'),
(3, 1, 'Cabin-AC', 'AC Cabin', 'active', '2022-05-11 12:14:41', '2022-05-11 12:14:41'),
(4, 1, 'Cabin-Non AC', 'Non AC Cabin', 'active', '2022-05-11 12:14:41', '2022-05-11 12:14:41');

-- --------------------------------------------------------

--
-- Table structure for table `indoor_treatment`
--

CREATE TABLE `indoor_treatment` (
  `indoor_treatment_id` int(11) NOT NULL,
  `indoor_treatment_admission_id` varchar(255) DEFAULT NULL,
  `indoor_treatment_user_added_id` int(11) NOT NULL,
  `indoor_treatment_patient_id` int(11) NOT NULL,
  `indoor_treatment_reference` varchar(255) DEFAULT NULL,
  `indoor_treatment_total_bill` varchar(255) DEFAULT NULL,
  `indoor_treatment_total_bill_after_discount` varchar(255) DEFAULT NULL,
  `indoor_treatment_discount_pc` varchar(255) DEFAULT '0',
  `indoor_treatment_total_paid` varchar(255) DEFAULT NULL,
  `indoor_treatment_total_due` varchar(255) DEFAULT '0',
  `indoor_treatment_payment_type` varchar(255) DEFAULT NULL,
  `indoor_treatment_payment_type_no` varchar(255) DEFAULT NULL,
  `indoor_treatment_note` varchar(255) DEFAULT NULL,
  `indoor_treatment_creation_time` datetime DEFAULT current_timestamp(),
  `indoor_treatment_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `indoor_treatment_bed`
--

CREATE TABLE `indoor_treatment_bed` (
  `indoor_treatment_bed_id` int(11) NOT NULL,
  `indoor_treatment_bed_user_added_id` int(11) NOT NULL,
  `indoor_treatment_bed_treatment_id` int(11) NOT NULL,
  `indoor_treatment_bed_bed_id` int(11) NOT NULL,
  `indoor_treatment_bed_category_name` varchar(255) DEFAULT NULL,
  `indoor_treatment_bed_price` varchar(255) DEFAULT NULL,
  `indoor_treatment_bed_total_bill` varchar(255) DEFAULT NULL,
  `indoor_treatment_bed_entry_time` datetime DEFAULT current_timestamp(),
  `indoor_treatment_bed_discharge_time` datetime DEFAULT NULL,
  `indoor_treatment_bed_creation_time` datetime DEFAULT current_timestamp(),
  `indoor_treatment_bed_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `indoor_treatment_doctor`
--

CREATE TABLE `indoor_treatment_doctor` (
  `indoor_treatment_doctor_id` int(11) NOT NULL,
  `indoor_treatment_doctor_user_added_id` int(11) NOT NULL,
  `indoor_treatment_doctor_treatment_id` int(11) NOT NULL,
  `indoor_treatment_doctor_doctor_id` int(11) NOT NULL,
  `indoor_treatment_doctor_specialization` varchar(255) DEFAULT NULL,
  `indoor_treatment_doctor_visit_fee` varchar(255) DEFAULT NULL,
  `indoor_treatment_doctor_total_bill` varchar(255) DEFAULT NULL,
  `indoor_treatment_doctor_entry_time` datetime DEFAULT current_timestamp(),
  `indoor_treatment_doctor_discharge_time` datetime DEFAULT NULL,
  `indoor_treatment_doctor_creation_time` datetime DEFAULT current_timestamp(),
  `indoor_treatment_doctor_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `medicine_id` int(11) NOT NULL,
  `medicine_user_added_id` int(11) NOT NULL,
  `medicine_name` varchar(255) DEFAULT NULL,
  `medicine_generic_name` varchar(255) DEFAULT NULL,
  `medicine_description` varchar(255) DEFAULT NULL,
  `medicine_purchase_price` varchar(255) DEFAULT NULL,
  `medicine_selling_price` varchar(255) DEFAULT NULL,
  `medicine_unit` int(11) NOT NULL,
  `medicine_leaf` int(11) NOT NULL,
  `medicine_manufacturer` int(11) NOT NULL,
  `medicine_status` varchar(255) DEFAULT NULL,
  `medicine_creation_time` datetime DEFAULT current_timestamp(),
  `medicine_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`medicine_id`, `medicine_user_added_id`, `medicine_name`, `medicine_generic_name`, `medicine_description`, `medicine_purchase_price`, `medicine_selling_price`, `medicine_unit`, `medicine_leaf`, `medicine_manufacturer`, `medicine_status`, `medicine_creation_time`, `medicine_modification_time`) VALUES
(1, 2, 'napa', 'Paracetamol', '', '80', '100', 1, 1, 1, 'active', '2022-05-11 12:20:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_category`
--

CREATE TABLE `medicine_category` (
  `medicine_category_id` int(11) NOT NULL,
  `medicine_category_user_added_id` int(11) NOT NULL,
  `medicine_category_name` varchar(255) DEFAULT NULL,
  `medicine_category_description` varchar(255) DEFAULT NULL,
  `medicine_category_creation_time` datetime DEFAULT current_timestamp(),
  `medicine_category_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_leaf`
--

CREATE TABLE `medicine_leaf` (
  `medicine_leaf_id` int(11) NOT NULL,
  `medicine_leaf_user_added_id` int(11) NOT NULL,
  `medicine_leaf_name` varchar(255) DEFAULT NULL,
  `medicine_leaf_description` varchar(255) DEFAULT NULL,
  `medicine_leaf_total_per_box` varchar(255) DEFAULT NULL,
  `medicine_leaf_creation_time` datetime DEFAULT current_timestamp(),
  `medicine_leaf_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medicine_leaf`
--

INSERT INTO `medicine_leaf` (`medicine_leaf_id`, `medicine_leaf_user_added_id`, `medicine_leaf_name`, `medicine_leaf_description`, `medicine_leaf_total_per_box`, `medicine_leaf_creation_time`, `medicine_leaf_modification_time`) VALUES
(1, 2, '10', '', '5', '2022-05-11 12:18:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_manufacturer`
--

CREATE TABLE `medicine_manufacturer` (
  `medicine_manufacturer_id` int(11) NOT NULL,
  `medicine_manufacturer_user_added_id` int(11) NOT NULL,
  `medicine_manufacturer_name` varchar(255) DEFAULT NULL,
  `medicine_manufacturer_address` varchar(255) DEFAULT NULL,
  `medicine_manufacturer_mobile` varchar(255) DEFAULT NULL,
  `medicine_manufacturer_email` varchar(255) DEFAULT NULL,
  `medicine_manufacturer_city` varchar(255) DEFAULT NULL,
  `medicine_manufacturer_state` varchar(255) DEFAULT NULL,
  `medicine_manufacturer_description` varchar(255) DEFAULT NULL,
  `medicine_manufacturer_creation_time` datetime DEFAULT current_timestamp(),
  `medicine_manufacturer_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medicine_manufacturer`
--

INSERT INTO `medicine_manufacturer` (`medicine_manufacturer_id`, `medicine_manufacturer_user_added_id`, `medicine_manufacturer_name`, `medicine_manufacturer_address`, `medicine_manufacturer_mobile`, `medicine_manufacturer_email`, `medicine_manufacturer_city`, `medicine_manufacturer_state`, `medicine_manufacturer_description`, `medicine_manufacturer_creation_time`, `medicine_manufacturer_modification_time`) VALUES
(1, 2, 'IBN SINA', 'dhaka', '01726312348', '', 'dhaka', '', '', '2022-05-11 12:19:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_type`
--

CREATE TABLE `medicine_type` (
  `medicine_type_id` int(11) NOT NULL,
  `medicine_type_user_added_id` int(11) NOT NULL,
  `medicine_type_name` varchar(255) DEFAULT NULL,
  `medicine_type_description` varchar(255) DEFAULT NULL,
  `medicine_type_creation_time` datetime DEFAULT current_timestamp(),
  `medicine_type_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_unit`
--

CREATE TABLE `medicine_unit` (
  `medicine_unit_id` int(11) NOT NULL,
  `medicine_unit_user_added_id` int(11) NOT NULL,
  `medicine_unit_name` varchar(255) DEFAULT NULL,
  `medicine_unit_description` varchar(255) DEFAULT NULL,
  `medicine_unit_creation_time` datetime DEFAULT current_timestamp(),
  `medicine_unit_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medicine_unit`
--

INSERT INTO `medicine_unit` (`medicine_unit_id`, `medicine_unit_user_added_id`, `medicine_unit_name`, `medicine_unit_description`, `medicine_unit_creation_time`, `medicine_unit_modification_time`) VALUES
(1, 2, 'piece', '', '2022-05-11 12:16:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ot_treatment`
--

CREATE TABLE `ot_treatment` (
  `ot_treatment_id` int(11) NOT NULL,
  `ot_treatment_user_added_id` int(11) NOT NULL,
  `ot_treatment_patient_id` int(11) NOT NULL,
  `ot_treatment_indoor_treatment_id` int(11) DEFAULT NULL,
  `ot_treatment_reference` varchar(255) DEFAULT NULL,
  `ot_treatment_total_bill` varchar(255) DEFAULT NULL,
  `ot_treatment_total_bill_after_discount` varchar(255) DEFAULT NULL,
  `ot_treatment_discount_pc` varchar(255) DEFAULT '0',
  `ot_treatment_total_paid` varchar(255) DEFAULT NULL,
  `ot_treatment_total_due` varchar(255) DEFAULT '0',
  `ot_treatment_payment_type` varchar(255) DEFAULT NULL,
  `ot_treatment_payment_type_no` varchar(255) DEFAULT NULL,
  `ot_treatment_note` varchar(255) DEFAULT NULL,
  `ot_treatment_date` datetime DEFAULT current_timestamp(),
  `ot_treatment_creation_time` datetime DEFAULT current_timestamp(),
  `ot_treatment_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ot_treatment_doctor`
--

CREATE TABLE `ot_treatment_doctor` (
  `ot_treatment_doctor_id` int(11) NOT NULL,
  `ot_treatment_doctor_user_added_id` int(11) NOT NULL,
  `ot_treatment_doctor_doctor_id` int(11) NOT NULL,
  `ot_treatment_doctor_treatment_id` int(11) NOT NULL,
  `ot_treatment_doctor_bill` varchar(255) DEFAULT NULL,
  `ot_treatment_doctor_note` varchar(255) DEFAULT NULL,
  `ot_treatment_doctor_creation_time` datetime DEFAULT current_timestamp(),
  `ot_treatment_doctor_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ot_treatment_guest_doctor`
--

CREATE TABLE `ot_treatment_guest_doctor` (
  `ot_treatment_guest_doctor_id` int(11) NOT NULL,
  `ot_treatment_guest_doctor_user_added_id` int(11) NOT NULL,
  `ot_treatment_guest_doctor_doctor_name` varchar(255) DEFAULT NULL,
  `ot_treatment_guest_doctor_treatment_id` int(11) NOT NULL,
  `ot_treatment_guest_doctor_bill` varchar(255) DEFAULT NULL,
  `ot_treatment_guest_doctor_note` varchar(255) DEFAULT NULL,
  `ot_treatment_guest_doctor_creation_time` datetime DEFAULT current_timestamp(),
  `ot_treatment_guest_doctor_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ot_treatment_item`
--

CREATE TABLE `ot_treatment_item` (
  `ot_treatment_item_id` int(11) NOT NULL,
  `ot_treatment_item_user_added_id` int(11) NOT NULL,
  `ot_treatment_item_treatment_id` int(11) NOT NULL,
  `ot_treatment_item_name` varchar(255) DEFAULT NULL,
  `ot_treatment_item_price` varchar(255) DEFAULT NULL,
  `ot_treatment_item_note` varchar(255) DEFAULT NULL,
  `ot_treatment_item_creation_time` datetime DEFAULT current_timestamp(),
  `ot_treatment_item_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ot_treatment_pharmacy_item`
--

CREATE TABLE `ot_treatment_pharmacy_item` (
  `ot_treatment_pharmacy_item_id` int(11) NOT NULL,
  `ot_treatment_pharmacy_item_user_added_id` int(11) NOT NULL,
  `ot_treatment_pharmacy_item_treatment_id` int(11) NOT NULL,
  `ot_treatment_pharmacy_item_medicine_id` int(11) NOT NULL,
  `ot_treatment_pharmacy_item_batch_id` varchar(255) DEFAULT NULL,
  `ot_treatment_pharmacy_item_stock_qty` varchar(255) DEFAULT NULL,
  `ot_treatment_pharmacy_item_per_piece_price` varchar(255) DEFAULT NULL,
  `ot_treatment_pharmacy_item_quantity` varchar(255) DEFAULT NULL,
  `ot_treatment_pharmacy_item_bill` varchar(255) DEFAULT NULL,
  `ot_treatment_pharmacy_item_note` varchar(255) DEFAULT NULL,
  `ot_treatment_pharmacy_item_creation_time` datetime DEFAULT current_timestamp(),
  `ot_treatment_pharmacy_item_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `outdoor_service`
--

CREATE TABLE `outdoor_service` (
  `outdoor_service_id` int(11) NOT NULL,
  `outdoor_service_user_added_id` int(11) NOT NULL,
  `outdoor_service_name` varchar(255) NOT NULL,
  `outdoor_service_Category` varchar(255) NOT NULL,
  `outdoor_service_room_no` varchar(255) DEFAULT NULL,
  `outdoor_service_description` varchar(255) DEFAULT NULL,
  `outdoor_service_rate` varchar(255) DEFAULT NULL,
  `outdoor_service_creation_time` datetime DEFAULT current_timestamp(),
  `outdoor_service_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `outdoor_service`
--

INSERT INTO `outdoor_service` (`outdoor_service_id`, `outdoor_service_user_added_id`, `outdoor_service_name`, `outdoor_service_Category`, `outdoor_service_room_no`, `outdoor_service_description`, `outdoor_service_rate`, `outdoor_service_creation_time`, `outdoor_service_modification_time`) VALUES
(1, 2, 'Doctor Visit', 'Doctor Visit', NULL, '', '500', '2022-04-27 15:03:26', NULL),
(2, 2, 'Pluster', 'Procedures', NULL, '', '1000', '2022-04-27 15:03:48', NULL),
(3, 2, 'Physiotherapy one', 'Physiotherapy', NULL, '', '1000', '2022-04-27 15:05:15', NULL),
(5, 2, 'OT charge', 'OT', NULL, '', '500', '2022-04-27 15:37:27', NULL),
(6, 2, 'Cardiac monitor charge', 'OT', NULL, '', '200', '2022-04-27 15:37:54', NULL),
(7, 2, 'Surgon charge (Dressing)', 'OT', NULL, '', '5000', '2022-04-27 15:40:39', NULL),
(8, 2, 'PA chest xray', 'Investigation/Test', '303', '', '800', '2022-04-29 15:40:18', '2022-04-29 15:47:03'),
(9, 2, 'RBS', 'Investigation/Test', '203', '', '300', '2022-04-29 16:37:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `outdoor_treatment`
--

CREATE TABLE `outdoor_treatment` (
  `outdoor_treatment_id` int(11) NOT NULL,
  `outdoor_treatment_invoice_id` varchar(255) DEFAULT NULL,
  `outdoor_treatment_user_added_id` int(11) NOT NULL,
  `outdoor_treatment_patient_id` int(11) NOT NULL,
  `outdoor_treatment_indoor_treatment_id` int(11) DEFAULT NULL,
  `outdoor_treatment_outdoor_service_Category` varchar(255) DEFAULT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `patient_age` varchar(255) DEFAULT NULL,
  `patient_gender` varchar(255) DEFAULT NULL,
  `patient_phone` varchar(255) DEFAULT NULL,
  `outdoor_treatment_consultant` varchar(255) DEFAULT NULL,
  `outdoor_treatment_reference` varchar(255) DEFAULT NULL,
  `outdoor_treatment_total_bill` varchar(255) DEFAULT '0',
  `outdoor_treatment_total_bill_after_discount` varchar(255) DEFAULT '0',
  `outdoor_treatment_discount_pc` varchar(255) DEFAULT '0',
  `outdoor_treatment_exemption` varchar(255) DEFAULT '0',
  `outdoor_treatment_total_paid` varchar(255) DEFAULT '0',
  `outdoor_treatment_total_due` varchar(255) DEFAULT '0',
  `outdoor_treatment_payment_type` varchar(255) DEFAULT NULL,
  `outdoor_treatment_payment_type_no` varchar(255) DEFAULT NULL,
  `outdoor_treatment_note` varchar(255) DEFAULT NULL,
  `outdoor_treatment_creation_time` datetime DEFAULT current_timestamp(),
  `outdoor_treatment_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `outdoor_treatment`
--

INSERT INTO `outdoor_treatment` (`outdoor_treatment_id`, `outdoor_treatment_invoice_id`, `outdoor_treatment_user_added_id`, `outdoor_treatment_patient_id`, `outdoor_treatment_indoor_treatment_id`, `outdoor_treatment_outdoor_service_Category`, `patient_name`, `patient_age`, `patient_gender`, `patient_phone`, `outdoor_treatment_consultant`, `outdoor_treatment_reference`, `outdoor_treatment_total_bill`, `outdoor_treatment_total_bill_after_discount`, `outdoor_treatment_discount_pc`, `outdoor_treatment_exemption`, `outdoor_treatment_total_paid`, `outdoor_treatment_total_due`, `outdoor_treatment_payment_type`, `outdoor_treatment_payment_type_no`, `outdoor_treatment_note`, `outdoor_treatment_creation_time`, `outdoor_treatment_modification_time`) VALUES
(1, '1152022132543', 2, 1000, NULL, 'Doctor Visit', 'Sadik Ahammed', '29', 'male', '01686076067', '1', '', '500', '500', '0', '', '171', '329', 'cash', '', '', '2022-05-11 13:25:43', '2022-05-14 14:38:57');

-- --------------------------------------------------------

--
-- Table structure for table `outdoor_treatment_service`
--

CREATE TABLE `outdoor_treatment_service` (
  `outdoor_treatment_service_id` int(11) NOT NULL,
  `outdoor_treatment_service_user_added_id` int(11) NOT NULL,
  `outdoor_treatment_service_treatment_id` int(11) NOT NULL,
  `outdoor_treatment_service_service_id` int(11) NOT NULL,
  `outdoor_treatment_service_service_quantity` varchar(255) DEFAULT '0',
  `outdoor_treatment_service_service_rate` varchar(255) DEFAULT '0',
  `outdoor_treatment_service_discount_pc` varchar(255) DEFAULT '0',
  `outdoor_treatment_service_service_total` varchar(255) DEFAULT '0',
  `outdoor_treatment_service_creation_time` datetime DEFAULT current_timestamp(),
  `outdoor_treatment_service_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `outdoor_treatment_service`
--

INSERT INTO `outdoor_treatment_service` (`outdoor_treatment_service_id`, `outdoor_treatment_service_user_added_id`, `outdoor_treatment_service_treatment_id`, `outdoor_treatment_service_service_id`, `outdoor_treatment_service_service_quantity`, `outdoor_treatment_service_service_rate`, `outdoor_treatment_service_discount_pc`, `outdoor_treatment_service_service_total`, `outdoor_treatment_service_creation_time`, `outdoor_treatment_service_modification_time`) VALUES
(4, 2, 1, 1, '1', '500', '', '500', '2022-05-14 14:38:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pathology_investigation`
--

CREATE TABLE `pathology_investigation` (
  `pathology_investigation_id` int(11) NOT NULL,
  `pathology_investigation_user_added_id` int(11) NOT NULL,
  `pathology_investigation_patient_id` int(11) NOT NULL,
  `pathology_investigation_indoor_treatment_id` int(11) DEFAULT NULL,
  `pathology_investigation_treatment_reference` varchar(255) DEFAULT NULL,
  `pathology_investigation_total_bill` varchar(255) DEFAULT NULL,
  `pathology_investigation_total_bill_after_discount` varchar(255) DEFAULT NULL,
  `pathology_investigation_discount_pc` varchar(255) DEFAULT '0',
  `pathology_investigation_total_paid` varchar(255) DEFAULT NULL,
  `pathology_investigation_total_due` varchar(255) DEFAULT '0',
  `pathology_investigation_payment_type` varchar(255) DEFAULT NULL,
  `pathology_investigation_payment_type_no` varchar(255) DEFAULT NULL,
  `pathology_investigation_note` varchar(255) DEFAULT NULL,
  `pathology_investigation_date` datetime DEFAULT current_timestamp(),
  `pathology_investigation_creation_time` datetime DEFAULT current_timestamp(),
  `pathology_investigation_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pathology_investigation_test`
--

CREATE TABLE `pathology_investigation_test` (
  `pathology_investigation_test_id` int(11) NOT NULL,
  `pathology_investigation_test_user_added_id` int(11) NOT NULL,
  `pathology_investigation_test_investigation_id` int(11) NOT NULL,
  `pathology_investigation_test_pathology_test_id` int(11) NOT NULL,
  `pathology_investigation_test_room_no` varchar(255) DEFAULT NULL,
  `pathology_investigation_test_price` varchar(255) DEFAULT NULL,
  `pathology_investigation_test_quantity` varchar(255) DEFAULT '0',
  `pathology_investigation_test_dc` varchar(255) DEFAULT NULL,
  `pathology_investigation_test_total_bill` varchar(255) DEFAULT NULL,
  `pathology_investigation_creation_time` datetime DEFAULT current_timestamp(),
  `pathology_investigation_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pathology_test`
--

CREATE TABLE `pathology_test` (
  `pathology_test_id` int(11) NOT NULL,
  `pathology_test_user_added_id` int(11) NOT NULL,
  `pathology_test_name` varchar(255) DEFAULT NULL,
  `pathology_test_description` varchar(255) DEFAULT NULL,
  `pathology_test_room_no` varchar(255) DEFAULT NULL,
  `pathology_test_price` varchar(255) DEFAULT NULL,
  `pathology_test_creation_time` datetime DEFAULT current_timestamp(),
  `pathology_test_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL,
  `patient_user_added_id` int(11) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `patient_description` varchar(255) DEFAULT NULL,
  `patient_age` varchar(255) DEFAULT NULL,
  `patient_email` varchar(255) DEFAULT NULL,
  `patient_dob` varchar(255) DEFAULT NULL,
  `patient_gender` varchar(255) DEFAULT NULL,
  `patient_blood_group` varchar(255) DEFAULT NULL,
  `patient_phone` varchar(255) DEFAULT NULL,
  `patient_address` varchar(255) DEFAULT NULL,
  `patient_status` varchar(255) DEFAULT NULL,
  `patient_creation_time` datetime DEFAULT current_timestamp(),
  `patient_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `patient_user_added_id`, `patient_name`, `patient_description`, `patient_age`, `patient_email`, `patient_dob`, `patient_gender`, `patient_blood_group`, `patient_phone`, `patient_address`, `patient_status`, `patient_creation_time`, `patient_modification_time`) VALUES
(1000, 2, 'Sadik Ahammed', '', '29', '', '', 'male', '', '01686076067', '', 'active', '2022-04-25 13:14:15', NULL),
(1003, 2, 'Muzahid', '', '29', '', '', 'male', '', '', '', 'active', '2022-04-25 13:17:04', NULL),
(1004, 2, 'Rashik Saif', '', '30', '', '', 'male', 'B+', '01913846060', '', 'active', '2022-04-25 13:18:07', NULL),
(1005, 2, 'Jodu modu', '', '20', '', '', 'male', '', '', '', 'active', '2022-04-25 13:39:45', NULL),
(1006, 2, 'Rahat', '', '28', '', '', 'female', '', '', '', 'active', '2022-04-25 13:50:37', NULL),
(1007, 2, 'Rahat', '', '28', '', '', 'female', '', '', '', 'active', '2022-04-25 13:51:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_medicine`
--

CREATE TABLE `pharmacy_medicine` (
  `pharmacy_medicine_id` int(11) NOT NULL,
  `pharmacy_medicine_user_added_id` int(11) NOT NULL,
  `pharmacy_medicine_medicine_id` int(11) NOT NULL,
  `pharmacy_medicine_quantity` varchar(255) DEFAULT NULL,
  `pharmacy_medicine_batch_id` varchar(255) DEFAULT NULL,
  `pharmacy_medicine_exp_date` datetime DEFAULT NULL,
  `pharmacy_medicine_creation_time` datetime DEFAULT current_timestamp(),
  `pharmacy_medicine_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pharmacy_medicine`
--

INSERT INTO `pharmacy_medicine` (`pharmacy_medicine_id`, `pharmacy_medicine_user_added_id`, `pharmacy_medicine_medicine_id`, `pharmacy_medicine_quantity`, `pharmacy_medicine_batch_id`, `pharmacy_medicine_exp_date`, `pharmacy_medicine_creation_time`, `pharmacy_medicine_modification_time`) VALUES
(19, 2, 1, '250', '100', '2022-05-12 00:00:00', '2022-05-12 15:51:18', '2022-05-12 17:29:23'),
(20, 2, 1, '150', '1004', '2022-05-21 00:00:00', '2022-05-14 15:28:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_purchase`
--

CREATE TABLE `pharmacy_purchase` (
  `pharmacy_purchase_id` int(11) NOT NULL,
  `pharmacy_purchase_user_added_id` int(11) NOT NULL,
  `pharmacy_purchase_manufacturer_id` int(11) NOT NULL,
  `pharmacy_purchase_date` datetime DEFAULT current_timestamp(),
  `pharmacy_purchase_invoice_no` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_sub_total` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_vat` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_discount` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_grand_total` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_paid_amount` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_due_amount` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_creation_time` datetime DEFAULT current_timestamp(),
  `pharmacy_purchase_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pharmacy_purchase`
--

INSERT INTO `pharmacy_purchase` (`pharmacy_purchase_id`, `pharmacy_purchase_user_added_id`, `pharmacy_purchase_manufacturer_id`, `pharmacy_purchase_date`, `pharmacy_purchase_invoice_no`, `pharmacy_purchase_sub_total`, `pharmacy_purchase_vat`, `pharmacy_purchase_discount`, `pharmacy_purchase_grand_total`, `pharmacy_purchase_paid_amount`, `pharmacy_purchase_due_amount`, `pharmacy_purchase_creation_time`, `pharmacy_purchase_modification_time`) VALUES
(20, 2, 1, '2022-05-12 00:00:00', '1001', '160', '', '', '160', '1', '159', '2022-05-12 15:51:18', '2022-05-12 16:16:09'),
(21, 2, 1, '2022-05-12 00:00:00', '1002', '80', '', '', '80', '2', '78', '2022-05-12 15:54:13', '2022-05-12 16:01:42'),
(22, 2, 1, '2022-05-12 00:00:00', '1003', '160', '', '', '160', '2', '158', '2022-05-12 16:06:46', '2022-05-12 17:29:23'),
(23, 2, 1, '2022-05-15 00:00:00', '1005', '240', '', '', '240', '12', '228', '2022-05-14 15:28:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_purchase_medicine`
--

CREATE TABLE `pharmacy_purchase_medicine` (
  `pharmacy_purchase_medicine_id` int(11) NOT NULL,
  `pharmacy_purchase_medicine_user_added_id` int(11) NOT NULL,
  `pharmacy_purchase_medicine_medicine_id` int(11) NOT NULL,
  `pharmacy_purchase_medicine_purchase_id` int(11) NOT NULL,
  `pharmacy_purchase_medicine_batch_id` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_medicine_exp_date` datetime DEFAULT current_timestamp(),
  `pharmacy_purchase_medicine_box_quantity` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_medicine_total_pieces` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_medicine_manufacture_price` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_medicine_box_mrp` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_medicine_total_purchase_price` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_medicine_creation_time` datetime DEFAULT current_timestamp(),
  `pharmacy_purchase_medicine_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pharmacy_purchase_medicine`
--

INSERT INTO `pharmacy_purchase_medicine` (`pharmacy_purchase_medicine_id`, `pharmacy_purchase_medicine_user_added_id`, `pharmacy_purchase_medicine_medicine_id`, `pharmacy_purchase_medicine_purchase_id`, `pharmacy_purchase_medicine_batch_id`, `pharmacy_purchase_medicine_exp_date`, `pharmacy_purchase_medicine_box_quantity`, `pharmacy_purchase_medicine_total_pieces`, `pharmacy_purchase_medicine_manufacture_price`, `pharmacy_purchase_medicine_box_mrp`, `pharmacy_purchase_medicine_total_purchase_price`, `pharmacy_purchase_medicine_creation_time`, `pharmacy_purchase_medicine_modification_time`) VALUES
(111, 2, 19, 21, '100', '2022-05-12 16:02:05', '1', '50', '80', '100', '80', '2022-05-12 16:02:05', NULL),
(114, 2, 19, 20, '100', '2022-05-12 16:16:09', '2', '100', '80', '100', '160', '2022-05-12 16:16:09', NULL),
(116, 2, 19, 22, '100', '2022-05-12 17:29:23', '2', '100', '80', '100', '160', '2022-05-12 17:29:23', NULL),
(117, 2, 20, 23, '1004', '2022-05-14 15:28:29', '3', '150', '80', '100', '240', '2022-05-14 15:28:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_sell`
--

CREATE TABLE `pharmacy_sell` (
  `pharmacy_sell_id` int(11) NOT NULL,
  `pharmacy_sell_invoice_id` varchar(255) DEFAULT NULL,
  `pharmacy_sell_user_added_id` int(11) NOT NULL,
  `pharmacy_sell_patient_id` int(11) DEFAULT NULL,
  `pharmacy_sell_indoor_treatment_id` int(11) DEFAULT NULL,
  `pharmacy_sell_date` datetime DEFAULT current_timestamp(),
  `pharmacy_sell_sub_total` varchar(255) DEFAULT NULL,
  `pharmacy_sell_vat` varchar(255) DEFAULT NULL,
  `pharmacy_sell_discount` varchar(255) DEFAULT NULL,
  `pharmacy_sell_grand_total` varchar(255) DEFAULT NULL,
  `pharmacy_sell_paid_amount` varchar(255) DEFAULT NULL,
  `pharmacy_sell_due_amount` varchar(255) DEFAULT NULL,
  `pharmacy_sell_creation_time` datetime DEFAULT current_timestamp(),
  `pharmacy_sell_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pharmacy_sell`
--

INSERT INTO `pharmacy_sell` (`pharmacy_sell_id`, `pharmacy_sell_invoice_id`, `pharmacy_sell_user_added_id`, `pharmacy_sell_patient_id`, `pharmacy_sell_indoor_treatment_id`, `pharmacy_sell_date`, `pharmacy_sell_sub_total`, `pharmacy_sell_vat`, `pharmacy_sell_discount`, `pharmacy_sell_grand_total`, `pharmacy_sell_paid_amount`, `pharmacy_sell_due_amount`, `pharmacy_sell_creation_time`, `pharmacy_sell_modification_time`) VALUES
(15, '1452022143424', 2, 1000, NULL, '2022-05-20 00:00:00', '20', '', '', '20', '10', '10', '2022-05-14 14:34:24', '2022-05-14 14:35:10');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_sell_medicine`
--

CREATE TABLE `pharmacy_sell_medicine` (
  `pharmacy_sell_medicine_id` int(11) NOT NULL,
  `pharmacy_sell_medicine_user_added_id` int(11) NOT NULL,
  `pharmacy_sell_medicine_medicine_id` int(11) NOT NULL,
  `pharmacy_sell_medicine_sell_id` int(11) NOT NULL,
  `pharmacy_sell_medicine_batch_id` varchar(255) DEFAULT NULL,
  `pharmacy_sell_medicine_exp_date` datetime DEFAULT current_timestamp(),
  `pharmacy_sell_medicine_per_piece_price` varchar(255) DEFAULT NULL,
  `pharmacy_sell_medicine_selling_piece` varchar(255) DEFAULT NULL,
  `pharmacy_sell_medicine_total_selling_price` varchar(255) DEFAULT NULL,
  `pharmacy_sell_medicine_creation_time` datetime DEFAULT current_timestamp(),
  `pharmacy_sell_medicine_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pharmacy_sell_medicine`
--

INSERT INTO `pharmacy_sell_medicine` (`pharmacy_sell_medicine_id`, `pharmacy_sell_medicine_user_added_id`, `pharmacy_sell_medicine_medicine_id`, `pharmacy_sell_medicine_sell_id`, `pharmacy_sell_medicine_batch_id`, `pharmacy_sell_medicine_exp_date`, `pharmacy_sell_medicine_per_piece_price`, `pharmacy_sell_medicine_selling_piece`, `pharmacy_sell_medicine_total_selling_price`, `pharmacy_sell_medicine_creation_time`, `pharmacy_sell_medicine_modification_time`) VALUES
(20, 2, 19, 15, '100', '2022-05-12 00:00:00', '2', '10', '20', '2022-05-14 14:35:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_Full_Name` varchar(255) NOT NULL,
  `user_PhoneNo` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_Email` varchar(255) NOT NULL,
  `user_Password` varchar(255) NOT NULL,
  `user_Status` varchar(255) NOT NULL,
  `user_creation_time` datetime DEFAULT current_timestamp(),
  `user_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `user_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_Full_Name`, `user_PhoneNo`, `username`, `user_Email`, `user_Password`, `user_Status`, `user_creation_time`, `user_modification_time`, `user_type_id`) VALUES
(1, 'Abdullah Al Rifat', '01671080275', 'rifat', 'abdullahalrifat95@gmail.com', '3ff4480e30247f9a1d8bad4efe7e1055', 'active', '2022-05-11 12:14:41', '2022-05-11 12:14:41', 1),
(2, 'super_admin', '01000000000', 'super_admin', 'super_admin@gmail.com', 'af4a57797a8428477fa9ebd4ea7397ba', 'active', '2022-05-11 12:14:41', '2022-05-11 12:14:41', 1),
(3, 'admin', '01000000000', 'admin', 'admin@gmail.com', 'af4a57797a8428477fa9ebd4ea7397ba', 'active', '2022-05-11 12:14:41', '2022-05-11 12:14:41', 2),
(4, 'outdoor_manager', '01000000000', 'outdoor_manager', 'outdoor_manager@gmail.com', 'af4a57797a8428477fa9ebd4ea7397ba', 'active', '2022-05-11 12:14:41', '2022-05-11 12:14:41', 3),
(5, 'indoor_manager', '01000000000', 'indoor_manager', 'indoor_manager@gmail.com', 'af4a57797a8428477fa9ebd4ea7397ba', 'active', '2022-05-11 12:14:41', '2022-05-11 12:14:41', 4),
(6, 'pathology_manager', '01000000000', 'pathology_manager', 'pathology_manager@gmail.com', 'af4a57797a8428477fa9ebd4ea7397ba', 'active', '2022-05-11 12:14:41', '2022-05-11 12:14:41', 5),
(7, 'pharmacy_manager', '01000000000', 'pharmacy_manager', 'pharmacy_manager@gmail.com', 'af4a57797a8428477fa9ebd4ea7397ba', 'active', '2022-05-11 12:14:41', '2022-05-11 12:14:41', 6),
(8, 'ot_manager', '01000000000', 'ot_manager', 'ot_manager@gmail.com', 'af4a57797a8428477fa9ebd4ea7397ba', 'active', '2022-05-11 12:14:41', '2022-05-11 12:14:41', 7);

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` int(11) NOT NULL,
  `page` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `log_time` datetime DEFAULT current_timestamp(),
  `log_action` longtext NOT NULL,
  `log_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `user_token_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_token_no` varchar(255) NOT NULL,
  `user_token_creation_time` datetime DEFAULT current_timestamp(),
  `user_token_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`user_token_id`, `user_id`, `user_token_no`, `user_token_creation_time`, `user_token_modification_time`) VALUES
(1, 2, 'f912ff7892f4812e6401ab144c5a358a810daffd', '2022-05-11 12:15:13', '2022-05-14 11:19:40');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL,
  `user_type_Name` varchar(255) NOT NULL,
  `user_type_access_level` int(11) NOT NULL,
  `user_type_creation_time` datetime DEFAULT current_timestamp(),
  `user_type_modification_time` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `user_type_Name`, `user_type_access_level`, `user_type_creation_time`, `user_type_modification_time`) VALUES
(1, 'super_admin', 1, '2022-05-11 12:14:41', '2022-05-11 12:14:41'),
(2, 'admin', 2, '2022-05-11 12:14:41', '2022-05-11 12:14:41'),
(3, 'outdoor_manager', 3, '2022-05-11 12:14:41', '2022-05-11 12:14:41'),
(4, 'indoor_manager', 4, '2022-05-11 12:14:41', '2022-05-11 12:14:41'),
(5, 'pathology_manager', 5, '2022-05-11 12:14:41', '2022-05-11 12:14:41'),
(6, 'pharmacy_manager', 6, '2022-05-11 12:14:41', '2022-05-11 12:14:41'),
(7, 'ot_manager', 7, '2022-05-11 12:14:41', '2022-05-11 12:14:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctor_id`),
  ADD KEY `doctor_user_added_id` (`doctor_user_added_id`);

--
-- Indexes for table `indoor_bed`
--
ALTER TABLE `indoor_bed`
  ADD PRIMARY KEY (`indoor_bed_id`),
  ADD KEY `indoor_bed_user_added_id` (`indoor_bed_user_added_id`),
  ADD KEY `indoor_bed_category_id` (`indoor_bed_category_id`);

--
-- Indexes for table `indoor_bed_category`
--
ALTER TABLE `indoor_bed_category`
  ADD PRIMARY KEY (`indoor_bed_category_id`),
  ADD KEY `indoor_bed_category_user_added_id` (`indoor_bed_category_user_added_id`);

--
-- Indexes for table `indoor_treatment`
--
ALTER TABLE `indoor_treatment`
  ADD PRIMARY KEY (`indoor_treatment_id`),
  ADD KEY `indoor_treatment_user_added_id` (`indoor_treatment_user_added_id`),
  ADD KEY `indoor_treatment_patient_id` (`indoor_treatment_patient_id`);

--
-- Indexes for table `indoor_treatment_bed`
--
ALTER TABLE `indoor_treatment_bed`
  ADD PRIMARY KEY (`indoor_treatment_bed_id`),
  ADD KEY `indoor_treatment_bed_user_added_id` (`indoor_treatment_bed_user_added_id`),
  ADD KEY `indoor_treatment_bed_treatment_id` (`indoor_treatment_bed_treatment_id`),
  ADD KEY `indoor_treatment_bed_bed_id` (`indoor_treatment_bed_bed_id`);

--
-- Indexes for table `indoor_treatment_doctor`
--
ALTER TABLE `indoor_treatment_doctor`
  ADD PRIMARY KEY (`indoor_treatment_doctor_id`),
  ADD KEY `indoor_treatment_doctor_user_added_id` (`indoor_treatment_doctor_user_added_id`),
  ADD KEY `indoor_treatment_doctor_treatment_id` (`indoor_treatment_doctor_treatment_id`),
  ADD KEY `indoor_treatment_doctor_doctor_id` (`indoor_treatment_doctor_doctor_id`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`medicine_id`),
  ADD KEY `medicine_user_added_id` (`medicine_user_added_id`),
  ADD KEY `medicine_unit` (`medicine_unit`),
  ADD KEY `medicine_leaf` (`medicine_leaf`),
  ADD KEY `medicine_manufacturer` (`medicine_manufacturer`);

--
-- Indexes for table `medicine_category`
--
ALTER TABLE `medicine_category`
  ADD PRIMARY KEY (`medicine_category_id`),
  ADD KEY `medicine_category_user_added_id` (`medicine_category_user_added_id`);

--
-- Indexes for table `medicine_leaf`
--
ALTER TABLE `medicine_leaf`
  ADD PRIMARY KEY (`medicine_leaf_id`),
  ADD KEY `medicine_leaf_user_added_id` (`medicine_leaf_user_added_id`);

--
-- Indexes for table `medicine_manufacturer`
--
ALTER TABLE `medicine_manufacturer`
  ADD PRIMARY KEY (`medicine_manufacturer_id`),
  ADD KEY `medicine_manufacturer_user_added_id` (`medicine_manufacturer_user_added_id`);

--
-- Indexes for table `medicine_type`
--
ALTER TABLE `medicine_type`
  ADD PRIMARY KEY (`medicine_type_id`),
  ADD KEY `medicine_type_user_added_id` (`medicine_type_user_added_id`);

--
-- Indexes for table `medicine_unit`
--
ALTER TABLE `medicine_unit`
  ADD PRIMARY KEY (`medicine_unit_id`),
  ADD KEY `medicine_unit_user_added_id` (`medicine_unit_user_added_id`);

--
-- Indexes for table `ot_treatment`
--
ALTER TABLE `ot_treatment`
  ADD PRIMARY KEY (`ot_treatment_id`),
  ADD KEY `ot_treatment_user_added_id` (`ot_treatment_user_added_id`),
  ADD KEY `ot_treatment_patient_id` (`ot_treatment_patient_id`),
  ADD KEY `ot_treatment_indoor_treatment_id` (`ot_treatment_indoor_treatment_id`);

--
-- Indexes for table `ot_treatment_doctor`
--
ALTER TABLE `ot_treatment_doctor`
  ADD PRIMARY KEY (`ot_treatment_doctor_id`),
  ADD KEY `ot_treatment_doctor_user_added_id` (`ot_treatment_doctor_user_added_id`),
  ADD KEY `ot_treatment_doctor_treatment_id` (`ot_treatment_doctor_treatment_id`),
  ADD KEY `ot_treatment_doctor_doctor_id` (`ot_treatment_doctor_doctor_id`);

--
-- Indexes for table `ot_treatment_guest_doctor`
--
ALTER TABLE `ot_treatment_guest_doctor`
  ADD PRIMARY KEY (`ot_treatment_guest_doctor_id`),
  ADD KEY `ot_treatment_guest_doctor_user_added_id` (`ot_treatment_guest_doctor_user_added_id`),
  ADD KEY `ot_treatment_guest_doctor_treatment_id` (`ot_treatment_guest_doctor_treatment_id`);

--
-- Indexes for table `ot_treatment_item`
--
ALTER TABLE `ot_treatment_item`
  ADD PRIMARY KEY (`ot_treatment_item_id`),
  ADD KEY `ot_treatment_item_user_added_id` (`ot_treatment_item_user_added_id`),
  ADD KEY `ot_treatment_item_treatment_id` (`ot_treatment_item_treatment_id`);

--
-- Indexes for table `ot_treatment_pharmacy_item`
--
ALTER TABLE `ot_treatment_pharmacy_item`
  ADD PRIMARY KEY (`ot_treatment_pharmacy_item_id`),
  ADD KEY `ot_treatment_pharmacy_item_user_added_id` (`ot_treatment_pharmacy_item_user_added_id`),
  ADD KEY `ot_treatment_pharmacy_item_treatment_id` (`ot_treatment_pharmacy_item_treatment_id`),
  ADD KEY `ot_treatment_pharmacy_item_medicine_id` (`ot_treatment_pharmacy_item_medicine_id`);

--
-- Indexes for table `outdoor_service`
--
ALTER TABLE `outdoor_service`
  ADD PRIMARY KEY (`outdoor_service_id`),
  ADD KEY `outdoor_service_user_added_id` (`outdoor_service_user_added_id`);

--
-- Indexes for table `outdoor_treatment`
--
ALTER TABLE `outdoor_treatment`
  ADD PRIMARY KEY (`outdoor_treatment_id`),
  ADD KEY `outdoor_treatment_user_added_id` (`outdoor_treatment_user_added_id`),
  ADD KEY `outdoor_treatment_patient_id` (`outdoor_treatment_patient_id`),
  ADD KEY `outdoor_treatment_indoor_treatment_id` (`outdoor_treatment_indoor_treatment_id`);

--
-- Indexes for table `outdoor_treatment_service`
--
ALTER TABLE `outdoor_treatment_service`
  ADD PRIMARY KEY (`outdoor_treatment_service_id`),
  ADD KEY `outdoor_treatment_service_user_added_id` (`outdoor_treatment_service_user_added_id`),
  ADD KEY `outdoor_treatment_service_treatment_id` (`outdoor_treatment_service_treatment_id`),
  ADD KEY `outdoor_treatment_service_service_id` (`outdoor_treatment_service_service_id`);

--
-- Indexes for table `pathology_investigation`
--
ALTER TABLE `pathology_investigation`
  ADD PRIMARY KEY (`pathology_investigation_id`),
  ADD KEY `pathology_investigation_user_added_id` (`pathology_investigation_user_added_id`),
  ADD KEY `pathology_investigation_patient_id` (`pathology_investigation_patient_id`),
  ADD KEY `pathology_investigation_indoor_treatment_id` (`pathology_investigation_indoor_treatment_id`);

--
-- Indexes for table `pathology_investigation_test`
--
ALTER TABLE `pathology_investigation_test`
  ADD PRIMARY KEY (`pathology_investigation_test_id`),
  ADD KEY `pathology_investigation_test_user_added_id` (`pathology_investigation_test_user_added_id`),
  ADD KEY `pathology_investigation_test_investigation_id` (`pathology_investigation_test_investigation_id`),
  ADD KEY `pathology_investigation_test_pathology_test_id` (`pathology_investigation_test_pathology_test_id`);

--
-- Indexes for table `pathology_test`
--
ALTER TABLE `pathology_test`
  ADD PRIMARY KEY (`pathology_test_id`),
  ADD KEY `pathology_test_user_added_id` (`pathology_test_user_added_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `patient_user_added_id` (`patient_user_added_id`);

--
-- Indexes for table `pharmacy_medicine`
--
ALTER TABLE `pharmacy_medicine`
  ADD PRIMARY KEY (`pharmacy_medicine_id`),
  ADD KEY `pharmacy_medicine_user_added_id` (`pharmacy_medicine_user_added_id`),
  ADD KEY `pharmacy_medicine_medicine_id` (`pharmacy_medicine_medicine_id`);

--
-- Indexes for table `pharmacy_purchase`
--
ALTER TABLE `pharmacy_purchase`
  ADD PRIMARY KEY (`pharmacy_purchase_id`),
  ADD KEY `pharmacy_purchase_user_added_id` (`pharmacy_purchase_user_added_id`),
  ADD KEY `pharmacy_purchase_manufacturer_id` (`pharmacy_purchase_manufacturer_id`);

--
-- Indexes for table `pharmacy_purchase_medicine`
--
ALTER TABLE `pharmacy_purchase_medicine`
  ADD PRIMARY KEY (`pharmacy_purchase_medicine_id`),
  ADD KEY `pharmacy_purchase_medicine_user_added_id` (`pharmacy_purchase_medicine_user_added_id`),
  ADD KEY `pharmacy_purchase_medicine_medicine_id` (`pharmacy_purchase_medicine_medicine_id`),
  ADD KEY `pharmacy_purchase_medicine_purchase_id` (`pharmacy_purchase_medicine_purchase_id`);

--
-- Indexes for table `pharmacy_sell`
--
ALTER TABLE `pharmacy_sell`
  ADD PRIMARY KEY (`pharmacy_sell_id`),
  ADD KEY `pharmacy_sell_user_added_id` (`pharmacy_sell_user_added_id`),
  ADD KEY `pharmacy_sell_patient_id` (`pharmacy_sell_patient_id`),
  ADD KEY `pharmacy_sell_indoor_treatment_id` (`pharmacy_sell_indoor_treatment_id`);

--
-- Indexes for table `pharmacy_sell_medicine`
--
ALTER TABLE `pharmacy_sell_medicine`
  ADD PRIMARY KEY (`pharmacy_sell_medicine_id`),
  ADD KEY `pharmacy_sell_medicine_user_added_id` (`pharmacy_sell_medicine_user_added_id`),
  ADD KEY `pharmacy_sell_medicine_medicine_id` (`pharmacy_sell_medicine_medicine_id`),
  ADD KEY `pharmacy_sell_medicine_sell_id` (`pharmacy_sell_medicine_sell_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_type_id` (`user_type_id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`user_token_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `indoor_bed`
--
ALTER TABLE `indoor_bed`
  MODIFY `indoor_bed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `indoor_bed_category`
--
ALTER TABLE `indoor_bed_category`
  MODIFY `indoor_bed_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `indoor_treatment`
--
ALTER TABLE `indoor_treatment`
  MODIFY `indoor_treatment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `indoor_treatment_bed`
--
ALTER TABLE `indoor_treatment_bed`
  MODIFY `indoor_treatment_bed_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `indoor_treatment_doctor`
--
ALTER TABLE `indoor_treatment_doctor`
  MODIFY `indoor_treatment_doctor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `medicine_category`
--
ALTER TABLE `medicine_category`
  MODIFY `medicine_category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_leaf`
--
ALTER TABLE `medicine_leaf`
  MODIFY `medicine_leaf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `medicine_manufacturer`
--
ALTER TABLE `medicine_manufacturer`
  MODIFY `medicine_manufacturer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `medicine_type`
--
ALTER TABLE `medicine_type`
  MODIFY `medicine_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_unit`
--
ALTER TABLE `medicine_unit`
  MODIFY `medicine_unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ot_treatment`
--
ALTER TABLE `ot_treatment`
  MODIFY `ot_treatment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ot_treatment_doctor`
--
ALTER TABLE `ot_treatment_doctor`
  MODIFY `ot_treatment_doctor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ot_treatment_guest_doctor`
--
ALTER TABLE `ot_treatment_guest_doctor`
  MODIFY `ot_treatment_guest_doctor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ot_treatment_item`
--
ALTER TABLE `ot_treatment_item`
  MODIFY `ot_treatment_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ot_treatment_pharmacy_item`
--
ALTER TABLE `ot_treatment_pharmacy_item`
  MODIFY `ot_treatment_pharmacy_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `outdoor_service`
--
ALTER TABLE `outdoor_service`
  MODIFY `outdoor_service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `outdoor_treatment`
--
ALTER TABLE `outdoor_treatment`
  MODIFY `outdoor_treatment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `outdoor_treatment_service`
--
ALTER TABLE `outdoor_treatment_service`
  MODIFY `outdoor_treatment_service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pathology_investigation`
--
ALTER TABLE `pathology_investigation`
  MODIFY `pathology_investigation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pathology_investigation_test`
--
ALTER TABLE `pathology_investigation_test`
  MODIFY `pathology_investigation_test_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pathology_test`
--
ALTER TABLE `pathology_test`
  MODIFY `pathology_test_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1008;

--
-- AUTO_INCREMENT for table `pharmacy_medicine`
--
ALTER TABLE `pharmacy_medicine`
  MODIFY `pharmacy_medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pharmacy_purchase`
--
ALTER TABLE `pharmacy_purchase`
  MODIFY `pharmacy_purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pharmacy_purchase_medicine`
--
ALTER TABLE `pharmacy_purchase_medicine`
  MODIFY `pharmacy_purchase_medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `pharmacy_sell`
--
ALTER TABLE `pharmacy_sell`
  MODIFY `pharmacy_sell_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pharmacy_sell_medicine`
--
ALTER TABLE `pharmacy_sell_medicine`
  MODIFY `pharmacy_sell_medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `user_token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`doctor_user_added_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `indoor_bed`
--
ALTER TABLE `indoor_bed`
  ADD CONSTRAINT `indoor_bed_ibfk_1` FOREIGN KEY (`indoor_bed_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `indoor_bed_ibfk_2` FOREIGN KEY (`indoor_bed_category_id`) REFERENCES `indoor_bed_category` (`indoor_bed_category_id`);

--
-- Constraints for table `indoor_bed_category`
--
ALTER TABLE `indoor_bed_category`
  ADD CONSTRAINT `indoor_bed_category_ibfk_1` FOREIGN KEY (`indoor_bed_category_user_added_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `indoor_treatment`
--
ALTER TABLE `indoor_treatment`
  ADD CONSTRAINT `indoor_treatment_ibfk_1` FOREIGN KEY (`indoor_treatment_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `indoor_treatment_ibfk_2` FOREIGN KEY (`indoor_treatment_patient_id`) REFERENCES `patient` (`patient_id`);

--
-- Constraints for table `indoor_treatment_bed`
--
ALTER TABLE `indoor_treatment_bed`
  ADD CONSTRAINT `indoor_treatment_bed_ibfk_1` FOREIGN KEY (`indoor_treatment_bed_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `indoor_treatment_bed_ibfk_2` FOREIGN KEY (`indoor_treatment_bed_treatment_id`) REFERENCES `indoor_treatment` (`indoor_treatment_id`),
  ADD CONSTRAINT `indoor_treatment_bed_ibfk_3` FOREIGN KEY (`indoor_treatment_bed_bed_id`) REFERENCES `indoor_bed` (`indoor_bed_id`);

--
-- Constraints for table `indoor_treatment_doctor`
--
ALTER TABLE `indoor_treatment_doctor`
  ADD CONSTRAINT `indoor_treatment_doctor_ibfk_1` FOREIGN KEY (`indoor_treatment_doctor_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `indoor_treatment_doctor_ibfk_2` FOREIGN KEY (`indoor_treatment_doctor_treatment_id`) REFERENCES `indoor_treatment` (`indoor_treatment_id`),
  ADD CONSTRAINT `indoor_treatment_doctor_ibfk_3` FOREIGN KEY (`indoor_treatment_doctor_doctor_id`) REFERENCES `doctor` (`doctor_id`);

--
-- Constraints for table `medicine`
--
ALTER TABLE `medicine`
  ADD CONSTRAINT `medicine_ibfk_1` FOREIGN KEY (`medicine_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `medicine_ibfk_2` FOREIGN KEY (`medicine_unit`) REFERENCES `medicine_unit` (`medicine_unit_id`),
  ADD CONSTRAINT `medicine_ibfk_3` FOREIGN KEY (`medicine_leaf`) REFERENCES `medicine_leaf` (`medicine_leaf_id`),
  ADD CONSTRAINT `medicine_ibfk_4` FOREIGN KEY (`medicine_manufacturer`) REFERENCES `medicine_manufacturer` (`medicine_manufacturer_id`);

--
-- Constraints for table `medicine_category`
--
ALTER TABLE `medicine_category`
  ADD CONSTRAINT `medicine_category_ibfk_1` FOREIGN KEY (`medicine_category_user_added_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `medicine_leaf`
--
ALTER TABLE `medicine_leaf`
  ADD CONSTRAINT `medicine_leaf_ibfk_1` FOREIGN KEY (`medicine_leaf_user_added_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `medicine_manufacturer`
--
ALTER TABLE `medicine_manufacturer`
  ADD CONSTRAINT `medicine_manufacturer_ibfk_1` FOREIGN KEY (`medicine_manufacturer_user_added_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `medicine_type`
--
ALTER TABLE `medicine_type`
  ADD CONSTRAINT `medicine_type_ibfk_1` FOREIGN KEY (`medicine_type_user_added_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `medicine_unit`
--
ALTER TABLE `medicine_unit`
  ADD CONSTRAINT `medicine_unit_ibfk_1` FOREIGN KEY (`medicine_unit_user_added_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `ot_treatment`
--
ALTER TABLE `ot_treatment`
  ADD CONSTRAINT `ot_treatment_ibfk_1` FOREIGN KEY (`ot_treatment_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `ot_treatment_ibfk_2` FOREIGN KEY (`ot_treatment_patient_id`) REFERENCES `patient` (`patient_id`),
  ADD CONSTRAINT `ot_treatment_ibfk_3` FOREIGN KEY (`ot_treatment_indoor_treatment_id`) REFERENCES `indoor_treatment` (`indoor_treatment_id`);

--
-- Constraints for table `ot_treatment_doctor`
--
ALTER TABLE `ot_treatment_doctor`
  ADD CONSTRAINT `ot_treatment_doctor_ibfk_1` FOREIGN KEY (`ot_treatment_doctor_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `ot_treatment_doctor_ibfk_2` FOREIGN KEY (`ot_treatment_doctor_treatment_id`) REFERENCES `ot_treatment` (`ot_treatment_id`),
  ADD CONSTRAINT `ot_treatment_doctor_ibfk_3` FOREIGN KEY (`ot_treatment_doctor_doctor_id`) REFERENCES `doctor` (`doctor_id`);

--
-- Constraints for table `ot_treatment_guest_doctor`
--
ALTER TABLE `ot_treatment_guest_doctor`
  ADD CONSTRAINT `ot_treatment_guest_doctor_ibfk_1` FOREIGN KEY (`ot_treatment_guest_doctor_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `ot_treatment_guest_doctor_ibfk_2` FOREIGN KEY (`ot_treatment_guest_doctor_treatment_id`) REFERENCES `ot_treatment` (`ot_treatment_id`);

--
-- Constraints for table `ot_treatment_item`
--
ALTER TABLE `ot_treatment_item`
  ADD CONSTRAINT `ot_treatment_item_ibfk_1` FOREIGN KEY (`ot_treatment_item_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `ot_treatment_item_ibfk_2` FOREIGN KEY (`ot_treatment_item_treatment_id`) REFERENCES `ot_treatment` (`ot_treatment_id`);

--
-- Constraints for table `ot_treatment_pharmacy_item`
--
ALTER TABLE `ot_treatment_pharmacy_item`
  ADD CONSTRAINT `ot_treatment_pharmacy_item_ibfk_1` FOREIGN KEY (`ot_treatment_pharmacy_item_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `ot_treatment_pharmacy_item_ibfk_2` FOREIGN KEY (`ot_treatment_pharmacy_item_treatment_id`) REFERENCES `ot_treatment` (`ot_treatment_id`),
  ADD CONSTRAINT `ot_treatment_pharmacy_item_ibfk_3` FOREIGN KEY (`ot_treatment_pharmacy_item_medicine_id`) REFERENCES `pharmacy_medicine` (`pharmacy_medicine_id`);

--
-- Constraints for table `outdoor_service`
--
ALTER TABLE `outdoor_service`
  ADD CONSTRAINT `outdoor_service_ibfk_1` FOREIGN KEY (`outdoor_service_user_added_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `outdoor_treatment`
--
ALTER TABLE `outdoor_treatment`
  ADD CONSTRAINT `outdoor_treatment_ibfk_1` FOREIGN KEY (`outdoor_treatment_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `outdoor_treatment_ibfk_2` FOREIGN KEY (`outdoor_treatment_patient_id`) REFERENCES `patient` (`patient_id`),
  ADD CONSTRAINT `outdoor_treatment_ibfk_3` FOREIGN KEY (`outdoor_treatment_indoor_treatment_id`) REFERENCES `indoor_treatment` (`indoor_treatment_id`);

--
-- Constraints for table `outdoor_treatment_service`
--
ALTER TABLE `outdoor_treatment_service`
  ADD CONSTRAINT `outdoor_treatment_service_ibfk_1` FOREIGN KEY (`outdoor_treatment_service_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `outdoor_treatment_service_ibfk_2` FOREIGN KEY (`outdoor_treatment_service_treatment_id`) REFERENCES `outdoor_treatment` (`outdoor_treatment_id`),
  ADD CONSTRAINT `outdoor_treatment_service_ibfk_3` FOREIGN KEY (`outdoor_treatment_service_service_id`) REFERENCES `outdoor_service` (`outdoor_service_id`);

--
-- Constraints for table `pathology_investigation`
--
ALTER TABLE `pathology_investigation`
  ADD CONSTRAINT `pathology_investigation_ibfk_1` FOREIGN KEY (`pathology_investigation_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `pathology_investigation_ibfk_2` FOREIGN KEY (`pathology_investigation_patient_id`) REFERENCES `patient` (`patient_id`),
  ADD CONSTRAINT `pathology_investigation_ibfk_3` FOREIGN KEY (`pathology_investigation_indoor_treatment_id`) REFERENCES `indoor_treatment` (`indoor_treatment_id`);

--
-- Constraints for table `pathology_investigation_test`
--
ALTER TABLE `pathology_investigation_test`
  ADD CONSTRAINT `pathology_investigation_test_ibfk_1` FOREIGN KEY (`pathology_investigation_test_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `pathology_investigation_test_ibfk_2` FOREIGN KEY (`pathology_investigation_test_investigation_id`) REFERENCES `pathology_investigation` (`pathology_investigation_id`),
  ADD CONSTRAINT `pathology_investigation_test_ibfk_3` FOREIGN KEY (`pathology_investigation_test_pathology_test_id`) REFERENCES `pathology_test` (`pathology_test_id`);

--
-- Constraints for table `pathology_test`
--
ALTER TABLE `pathology_test`
  ADD CONSTRAINT `pathology_test_ibfk_1` FOREIGN KEY (`pathology_test_user_added_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`patient_user_added_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `pharmacy_medicine`
--
ALTER TABLE `pharmacy_medicine`
  ADD CONSTRAINT `pharmacy_medicine_ibfk_1` FOREIGN KEY (`pharmacy_medicine_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `pharmacy_medicine_ibfk_2` FOREIGN KEY (`pharmacy_medicine_medicine_id`) REFERENCES `medicine` (`medicine_id`);

--
-- Constraints for table `pharmacy_purchase`
--
ALTER TABLE `pharmacy_purchase`
  ADD CONSTRAINT `pharmacy_purchase_ibfk_1` FOREIGN KEY (`pharmacy_purchase_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `pharmacy_purchase_ibfk_2` FOREIGN KEY (`pharmacy_purchase_manufacturer_id`) REFERENCES `medicine_manufacturer` (`medicine_manufacturer_id`);

--
-- Constraints for table `pharmacy_purchase_medicine`
--
ALTER TABLE `pharmacy_purchase_medicine`
  ADD CONSTRAINT `pharmacy_purchase_medicine_ibfk_1` FOREIGN KEY (`pharmacy_purchase_medicine_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `pharmacy_purchase_medicine_ibfk_2` FOREIGN KEY (`pharmacy_purchase_medicine_medicine_id`) REFERENCES `pharmacy_medicine` (`pharmacy_medicine_id`),
  ADD CONSTRAINT `pharmacy_purchase_medicine_ibfk_3` FOREIGN KEY (`pharmacy_purchase_medicine_purchase_id`) REFERENCES `pharmacy_purchase` (`pharmacy_purchase_id`);

--
-- Constraints for table `pharmacy_sell`
--
ALTER TABLE `pharmacy_sell`
  ADD CONSTRAINT `pharmacy_sell_ibfk_1` FOREIGN KEY (`pharmacy_sell_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `pharmacy_sell_ibfk_2` FOREIGN KEY (`pharmacy_sell_patient_id`) REFERENCES `patient` (`patient_id`),
  ADD CONSTRAINT `pharmacy_sell_ibfk_3` FOREIGN KEY (`pharmacy_sell_indoor_treatment_id`) REFERENCES `indoor_treatment` (`indoor_treatment_id`);

--
-- Constraints for table `pharmacy_sell_medicine`
--
ALTER TABLE `pharmacy_sell_medicine`
  ADD CONSTRAINT `pharmacy_sell_medicine_ibfk_1` FOREIGN KEY (`pharmacy_sell_medicine_user_added_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `pharmacy_sell_medicine_ibfk_2` FOREIGN KEY (`pharmacy_sell_medicine_medicine_id`) REFERENCES `pharmacy_medicine` (`pharmacy_medicine_id`),
  ADD CONSTRAINT `pharmacy_sell_medicine_ibfk_3` FOREIGN KEY (`pharmacy_sell_medicine_sell_id`) REFERENCES `pharmacy_sell` (`pharmacy_sell_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`user_type_id`);

--
-- Constraints for table `user_token`
--
ALTER TABLE `user_token`
  ADD CONSTRAINT `user_token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
