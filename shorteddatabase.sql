-- SET GLOBAL time_zone = "Asia/Dhaka";
SET time_zone = "+06:00";
-- system user type like super_admin,admin,manager,user
-- max access level 4
-- super_admin level 4
-- admin level 3
-- user level 1
CREATE TABLE `user_type`
(
    `user_type_id`                int(11)      NOT NULL AUTO_INCREMENT,
    `user_type_Name`              varchar(255) NOT NULL,
    `user_type_access_level`      int(11)      NOT NULL,
    `user_type_creation_time`     DATETIME DEFAULT CURRENT_TIMESTAMP,
    `user_type_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (user_type_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO `user_type` (`user_type_id`, `user_type_Name`, `user_type_access_level`, `user_type_creation_time`, `user_type_modification_time`) VALUES
(1, 'super_admin', 1, '2022-05-11 12:14:41', '2022-05-11 12:14:41'),
(2, 'admin', 2, '2022-05-11 12:14:41', '2022-05-11 12:14:41'),
(3, 'reception_incharge', 3, '2022-05-11 12:14:41', '2022-05-23 13:07:40'),
(4, 'reception', 4, '2022-05-11 12:14:41', '2022-05-23 13:10:29'),
(6, 'pharmacy_manager', 6, '2022-05-11 12:14:41', '2022-05-11 12:14:41');

-- user info
CREATE TABLE `user`
(
    `user_id`                int(11)      NOT NULL AUTO_INCREMENT,
    `user_Full_Name`         varchar(255) NOT NULL,
    `user_PhoneNo`           varchar(255) NOT NULL,
    `username`               varchar(255) NOT NULL,
    `user_Email`             varchar(255) NOT NULL,
    `user_Password`          varchar(255) NOT NULL,
    `user_Status`            varchar(255) NOT NULL,
    `user_creation_time`     DATETIME DEFAULT CURRENT_TIMESTAMP,
    `user_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    `user_type_id`           int(11)      NOT NULL,
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_type_id) REFERENCES user_type (user_type_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO `user` (`user_id`, `user_Full_Name`, `user_PhoneNo`, `username`, `user_Email`, `user_Password`, `user_Status`, `user_creation_time`, `user_modification_time`, `user_type_id`) VALUES
(1, 'Abdullah Al Rifat', '01671080275', 'rifat', 'abdullahalrifat95@gmail.com', '3ff4480e30247f9a1d8bad4efe7e1055', 'active', '2022-05-11 12:14:41', '2022-05-11 12:14:41', 1),
(2, 'admin', '01000000000', 'admin', 'admin@gmail.com', '25805144c083ad8d5e5974a6668cbfd4', 'active', '2022-05-11 12:14:41', '2022-05-22 22:21:05', 1),
(3, 'admin', '01000000000', 'normal_admin', 'normal_admin@gmail.com', 'af4a57797a8428477fa9ebd4ea7397ba', 'active', '2022-05-11 12:14:41', '2022-05-22 19:44:23', 2),
(5, 'manager', '01000000000', 'indoor_manager', 'manager@gmail.com', 'af4a57797a8428477fa9ebd4ea7397ba', 'active', '2022-05-11 12:14:41', '2022-05-22 19:22:52', 1),
(7, 'pharmacy_manager', '01000000000', 'pharmacy_manager', 'pharmacy_manager@gmail.com', 'af4a57797a8428477fa9ebd4ea7397ba', 'active', '2022-05-11 12:14:41', '2022-05-11 12:14:41', 6),
(9, 'Salam', '011115151', 'Salam', 'salam@mtcclinic.com', 'f7e85f9db96883fa4a6421634f1b3c86', '', NULL, '2022-05-24 16:33:21', 3),
(10, 'CEO', '016111111111', 'CEO', 'ceo@mtcclinic.org', '6fdcccf4592c5aab563a25bb1c2c56a0', 'active', NULL, NULL, 1),
(11, 'khairul', '0168888888', 'khairul', 'khairul@mtcclinic.org', '7a6ba1e8a319ebafdbce2b02d5fa0e89', 'active', NULL, '2022-05-24 16:33:29', 4);

-- select user_Name,user_PhoneNo,user_Email,user_Password,user_type_Name,user_type_access_level from user NATURAL JOIN user_type

-- user token
CREATE TABLE `user_token`
(
    `user_token_id`                int(11)      NOT NULL AUTO_INCREMENT,
    `user_id`                      int(11)      NOT NULL,
    `user_token_no`                varchar(255) NOT NULL,
    `user_token_creation_time`     DATETIME DEFAULT CURRENT_TIMESTAMP,
    `user_token_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (user_token_id),
    FOREIGN KEY (user_id) REFERENCES user (user_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `user_log`
(
    id         int(11) PRIMARY KEY AUTO_INCREMENT,
    page       varchar(255) NOT NULL,
    username   varchar(255) NOT NULL,
    log_time   datetime DEFAULT CURRENT_TIMESTAMP,
    log_action longtext     NOT NULL,
    log_name   varchar(255) NOT NULL,
    user_id    int(11)      NOT NULL,
    ip         int(11)      NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- application models

CREATE TABLE `patient`
(
    `patient_id`                int(11)      NOT NULL AUTO_INCREMENT,
    `patient_user_added_id`     int(11)      NOT NULL,
    `patient_name`              varchar(255) NOT NULL,
    `patient_description`       varchar(255) DEFAULT NULL,
    `patient_age`               varchar(255) DEFAULT NULL,
    `patient_email`             varchar(255) DEFAULT NULL,
    `patient_dob`               varchar(255) DEFAULT NULL,
    `patient_gender`            varchar(255) DEFAULT NULL,
    `patient_blood_group`       varchar(255) DEFAULT NULL,
    `patient_phone`             varchar(255) DEFAULT NULL,
    `patient_address`           varchar(255) DEFAULT NULL,
    `patient_status`            varchar(255) DEFAULT NULL, --
    `patient_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `patient_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (patient_id),
    FOREIGN KEY (patient_user_added_id) REFERENCES user (user_id)
    -- UNIQUE (patient_phone)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;



CREATE TABLE `doctor`
(
    `doctor_id`                int(11)      NOT NULL AUTO_INCREMENT,
    `doctor_user_added_id`     int(11)      NOT NULL,
    `doctor_name`              varchar(255) NOT NULL,
    `doctor_description`       varchar(255) DEFAULT NULL,
    `doctor_specialization`    varchar(255) DEFAULT NULL,
    `doctor_experience`        varchar(255) DEFAULT NULL,
    `doctor_age`               varchar(255) DEFAULT NULL,
    `doctor_email`             varchar(255) DEFAULT NULL,
    `doctor_dob`               varchar(255) DEFAULT NULL,
    `doctor_gender`            varchar(255) DEFAULT NULL,
    `doctor_blood_group`       varchar(255) DEFAULT NULL,
    `doctor_visit_fee`         varchar(255) DEFAULT NULL,
    `doctor_phone`             varchar(255) DEFAULT NULL,
    `doctor_emergency_phone`   varchar(255) DEFAULT NULL,
    `doctor_address`           varchar(255) DEFAULT NULL,
    `doctor_status`            varchar(255) DEFAULT NULL,
    `photo_url`                varchar(255) DEFAULT NULL,
    `document_url`             varchar(255) DEFAULT NULL,
    `doctor_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `doctor_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (doctor_id),
    FOREIGN KEY (doctor_user_added_id) REFERENCES user (user_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;



INSERT INTO `doctor` (`doctor_id`, `doctor_user_added_id`, `doctor_name`, `doctor_description`, `doctor_specialization`, `doctor_experience`, `doctor_age`, `doctor_email`, `doctor_dob`, `doctor_gender`, `doctor_blood_group`, `doctor_visit_fee`, `doctor_phone`, `doctor_emergency_phone`, `doctor_address`, `doctor_status`, `photo_url`, `document_url`, `doctor_creation_time`, `doctor_modification_time`) VALUES
(5, 2, 'Assoc.Prof.Dr.Johurul Hoque', '', 'Head Of Dept.Of Orthopedic', 'Surgeon', '45', '', '', 'male', '', '600', '01819061993', '', '56,Block-A(2nd Floor),Road-03,Dhaka Real State,Katasur,Mohammadpur,Dhaka-1207', 'active', '', '', '2022-05-21 16:04:27', NULL),
(6, 2, 'Dr.Muhammad Saker', '', 'General Physician', 'MBBS', '29', '', '', 'male', '', '300', '01704597065', '', 'Momtaj Trauma Center', 'active', '', '', '2022-05-21 16:08:15', NULL),
(7, 2, 'Dr.Kazi Sazzad Hossain', '', 'General Physician', 'MBBS', '30', '', '', 'male', 'B+', '300', '01533839825', '', 'Momtaj trauma Center', 'active', '', '', '2022-05-21 16:10:07', NULL),
(8, 2, 'Dr.Marufur Rahman Talha', '', 'General Physician', 'MBBS', '29', '', '', 'male', '', '300', '01930997796', '', 'Momtaj Trauma Center', 'active', '', '', '2022-05-21 16:11:20', NULL),
(9, 2, 'Towhidul Islam', '', 'Pain,Arthritis,Sports injuries CP& Rehab Mnage', 'BSC PT(Faculty Of Medicine -DU)', '28', '', '', '', '', '400', '01736462005', '', '', 'active', '', '', '2022-05-22 16:41:17', NULL),
(10, 2, 'Mst.Kajal REkha', '', 'DPT(S.M.F) Dhaka', '', '25', '', '', 'female', '', '400', '01844080674', '', '', 'active', '', '', '2022-05-22 16:44:35', NULL),
(11, 2, 'Mst.Kajal Rekha', '', 'Pain,Arthritis,Sports injuries CP& Rehab Mnage', 'DPT(S.M.F) Dhaka', '25', '', '', '', '', '400', '01844080671', '', '', 'active', '', '', '2022-05-22 16:46:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `indoor_bed`
--


-- indoor module

CREATE TABLE `indoor_bed_category`
(
    `indoor_bed_category_id`                int(11)      NOT NULL AUTO_INCREMENT,
    `indoor_bed_category_user_added_id`     int(11)      NOT NULL,
    `indoor_bed_category_name`              varchar(255) NOT NULL,
    `indoor_bed_category_description`       varchar(255) NOT NULL,
    `indoor_bed_category_status`            varchar(255) DEFAULT NULL,
    `indoor_bed_category_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `indoor_bed_category_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (indoor_bed_category_id),
    FOREIGN KEY (indoor_bed_category_user_added_id) REFERENCES user (user_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO indoor_bed_category (indoor_bed_category_id,
                                 indoor_bed_category_user_added_id,
                                 indoor_bed_category_name,
                                 indoor_bed_category_description,
                                 indoor_bed_category_status,
                                 indoor_bed_category_creation_time,
                                 indoor_bed_category_modification_time)
VALUES (1, 1, 'Ward-Male', 'General Male Ward', 'active', now(), now()),
       (2, 1, 'Ward-Female', 'General Female Ward', 'active', now(), now()),
       (3, 1, 'Cabin-AC', 'AC Cabin', 'active', now(), now()),
       (4, 1, 'Cabin-Non AC', 'Non AC Cabin', 'active', now(), now())
;
CREATE TABLE `indoor_bed`
(
    `indoor_bed_id`                int(11)      NOT NULL AUTO_INCREMENT,
    `indoor_bed_user_added_id`     int(11)      NOT NULL,
    `indoor_bed_category_id`       int(11)      NOT NULL,
    `indoor_bed_name`              varchar(255) NOT NULL,
    `indoor_bed_room_no`           varchar(255) DEFAULT NULL,
    `indoor_bed_price`             varchar(255) DEFAULT NULL,
    `indoor_bed_status`            varchar(255) DEFAULT NULL, --
    `indoor_bed_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `indoor_bed_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (indoor_bed_id),
    FOREIGN KEY (indoor_bed_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (indoor_bed_category_id) REFERENCES indoor_bed_category (indoor_bed_category_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO indoor_bed (indoor_bed_id,
                        indoor_bed_user_added_id,
                        indoor_bed_category_id,
                        indoor_bed_name,
                        indoor_bed_room_no,
                        indoor_bed_price,
                        indoor_bed_status,
                        indoor_bed_creation_time,
                        indoor_bed_modification_time)
VALUES (1, 1, 1, '101', '1100', '1000', 'available', now(), now()),
       (2, 1, 2, '201', '2100', '1500', 'available', now(), now()),
       (3, 1, 3, '301', '3100', '2500', 'available', now(), now()),
       (4, 1, 4, '401', '4100', '2000', 'available', now(), now())
;

CREATE TABLE `indoor_treatment`
(
    `indoor_treatment_id`                        int(11) NOT NULL AUTO_INCREMENT,
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
    `indoor_treatment_creation_time`             DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `indoor_treatment_modification_time`         DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (indoor_treatment_id),
    FOREIGN KEY (indoor_treatment_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (indoor_treatment_patient_id) REFERENCES patient (patient_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `indoor_treatment_bed`
(
    `indoor_treatment_bed_id`                int(11) NOT NULL AUTO_INCREMENT,
    `indoor_treatment_bed_user_added_id` int(11) NOT NULL,
  `indoor_treatment_bed_treatment_id` int(11) NOT NULL,
  `indoor_treatment_bed_bed_id` int(11) NOT NULL,
  `indoor_treatment_bed_category_name` varchar(255) DEFAULT NULL,
  `indoor_treatment_bed_price` varchar(255) DEFAULT NULL,
  `indoor_treatment_bed_total_bill` varchar(255) DEFAULT NULL,

    `indoor_treatment_bed_entry_time`        DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `indoor_treatment_bed_discharge_time`    DATETIME     DEFAULT NULL,
    `indoor_treatment_bed_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `indoor_treatment_bed_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (indoor_treatment_bed_id),
    FOREIGN KEY (indoor_treatment_bed_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (indoor_treatment_bed_treatment_id) REFERENCES indoor_treatment (indoor_treatment_id),
    FOREIGN KEY (indoor_treatment_bed_bed_id) REFERENCES indoor_bed (indoor_bed_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `indoor_treatment_doctor`
(
    `indoor_treatment_doctor_id`                int(11) NOT NULL AUTO_INCREMENT,
    `indoor_treatment_doctor_user_added_id` int(11) NOT NULL,
  `indoor_treatment_doctor_treatment_id` int(11) NOT NULL,
  `indoor_treatment_doctor_doctor_id` int(11) NOT NULL,
  `indoor_treatment_doctor_specialization` varchar(255) DEFAULT NULL,
  `indoor_treatment_doctor_visit_fee` varchar(255) DEFAULT NULL,
  `indoor_treatment_doctor_total_bill` varchar(255) DEFAULT NULL, 

    `indoor_treatment_doctor_entry_time`        DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `indoor_treatment_doctor_discharge_time`    DATETIME     DEFAULT NULL,
    `indoor_treatment_doctor_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `indoor_treatment_doctor_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (indoor_treatment_doctor_id),
    FOREIGN KEY (indoor_treatment_doctor_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (indoor_treatment_doctor_treatment_id) REFERENCES indoor_treatment (indoor_treatment_id),
    FOREIGN KEY (indoor_treatment_doctor_doctor_id) REFERENCES doctor (doctor_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


-- outdoor 
CREATE TABLE `outdoor_service`
(
    `outdoor_service_id`                int(11)      NOT NULL AUTO_INCREMENT,
    `outdoor_service_user_added_id` int(11) NOT NULL,
  `outdoor_service_name` varchar(255) NOT NULL,
  `outdoor_service_Category` varchar(255) NOT NULL,
  `outdoor_service_room_no` varchar(255) DEFAULT NULL,
  `outdoor_service_description` varchar(255) DEFAULT NULL,
  `outdoor_service_rate` varchar(255) DEFAULT NULL,
    `outdoor_service_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `outdoor_service_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (outdoor_service_id),
    FOREIGN KEY (outdoor_service_user_added_id) REFERENCES user (user_id)
    
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


--
-- Dumping data for table `outdoor_service`
--

INSERT INTO `outdoor_service` (`outdoor_service_id`, `outdoor_service_user_added_id`, `outdoor_service_name`, `outdoor_service_Category`, `outdoor_service_room_no`, `outdoor_service_description`, `outdoor_service_rate`, `outdoor_service_creation_time`, `outdoor_service_modification_time`) VALUES
(14, 2, 'CBC', 'Investigation/Test', '401', '', '400', '2022-05-21 16:13:25', NULL),
(15, 2, 'HB%', 'Investigation/Test', '401', '', '200', '2022-05-21 16:13:56', NULL),
(16, 2, 'BT.CT', 'Investigation/Test', '401', '', '300', '2022-05-21 16:14:34', NULL),
(17, 2, 'PBF', 'Investigation/Test', '401', '', '300', '2022-05-21 16:14:59', NULL),
(18, 2, 'FBS', 'Investigation/Test', '401', '', '150', '2022-05-21 16:15:34', NULL),
(19, 2, '2HAFB', 'Investigation/Test', '401', '', '150', '2022-05-21 16:16:00', NULL),
(20, 2, 'RBS', 'Investigation/Test', '401', '', '150', '2022-05-21 16:16:22', NULL),
(21, 2, 'RBS By Strip', 'Investigation/Test', '401', '', '50', '2022-05-21 16:16:42', NULL),
(22, 2, 'OGTT', 'Investigation/Test', '401', '', '300', '2022-05-21 16:17:02', NULL),
(23, 2, 'Blood Grouping & RhFactor', 'Investigation/Test', '401', '', '100', '2022-05-21 16:17:29', NULL),
(24, 2, 'Lipid Profile', 'Investigation/Test', '401', '', '800', '2022-05-21 16:18:00', NULL),
(25, 2, 'Lipid Profile(Fasting)', 'Investigation/Test', '401', '', '800', '2022-05-21 16:18:34', NULL),
(26, 2, 'S.Creatinine', 'Investigation/Test', '401', '', '300', '2022-05-21 16:18:57', NULL),
(27, 2, 'S.Uric Acid', 'Investigation/Test', '401', '', '350', '2022-05-21 16:19:38', NULL),
(28, 2, 'S.Albumin', 'Investigation/Test', '401', '', '300', '2022-05-21 16:22:56', NULL),
(29, 2, 'Total Billirubin', 'Investigation/Test', '401', '', '350', '2022-05-21 16:23:49', NULL),
(30, 2, 'S.Calcium', 'Investigation/Test', '401', '', '400', '2022-05-21 16:24:33', NULL),
(31, 2, 'S.Urea', 'Investigation/Test', '401', '', '400', '2022-05-21 16:25:06', NULL),
(32, 2, 'S.Glubulin', 'Investigation/Test', '401', '', '600', '2022-05-21 16:25:47', NULL),
(33, 2, 'SGPT', 'Investigation/Test', '401', '', '350', '2022-05-21 16:26:10', NULL),
(34, 2, 'ALT', 'Investigation/Test', '401', '', '350', '2022-05-21 16:26:40', NULL),
(35, 2, 'SGOT', 'Investigation/Test', '401', '', '350', '2022-05-21 16:27:32', NULL),
(36, 2, 'Alkaline Phosphate(ALP)', 'Investigation/Test', '401', '', '350', '2022-05-21 16:28:47', NULL),
(37, 2, 'Triglycerides', 'Investigation/Test', '401', '', '300', '2022-05-21 16:29:39', NULL),
(38, 2, 'TG', 'Investigation/Test', '401', '', '300', '2022-05-21 16:30:07', NULL),
(39, 2, 'Total Cholesterol', 'Investigation/Test', '401', '', '300', '2022-05-21 16:31:25', NULL),
(40, 2, 'S.Inorganic Phosphate', 'Investigation/Test', '401', '', '500', '2022-05-21 16:32:10', NULL),
(41, 2, 'S.Magnesium', 'Investigation/Test', '401', '', '900', '2022-05-21 16:33:03', NULL),
(42, 2, 'HbA1C', 'Investigation/Test', '401', '', '1000', '2022-05-21 16:34:11', NULL),
(43, 2, 'CRP', 'Investigation/Test', '401', '', '800', '2022-05-21 16:34:33', NULL),
(44, 2, 'RA Test', 'Investigation/Test', '401', '', '700', '2022-05-21 16:35:03', NULL),
(45, 2, 'HbsAg(ICT)', 'Investigation/Test', '401', '', '300', '2022-05-21 16:36:56', NULL),
(46, 2, 'HbsAg(ELISA)', 'Investigation/Test', '401', '', '600', '2022-05-21 16:37:53', NULL),
(47, 2, 'Anti HCV(ICT)', 'Investigation/Test', '401', '', '400', '2022-05-21 16:38:34', NULL),
(48, 2, 'Anti HCV(ELISA)', 'Investigation/Test', '401', '', '600', '2022-05-21 16:39:06', NULL),
(49, 2, 'Anti-H-Pylori', 'Investigation/Test', '401', '', '1000', '2022-05-21 16:47:04', NULL),
(50, 2, 'HIV', 'Investigation/Test', '401', '', '800', '2022-05-21 16:47:35', NULL),
(51, 2, 'HBeAg', 'Investigation/Test', '401', '', '800', '2022-05-21 16:48:27', NULL),
(52, 2, 'Anti HBs', 'Investigation/Test', '401', '', '1000', '2022-05-21 16:48:58', NULL),
(53, 2, 'Anti Hbe', 'Investigation/Test', '401', '', '1000', '2022-05-21 16:49:27', NULL),
(54, 2, 'Anti-HBc(Total)', 'Investigation/Test', '401', '', '1000', '2022-05-21 16:50:11', NULL),
(55, 2, 'Anti-CCP', 'Investigation/Test', '401', '', '1500', '2022-05-21 16:50:58', NULL),
(56, 2, 'Prothombin Time(PT)', 'Investigation/Test', '401', '', '700', '2022-05-21 16:51:42', NULL),
(57, 2, 'TSH', 'Investigation/Test', '401', '', '700', '2022-05-21 16:52:07', NULL),
(58, 2, 'T3', 'Investigation/Test', '401', '', '700', '2022-05-21 16:52:25', NULL),
(59, 2, 'T4', 'Investigation/Test', '401', '', '700', '2022-05-21 16:52:39', NULL),
(60, 2, 'FT3', 'Investigation/Test', '401', '', '700', '2022-05-21 16:53:01', NULL),
(61, 2, 'FT4', 'Investigation/Test', '401', '', '700', '2022-05-21 16:53:25', NULL),
(62, 2, 'S.IgE', 'Investigation/Test', '401', '', '1000', '2022-05-21 16:53:47', NULL),
(63, 2, 'S.IgG', 'Investigation/Test', '401', '', '1000', '2022-05-21 16:54:13', NULL),
(64, 2, 'S.IgM', 'Investigation/Test', '401', '', '1000', '2022-05-21 16:55:31', NULL),
(65, 2, 'Troponin-!', 'Investigation/Test', '401', '', '1000', '2022-05-21 16:56:22', NULL),
(66, 2, 'Prolactin(PRL)', 'Investigation/Test', '401', '', '1000', '2022-05-21 16:57:06', NULL),
(67, 2, 'Testosterone', 'Investigation/Test', '401', '', '1000', '2022-05-21 16:59:29', NULL),
(68, 2, 'Cortisol', 'Investigation/Test', '401', '', '1000', '2022-05-21 17:00:01', NULL),
(69, 2, 'Ferritin', 'Investigation/Test', '401', '', '1000', '2022-05-21 17:00:51', NULL),
(70, 2, 'Progesterone', 'Investigation/Test', '401', '', '1000', '2022-05-21 17:01:20', NULL),
(71, 2, 'Parathyroid Hormone (PTH)', 'Investigation/Test', '401', '', '1200', '2022-05-21 17:02:08', NULL),
(72, 2, 'Hb-Electrophoresis', 'Investigation/Test', '401', '', '1200', '2022-05-21 17:02:43', NULL),
(73, 2, 'Beta-HCG', 'Investigation/Test', '401', '', '1000', '2022-05-21 17:03:08', NULL),
(74, 2, 'HLA-B27', 'Investigation/Test', '401', '', '4000', '2022-05-21 17:03:40', NULL),
(75, 2, 'Vitamine-D', 'Investigation/Test', '401', '', '2500', '2022-05-21 17:04:05', NULL),
(76, 2, 'Dengue IgG/Igm', 'Investigation/Test', '401', '', '500', '2022-05-21 17:04:48', NULL),
(77, 2, 'Dengue NS1', 'Investigation/Test', '401', '', '500', '2022-05-21 17:05:58', NULL),
(78, 2, 'Widal Test', 'Investigation/Test', '401', '', '450', '2022-05-21 17:06:41', NULL),
(79, 2, 'VDRL', 'Investigation/Test', '401', '', '600', '2022-05-21 17:08:18', NULL),
(80, 2, 'ASO titre', 'Investigation/Test', '401', '', '700', '2022-05-21 17:10:03', NULL),
(81, 2, 'ANA', 'Investigation/Test', '401', '', '1000', '2022-05-21 17:10:21', NULL),
(82, 2, 'APTT', 'Investigation/Test', '401', '', '800', '2022-05-21 17:10:40', NULL),
(83, 2, 'Ceruloplasmin', 'Investigation/Test', '401', '', '2000', '2022-05-21 17:11:22', NULL),
(84, 2, 'CPK', 'Investigation/Test', '401', '', '800', '2022-05-21 17:11:58', NULL),
(85, 2, 'CK-MB', 'Investigation/Test', '401', '', '800', '2022-05-21 17:12:31', NULL),
(86, 2, 'S.Phosphate(PO4)', 'Investigation/Test', '401', '', '300', '2022-05-21 17:13:29', NULL),
(87, 2, 'Iron Profile', 'Investigation/Test', '401', '', '2500', '2022-05-21 17:13:52', NULL),
(88, 2, 'Total Protien', 'Investigation/Test', '401', '', '400', '2022-05-21 17:14:19', NULL),
(89, 2, 'S.Electrolyte', 'Investigation/Test', '401', '', '800', '2022-05-21 17:14:50', NULL),
(90, 2, 'S.Almylase', 'Investigation/Test', '401', '', '800', '2022-05-21 17:15:18', NULL),
(91, 2, 'S.Lipase', 'Investigation/Test', '401', '', '1000', '2022-05-21 17:15:42', NULL),
(92, 2, 'S.Lipase', 'Investigation/Test', '401', '', '1000', '2022-05-21 17:17:01', NULL),
(93, 2, 'Liver Function Test(LFT)', 'Investigation/Test', '401', '', '1000', '2022-05-21 17:17:41', NULL),
(94, 2, 'Renal Function Test(RFT)', 'Investigation/Test', '401', '', '1000', '2022-05-21 17:18:20', NULL),
(95, 2, 'Urine R/M/E', 'Investigation/Test', '401', '', '250', '2022-05-21 17:18:49', NULL),
(96, 2, 'Urine for C/S', 'Investigation/Test', '401', '', '700', '2022-05-21 17:19:17', NULL),
(97, 2, 'Urine ACR', 'Investigation/Test', '401', '', '1000', '2022-05-21 17:20:01', NULL),
(98, 2, 'Stool R/E', 'Investigation/Test', '401', '', '300', '2022-05-21 17:20:30', NULL),
(99, 2, 'Stool C/S', 'Investigation/Test', '401', '', '700', '2022-05-21 17:20:53', NULL),
(100, 2, 'Wound Swab C/S', 'Investigation/Test', '401', '', '700', '2022-05-21 17:21:21', NULL),
(101, 2, 'Pus For C/S', 'Investigation/Test', '401', '', '1000', '2022-05-21 17:21:47', NULL),
(102, 2, 'Blood For C/S', 'Investigation/Test', '401', '', '1100', '2022-05-21 17:22:16', NULL),
(103, 2, 'RT-PCR-Covid-19', 'Investigation/Test', '401', '', '3500', '2022-05-21 17:22:48', NULL),
(104, 2, 'Red Tube', 'Investigation/Test', '401', '', '10', '2022-05-21 17:23:19', NULL),
(105, 2, 'Sugar Tube', 'Investigation/Test', '401', '', '10', '2022-05-21 17:23:41', NULL),
(106, 2, 'EDTA Tube', 'Investigation/Test', '401', '', '10', '2022-05-21 17:24:20', NULL),
(107, 2, 'Vacume', 'Investigation/Test', '401', '', '20', '2022-05-21 17:24:37', NULL),
(108, 2, 'X-Ray Right Hand B/V ', 'Investigation/Test', '203', '', '450', '2022-05-21 17:26:25', NULL),
(109, 2, 'X-Ray Left Hand B/V', 'Investigation/Test', '203', '', '450', '2022-05-21 17:27:05', NULL),
(110, 2, 'X-Ray Left Thigh B/V', 'Investigation/Test', '203', '', '600', '2022-05-21 17:28:24', NULL),
(111, 2, 'X-Ray Right Thing B/V', 'Investigation/Test', '203', '', '600', '2022-05-21 17:29:08', NULL),
(112, 2, 'X-Ray Left Ankle Joint B/V', 'Investigation/Test', '203', '', '450', '2022-05-21 17:30:02', NULL),
(113, 2, 'X-Ray Right Ankle Joint B/V', 'Investigation/Test', '203', '', '450', '2022-05-21 17:30:47', NULL),
(114, 2, 'X-Ray Cervical Spine B/V', 'Investigation/Test', '203', '', '800', '2022-05-21 17:31:25', NULL),
(115, 2, 'X-Ray Right Forearm B/V', 'Investigation/Test', '203', '', '500', '2022-05-21 17:32:11', NULL),
(116, 2, 'CXR P/V View', 'Investigation/Test', '203', '', '450', '2022-05-21 17:32:40', '2022-05-21 17:33:06'),
(117, 2, 'X-Ray Right Foot B/V', 'Investigation/Test', '203', '', '450', '2022-05-21 17:33:40', NULL),
(118, 2, 'X-Ray Left Foot', 'Investigation/Test', '203', '', '450', '2022-05-21 17:34:11', NULL),
(119, 2, 'X-Ray Left Elbow Joint B/V', 'Investigation/Test', '203', '', '450', '2022-05-21 17:35:22', NULL),
(120, 2, 'x_Ray Right Elbow Joint B/V', 'Investigation/Test', '203', '', '450', '2022-05-21 17:36:10', NULL),
(121, 2, 'X-Ray Dorsolumber Spine B/V', 'Investigation/Test', '203', '', '800', '2022-05-21 17:36:53', NULL),
(122, 2, 'X-Ray Right Leg B/V', 'Investigation/Test', '203', '', '600', '2022-05-21 17:37:21', NULL),
(123, 2, 'X-Ray Left  Leg B/V', 'Investigation/Test', '203', '', '600', '2022-05-21 17:38:32', NULL),
(124, 2, 'X-Ray Left Leg', 'Investigation/Test', '203', '', '600', '2022-05-21 17:48:31', NULL),
(125, 2, 'X-Ray Left Hip Joint B/V', 'Investigation/Test', '203', '', '450', '2022-05-21 17:49:09', NULL),
(126, 2, 'X-Ray Right Hip Joint B/V', 'Investigation/Test', '203', '', '450', '2022-05-21 17:49:56', NULL),
(127, 2, 'X-Ray Pelvis A/P View', 'Investigation/Test', '203', '', '450', '2022-05-21 21:25:39', NULL),
(128, 2, 'X-Ray Lumbosacral Spine B/V ', 'Investigation/Test', '203', '', '800', '2022-05-21 21:26:34', NULL),
(129, 2, 'X-Ray Left Shoulder Joint B/V', 'Investigation/Test', '203', '', '450', '2022-05-21 21:27:19', NULL),
(130, 2, 'X-Ray Right Shoulder Joint B/V', 'Investigation/Test', '203', '', '450', '2022-05-21 21:27:57', NULL),
(131, 2, 'X-Ray Left Forearm B/V', 'Investigation/Test', '203', '', '500', '2022-05-21 21:28:47', NULL),
(132, 2, 'X-Ray Right  Forearm B/V', 'Investigation/Test', '203', '', '500', '2022-05-21 21:30:10', NULL),
(133, 2, 'X-Ray Both Knee B/V', 'Investigation/Test', '203', '', '800', '2022-05-21 21:30:57', NULL),
(134, 2, 'X-Ray Right Wrist Joint B/V', 'Investigation/Test', '203', '', '450', '2022-05-21 21:32:19', NULL),
(135, 2, 'X-Ray Left Wrist Joint B/V', 'Investigation/Test', '203', '', '450', '2022-05-21 21:33:12', NULL),
(136, 2, 'X-Ray Both Wrist Joint B/V', 'Investigation/Test', '203', '', '800', '2022-05-21 21:33:56', NULL),
(137, 2, 'X-Ray Both Ankle Joint B/V', 'Investigation/Test', '203', '', '800', '2022-05-21 21:35:59', NULL),
(138, 2, 'X-Ray Left Knee Joint B/V', 'Investigation/Test', '203', '', '450', '2022-05-21 21:36:45', NULL),
(139, 2, 'X-Ray Coccyx B/V', 'Investigation/Test', '203', '', '800', '2022-05-21 21:37:13', NULL),
(140, 2, 'X-Ray Skull B/V', 'Investigation/Test', '203', '', '600', '2022-05-21 21:38:01', NULL),
(141, 2, 'X-Ray Both Hand ', 'Investigation/Test', '203', '', '800', '2022-05-21 21:38:46', NULL),
(142, 2, 'X-Ray Chest P/A', 'Investigation/Test', '203', '', '500', '2022-05-21 21:39:10', NULL),
(143, 2, 'X-Ray Pelvis Including Hip A/P View', 'Investigation/Test', '203', '', '600', '2022-05-21 21:39:58', NULL),
(144, 2, 'X-Ray Chest Left Lateral Slide Hip', 'Investigation/Test', '203', '', '500', '2022-05-21 21:40:47', NULL),
(145, 2, 'X-Ray Left Arm B/V', 'Investigation/Test', '203', '', '500', '2022-05-21 21:41:21', NULL),
(146, 2, 'X-Ray Right Arm B/V', 'Investigation/Test', '203', '', '500', '2022-05-21 21:42:31', NULL),
(147, 2, 'X-Ray PNS', 'Investigation/Test', '203', '', '500', '2022-05-21 21:42:55', NULL),
(148, 2, 'X-Ray Scapula B/V', 'Investigation/Test', '203', '', '450', '2022-05-21 21:43:27', NULL),
(149, 2, 'X-Ray Scapula B/V', 'Investigation/Test', '203', '', '450', '2022-05-21 21:45:11', NULL),
(150, 2, 'X-Ray Both Foot B/V', 'Investigation/Test', '203', '', '800', '2022-05-21 21:45:37', NULL),
(151, 2, 'X-Ray Both Foot B/V', 'Investigation/Test', '203', '', '800', '2022-05-21 21:46:42', NULL),
(152, 2, 'X-Ray Chest Right Obligue View', 'Investigation/Test', '203', '', '500', '2022-05-21 21:47:57', NULL),
(153, 2, 'X-Ray Left Knee Sky Line', 'Investigation/Test', '203', '', '450', '2022-05-21 21:49:02', NULL),
(154, 2, 'X-Ray PNS O/M', 'Investigation/Test', '203', '', '800', '2022-05-21 21:50:23', NULL),
(155, 2, 'X-Ray Left Temperomandibular Joint ', 'Investigation/Test', '203', '', '800', '2022-05-21 21:51:10', NULL),
(156, 2, 'Dressing-1', 'Procedures', '201', '', '500', '2022-05-21 21:53:50', NULL),
(157, 2, 'Dressing-2', 'Procedures', '201', '', '1000', '2022-05-21 21:54:36', NULL),
(158, 2, 'Plaster-1', 'Procedures', '201', '', '1000', '2022-05-21 21:55:15', NULL),
(159, 2, 'Plaster-2', 'Procedures', '201', '', '1500', '2022-05-21 21:55:44', NULL),
(160, 2, 'Plaster-3', 'Procedures', '203', '', '2000', '2022-05-21 21:57:35', NULL),
(161, 2, 'Plaster-4', 'Procedures', '201', '', '2500', '2022-05-21 21:59:51', NULL),
(162, 2, 'SWD', 'Physiotherapy', 'Male-404,Female-405', '', '200', '2022-05-21 22:01:18', NULL),
(163, 2, 'UST', 'Physiotherapy', 'Male-404,Female-405', '', '200', '2022-05-21 22:02:02', NULL),
(164, 2, 'TENS/EST/MS', 'Physiotherapy', 'Male-404,Female-405', '', '200', '2022-05-21 22:02:39', NULL),
(165, 2, 'Traction LT/CT', 'Physiotherapy', 'Male-404,Female-405', '', '200', '2022-05-21 22:03:48', NULL),
(166, 2, 'WaxBath', 'Physiotherapy', 'Male-404,Female-405', '', '150', '2022-05-21 22:04:16', NULL),
(167, 2, 'IRR', 'Physiotherapy', 'Male-404,Female-405', '', '150', '2022-05-21 22:05:54', NULL),
(168, 2, 'Vibration ', 'Physiotherapy', 'Male-404,Female-405', '', '100', '2022-05-21 22:08:05', NULL),
(169, 2, 'Physio(Pack-1)', 'Physiotherapy', 'Male-404,Female-405', '', '700', '2022-05-21 22:09:34', NULL),
(170, 2, 'Physio(Pack-2)', 'Physiotherapy', '203', '', '500', '2022-05-21 22:10:07', NULL),
(171, 2, 'Physio(Pack-3)', 'Physiotherapy', 'Male-404,Female-405', '', '400', '2022-05-21 22:11:07', NULL),
(172, 2, 'Physio(Pack-)', 'Physiotherapy', 'Male-404,Female-405', '', '300', '2022-05-21 22:11:31', NULL),
(173, 2, 'Physio(Pack-4)', 'Physiotherapy', 'Male-404,Female-405', '', '300', '2022-05-21 22:11:57', NULL),
(174, 2, 'Therapeutic Excer', 'Physiotherapy', 'Male-404,Female-405', '', '250', '2022-05-21 22:13:35', NULL),
(175, 2, 'doctor visit', 'Doctor Visit', '202', '', '600', '2022-05-22 14:38:32', NULL),
(176, 2, 'Physio(Pack-5)', 'Physiotherapy', 'Male-404,Female-405', '', '350', '2022-05-22 16:52:48', NULL),
(177, 2, 'Procedure Charge-2500', 'Procedures', '401', '', '2500', '2022-05-22 18:11:20', NULL),
(178, 2, 'Procedure Charge-5000', 'Procedures', '401', '', '5000', '2022-05-22 20:29:45', NULL),
(179, 2, 'X-Ray Right Knee Joint B/V', 'Investigation/Test', '203', '', '450', '2022-05-23 15:24:35', NULL),
(180, 2, 'Procedure Charge-2000', 'Procedures', '401', '', '2000', '2022-05-23 21:02:48', NULL),
(181, 2, 'USG Of Whole Abdomen', 'Investigation/Test', '401', '', '1200', '2022-05-23 22:18:03', NULL),
(182, 2, 'Plaster-3000', 'Procedures', '201', '', '3000', '2022-05-23 22:32:03', NULL);


--
-- Indexes for dumped tables
--

--
-- Indexes for table `outdoor_service`
--

CREATE TABLE `outdoor_treatment`
(
    `outdoor_treatment_id`                        int(11) NOT NULL AUTO_INCREMENT,
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
  `outdoor_treatment_report_delivery_date` varchar(255) DEFAULT NULL,
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
    `outdoor_treatment_creation_time`             DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `outdoor_treatment_modification_time`         DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (outdoor_treatment_id),
    FOREIGN KEY (outdoor_treatment_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (outdoor_treatment_patient_id) REFERENCES patient (patient_id),
    FOREIGN KEY (outdoor_treatment_indoor_treatment_id) REFERENCES indoor_treatment (indoor_treatment_id)
                                          
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `outdoor_treatment_service`
(
    `outdoor_treatment_service_id`                int(11) NOT NULL AUTO_INCREMENT,
    `outdoor_treatment_service_user_added_id` int(11) NOT NULL,
  `outdoor_treatment_service_treatment_id` int(11) NOT NULL,
  `outdoor_treatment_service_service_id` int(11) NOT NULL,
  `outdoor_treatment_service_service_quantity` varchar(255) DEFAULT '0',
  `outdoor_treatment_service_service_rate` varchar(255) DEFAULT '0',
  `outdoor_treatment_service_discount_pc` varchar(255) DEFAULT '0',
  `outdoor_treatment_service_service_total` varchar(255) DEFAULT '0', 
    `outdoor_treatment_service_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `outdoor_treatment_service_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (outdoor_treatment_service_id),
    FOREIGN KEY (outdoor_treatment_service_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (outdoor_treatment_service_treatment_id) REFERENCES outdoor_treatment (outdoor_treatment_id),
    FOREIGN KEY (outdoor_treatment_service_service_id) REFERENCES outdoor_service (outdoor_service_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


-- ex: medicine,syrap,liquid, tablet,ointment
CREATE TABLE `medicine_category`
(
    `medicine_category_id`                int(11) NOT NULL AUTO_INCREMENT,
    `medicine_category_user_added_id`     int(11) NOT NULL,
    `medicine_category_name`              varchar(255) DEFAULT NULL,
    `medicine_category_description`       varchar(255) DEFAULT NULL,
    `medicine_category_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `medicine_category_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (medicine_category_id),
    FOREIGN KEY (medicine_category_user_added_id) REFERENCES user (user_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- ex: mg,ml,pc
CREATE TABLE `medicine_unit`
(
    `medicine_unit_id`                int(11) NOT NULL AUTO_INCREMENT,
    `medicine_unit_user_added_id`     int(11) NOT NULL,
    `medicine_unit_name`              varchar(255) DEFAULT NULL,
    `medicine_unit_description`       varchar(255) DEFAULT NULL,
    `medicine_unit_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `medicine_unit_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (medicine_unit_id),
    FOREIGN KEY (medicine_unit_user_added_id) REFERENCES user (user_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- ex: pain killer, heart diseas
CREATE TABLE `medicine_type`
(
    `medicine_type_id`                int(11) NOT NULL AUTO_INCREMENT,
    `medicine_type_user_added_id`     int(11) NOT NULL,
    `medicine_type_name`              varchar(255) DEFAULT NULL,
    `medicine_type_description`       varchar(255) DEFAULT NULL,
    `medicine_type_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `medicine_type_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (medicine_type_id),
    FOREIGN KEY (medicine_type_user_added_id) REFERENCES user (user_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- ex: (leaf 1, 20), (leaf 2, 10)
CREATE TABLE `medicine_leaf`
(
    `medicine_leaf_id`                int(11) NOT NULL AUTO_INCREMENT,
    `medicine_leaf_user_added_id` int(11) NOT NULL,
  `medicine_leaf_name` varchar(255) DEFAULT NULL,
  `medicine_leaf_description` varchar(255) DEFAULT NULL,
  `medicine_leaf_total_per_box` varchar(255) DEFAULT NULL,
    `medicine_leaf_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `medicine_leaf_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (medicine_leaf_id),
    FOREIGN KEY (medicine_leaf_user_added_id) REFERENCES user (user_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- ex:
CREATE TABLE `medicine_manufacturer`
(
    `medicine_manufacturer_id`                int(11) NOT NULL AUTO_INCREMENT,
    `medicine_manufacturer_user_added_id` int(11) NOT NULL,
  `medicine_manufacturer_name` varchar(255) DEFAULT NULL,
  `medicine_manufacturer_address` varchar(255) DEFAULT NULL,
  `medicine_manufacturer_mobile` varchar(255) DEFAULT NULL,
  `medicine_manufacturer_email` varchar(255) DEFAULT NULL,
  `medicine_manufacturer_city` varchar(255) DEFAULT NULL,
  `medicine_manufacturer_state` varchar(255) DEFAULT NULL,
  `medicine_manufacturer_description` varchar(255) DEFAULT NULL,
    `medicine_manufacturer_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `medicine_manufacturer_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (medicine_manufacturer_id),
    FOREIGN KEY (medicine_manufacturer_user_added_id) REFERENCES user (user_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `medicine`
(
    `medicine_id`                int(11) NOT NULL AUTO_INCREMENT,
    `medicine_user_added_id` int(11) NOT NULL,
  `medicine_name` varchar(255) DEFAULT NULL,
  `medicine_generic_name` varchar(255) DEFAULT NULL,
  `medicine_description` varchar(255) DEFAULT NULL,
  `medicine_purchase_price` varchar(255) DEFAULT NULL,
  `medicine_selling_price` varchar(255) DEFAULT NULL,
  `medicine_unit` int(11) NOT NULL,
  
  `medicine_manufacturer` int(11) NOT NULL,
  `medicine_status` varchar(255) DEFAULT NULL,
    `medicine_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `medicine_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (medicine_id),
    FOREIGN KEY (medicine_user_added_id) REFERENCES user (user_id),
    -- FOREIGN KEY (medicine_category) REFERENCES medicine_category (medicine_category_id),
    FOREIGN KEY (medicine_unit) REFERENCES medicine_unit (medicine_unit_id),
    -- FOREIGN KEY (medicine_type) REFERENCES medicine_type (medicine_type_id),
    
    FOREIGN KEY (medicine_manufacturer) REFERENCES medicine_manufacturer (medicine_manufacturer_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `pharmacy_medicine`
(
    `pharmacy_medicine_id`                int(11) NOT NULL AUTO_INCREMENT,
  `pharmacy_medicine_user_added_id` int(11) NOT NULL,
  `pharmacy_medicine_medicine_id` int(11) NOT NULL,
  `pharmacy_medicine_quantity` varchar(255) DEFAULT NULL,
  `pharmacy_medicine_batch_id` varchar(255) DEFAULT NULL,
  `pharmacy_medicine_exp_date` datetime DEFAULT NULL,
    `pharmacy_medicine_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pharmacy_medicine_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (pharmacy_medicine_id),
    FOREIGN KEY (pharmacy_medicine_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (pharmacy_medicine_medicine_id) REFERENCES medicine (medicine_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `pharmacy_purchase`
(
    `pharmacy_purchase_id`                int(11) NOT NULL AUTO_INCREMENT,
    `pharmacy_purchase_user_added_id` int(11) NOT NULL,
  `pharmacy_purchase_manufacturer_id` int(11) NOT NULL,
    `pharmacy_purchase_date`              DATETIME     DEFAULT CURRENT_TIMESTAMP,
      `pharmacy_purchase_invoice_no` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_sub_total` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_vat` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_discount` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_grand_total` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_paid_amount` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_due_amount` varchar(255) DEFAULT NULL,
    `pharmacy_purchase_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pharmacy_purchase_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (pharmacy_purchase_id),
    FOREIGN KEY (pharmacy_purchase_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (pharmacy_purchase_manufacturer_id) REFERENCES medicine_manufacturer (medicine_manufacturer_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `pharmacy_purchase_medicine`
(
    `pharmacy_purchase_medicine_id`                   int(11) NOT NULL AUTO_INCREMENT,
    `pharmacy_purchase_medicine_user_added_id` int(11) NOT NULL,
  `pharmacy_purchase_medicine_medicine_id` int(11) NOT NULL,
  `pharmacy_purchase_medicine_purchase_id` int(11) NOT NULL,
  `pharmacy_purchase_medicine_batch_id` varchar(255) DEFAULT NULL,
    `pharmacy_purchase_medicine_exp_date`             DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pharmacy_purchase_medicine_box_quantity` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_medicine_total_pieces` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_medicine_manufacture_price` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_medicine_box_mrp` varchar(255) DEFAULT NULL,
  `pharmacy_purchase_medicine_total_purchase_price` varchar(255) DEFAULT NULL,

    `pharmacy_purchase_medicine_creation_time`        DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pharmacy_purchase_medicine_modification_time`    DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (pharmacy_purchase_medicine_id),
    FOREIGN KEY (pharmacy_purchase_medicine_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (pharmacy_purchase_medicine_medicine_id) REFERENCES pharmacy_medicine (pharmacy_medicine_id),
    FOREIGN KEY (pharmacy_purchase_medicine_purchase_id) REFERENCES pharmacy_purchase (pharmacy_purchase_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `pharmacy_sell`
(
    `pharmacy_sell_id`                int(11) NOT NULL AUTO_INCREMENT,
    `pharmacy_sell_invoice_id` varchar(255) DEFAULT NULL,
  `pharmacy_sell_user_added_id` int(11) NOT NULL,
  `pharmacy_sell_patient_id` int(11) DEFAULT NULL,
  `pharmacy_sell_indoor_treatment_id` int(11) DEFAULT NULL,
    `pharmacy_sell_date`              DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pharmacy_sell_sub_total` varchar(255) DEFAULT NULL,
  `pharmacy_sell_vat` varchar(255) DEFAULT NULL,
  `pharmacy_sell_discount` varchar(255) DEFAULT NULL,
  `pharmacy_sell_grand_total` varchar(255) DEFAULT NULL,
  `pharmacy_sell_paid_amount` varchar(255) DEFAULT NULL,
  `pharmacy_sell_due_amount` varchar(255) DEFAULT NULL,
    `pharmacy_sell_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pharmacy_sell_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (pharmacy_sell_id),
    FOREIGN KEY (pharmacy_sell_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (pharmacy_sell_patient_id) REFERENCES patient (patient_id),
    FOREIGN KEY (pharmacy_sell_indoor_treatment_id) REFERENCES indoor_treatment (indoor_treatment_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `pharmacy_sell_medicine`
(
    `pharmacy_sell_medicine_id`                  int(11) NOT NULL AUTO_INCREMENT,
    `pharmacy_sell_medicine_user_added_id` int(11) NOT NULL,
  `pharmacy_sell_medicine_medicine_id` int(11) NOT NULL,
  `pharmacy_sell_medicine_sell_id` int(11) NOT NULL,
  `pharmacy_sell_medicine_batch_id` varchar(255) DEFAULT NULL,
    `pharmacy_sell_medicine_exp_date`            DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pharmacy_sell_medicine_per_piece_price` varchar(255) DEFAULT NULL,
  `pharmacy_sell_medicine_selling_piece` varchar(255) DEFAULT NULL,
  `pharmacy_sell_medicine_total_selling_price` varchar(255) DEFAULT NULL,

    `pharmacy_sell_medicine_creation_time`       DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pharmacy_sell_medicine_modification_time`   DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (pharmacy_sell_medicine_id),
    FOREIGN KEY (pharmacy_sell_medicine_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (pharmacy_sell_medicine_medicine_id) REFERENCES pharmacy_medicine (pharmacy_medicine_id),
    FOREIGN KEY (pharmacy_sell_medicine_sell_id) REFERENCES pharmacy_sell (pharmacy_sell_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

