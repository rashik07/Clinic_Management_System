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

INSERT INTO user_type (user_type_id, user_type_Name, user_type_access_level, user_type_creation_time,
                       user_type_modification_time)
VALUES (1, 'super_admin', 1, now(), now()),
       (2, 'admin', 2, now(), now()),
       (3, 'outdoor_manager', 3, now(), now()),
       (4, 'indoor_manager', 4, now(), now()),
       (5, 'pathology_manager', 5, now(), now()),
       (6, 'pharmacy_manager', 6, now(), now()),
       (7, 'ot_manager', 7, now(), now())
;
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

INSERT INTO user (user_id, user_Full_Name, user_PhoneNo, username, user_Email, user_Password, user_Status,
                  user_creation_time,
                  user_modification_time, user_type_id)
VALUES (1, 'Abdullah Al Rifat', '01671080275', 'rifat', 'abdullahalrifat95@gmail.com', MD5('accessdenied'), 'active',
        now(),
        now(), 1),
       (2, 'super_admin', '01000000000', 'super_admin', 'super_admin@gmail.com', MD5('0912'), 'active', now(), now(),
        1),
       (3, 'admin', '01000000000', 'admin', 'admin@gmail.com', MD5('0912'), 'active', now(), now(), 2),
       (4, 'outdoor_manager', '01000000000', 'outdoor_manager', 'outdoor_manager@gmail.com', MD5('0912'), 'active',
        now(), now(), 3),
       (5, 'indoor_manager', '01000000000', 'indoor_manager', 'indoor_manager@gmail.com', MD5('0912'), 'active', now(),
        now(), 4),
       (6, 'pathology_manager', '01000000000', 'pathology_manager', 'pathology_manager@gmail.com', MD5('0912'),
        'active', now(), now(), 5),
       (7, 'pharmacy_manager', '01000000000', 'pharmacy_manager', 'pharmacy_manager@gmail.com', MD5('0912'), 'active',
        now(), now(), 6),
       (8, 'ot_manager', '01000000000', 'ot_manager', 'ot_manager@gmail.com', MD5('0912'), 'active', now(), now(), 7)
;
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
    FOREIGN KEY (patient_user_added_id) REFERENCES user (user_id),
    UNIQUE (patient_phone)
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
    `indoor_treatment_admission_id`              varchar(255) ,
    `indoor_treatment_user_added_id`             int(11) NOT NULL,
    `indoor_treatment_patient_id`                int(11) NOT NULL,
    `indoor_treatment_reference`                 varchar(255) DEFAULT NULL,
    `indoor_treatment_total_bill`                varchar(255) DEFAULT NULL, 
    `indoor_treatment_total_bill_after_discount` varchar(255) DEFAULT NULL, 
    `indoor_treatment_discount_pc`               varchar(255) DEFAULT 0,    
    `indoor_treatment_total_paid`                varchar(255) DEFAULT NULL, 
    `indoor_treatment_total_due`                 varchar(255) DEFAULT 0,    
    `indoor_treatment_payment_type`              varchar(255) DEFAULT NULL, 
    `indoor_treatment_payment_type_no`           varchar(255) DEFAULT NULL, 
    `indoor_treatment_note`                      varchar(255) DEFAULT NULL, 
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
    `indoor_treatment_bed_user_added_id`     int(11) NOT NULL,
    `indoor_treatment_bed_treatment_id`      int(11) NOT NULL,
    `indoor_treatment_bed_bed_id`            int(11) NOT NULL,
    `indoor_treatment_bed_category_name`     varchar(255) DEFAULT NULL, --
    `indoor_treatment_bed_price`             varchar(255) DEFAULT NULL, --
    `indoor_treatment_bed_total_bill`        varchar(255) DEFAULT NULL, --

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
    `indoor_treatment_doctor_user_added_id`     int(11) NOT NULL,
    `indoor_treatment_doctor_treatment_id`      int(11) NOT NULL,
    `indoor_treatment_doctor_doctor_id`         int(11) NOT NULL,
    `indoor_treatment_doctor_specialization`    varchar(255) DEFAULT NULL, 
    `indoor_treatment_doctor_visit_fee`         varchar(255) DEFAULT NULL, 
    `indoor_treatment_doctor_total_bill`        varchar(255) DEFAULT NULL, 

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
    `outdoor_service_user_added_id`     int(11)      NOT NULL,
    `outdoor_service_name`              varchar(255) NOT NULL,
    `outdoor_service_description`       varchar(255) DEFAULT NULL,
    `outdoor_service_rate`              varchar(255) DEFAULT NULL,
    `outdoor_service_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `outdoor_service_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (outdoor_service_id),
    FOREIGN KEY (outdoor_service_user_added_id) REFERENCES user (user_id)
    
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `outdoor_treatment`
(
    `outdoor_treatment_id`                        int(11) NOT NULL AUTO_INCREMENT,
    `outdoor_treatment_user_added_id`             int(11) NOT NULL,
    `outdoor_treatment_patient_id`                int(11) NOT NULL,
    `outdoor_treatment_indoor_treatment_id`       int(11) DEFAULT NULL,
    `outdoor_treatment_reference`                 varchar(255) DEFAULT NULL,
    `outdoor_treatment_total_bill`                varchar(255) DEFAULT NULL, 
    `outdoor_treatment_total_bill_after_discount` varchar(255) DEFAULT NULL, 
    `outdoor_treatment_discount_pc`               varchar(255) DEFAULT 0,    
    `outdoor_treatment_total_paid`                varchar(255) DEFAULT NULL, 
    `outdoor_treatment_total_due`                 varchar(255) DEFAULT 0,    
    `outdoor_treatment_payment_type`              varchar(255) DEFAULT NULL, 
    `outdoor_treatment_payment_type_no`           varchar(255) DEFAULT NULL, 
    `outdoor_treatment_note`                      varchar(255) DEFAULT NULL, 
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
    `outdoor_treatment_service_user_added_id`     int(11) NOT NULL,
    `outdoor_treatment_service_treatment_id`      int(11) NOT NULL,
    `outdoor_treatment_service_service_id`        int(11) NOT NULL,
    `outdoor_treatment_service_service_quantity`  varchar(255) DEFAULT NULL, 
    `outdoor_treatment_service_service_rate`      varchar(255) DEFAULT NULL, 
    `outdoor_treatment_service_service_total`     varchar(255) DEFAULT NULL, 
    `outdoor_treatment_service_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `outdoor_treatment_service_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (outdoor_treatment_service_id),
    FOREIGN KEY (outdoor_treatment_service_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (outdoor_treatment_service_treatment_id) REFERENCES outdoor_treatment (outdoor_treatment_id),
    FOREIGN KEY (outdoor_treatment_service_service_id) REFERENCES outdoor_service (outdoor_service_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


-- pathology management

CREATE TABLE `pathology_test`
(
    `pathology_test_id`                int(11) NOT NULL AUTO_INCREMENT,
    `pathology_test_user_added_id`     int(11) NOT NULL,
    `pathology_test_name`              varchar(255) DEFAULT NULL, 
    `pathology_test_description`       varchar(255) DEFAULT NULL,
    `pathology_test_room_no`           varchar(255) DEFAULT NULL,
    `pathology_test_price`             varchar(255) DEFAULT NULL,
    `pathology_test_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pathology_test_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (pathology_test_id),
    FOREIGN KEY (pathology_test_user_added_id) REFERENCES user (user_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `pathology_investigation`
(
    `pathology_investigation_id`                        int(11) NOT NULL AUTO_INCREMENT,
    `pathology_investigation_user_added_id`             int(11) NOT NULL,
    `pathology_investigation_patient_id`                int(11) NOT NULL,
    `pathology_investigation_indoor_treatment_id`       int(11) DEFAULT NULL,
    `pathology_investigation_treatment_reference`       varchar(255) DEFAULT NULL,
    `pathology_investigation_total_bill`                varchar(255) DEFAULT NULL,   
    `pathology_investigation_total_bill_after_discount` varchar(255) DEFAULT NULL,   
    `pathology_investigation_discount_pc`               varchar(255) DEFAULT 0,      
    `pathology_investigation_total_paid`                varchar(255) DEFAULT NULL,   
    `pathology_investigation_total_due`                 varchar(255) DEFAULT 0,      
    `pathology_investigation_payment_type`              varchar(255) DEFAULT NULL,   
    `pathology_investigation_payment_type_no`           varchar(255) DEFAULT NULL,   
    `pathology_investigation_note`                      varchar(255) DEFAULT NULL,   
    `pathology_investigation_date`                      DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pathology_investigation_creation_time`             DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pathology_investigation_modification_time`         DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (pathology_investigation_id),
    FOREIGN KEY (pathology_investigation_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (pathology_investigation_patient_id) REFERENCES patient (patient_id) ,
    FOREIGN KEY (pathology_investigation_indoor_treatment_id) REFERENCES indoor_treatment (indoor_treatment_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `pathology_investigation_test`
(
    `pathology_investigation_test_id`                int(11) NOT NULL AUTO_INCREMENT,
    `pathology_investigation_test_user_added_id`     int(11) NOT NULL,
    `pathology_investigation_test_investigation_id`  int(11) NOT NULL,
    `pathology_investigation_test_pathology_test_id` int(11) NOT NULL,

    `pathology_investigation_test_room_no`           varchar(255) DEFAULT NULL,
    `pathology_investigation_test_price`             varchar(255) DEFAULT NULL,                                                
    `pathology_investigation_test_quantity`          varchar(255) DEFAULT 0, 
    `pathology_investigation_test_dc`            varchar(255) DEFAULT NULL,                                                    
    `pathology_investigation_test_total_bill`        varchar(255) DEFAULT NULL,                                                  

    `pathology_investigation_creation_time`          DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pathology_investigation_modification_time`      DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (pathology_investigation_test_id),
    FOREIGN KEY (pathology_investigation_test_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (pathology_investigation_test_investigation_id) REFERENCES pathology_investigation (pathology_investigation_id), 
    FOREIGN KEY (pathology_investigation_test_pathology_test_id) REFERENCES pathology_test (pathology_test_id)                   -- main patient instance

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- pharmacy management

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
    `medicine_leaf_user_added_id`     int(11) NOT NULL,
    `medicine_leaf_name`              varchar(255) DEFAULT NULL,
    `medicine_leaf_description`       varchar(255) DEFAULT NULL,
    `medicine_leaf_total_per_box`     varchar(255) DEFAULT NULL,
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
    `medicine_manufacturer_user_added_id`     int(11) NOT NULL,
    `medicine_manufacturer_name`              varchar(255) DEFAULT NULL,
    `medicine_manufacturer_address`           varchar(255) DEFAULT NULL,
    `medicine_manufacturer_mobile`            varchar(255) DEFAULT NULL,
    `medicine_manufacturer_email`             varchar(255) DEFAULT NULL,
    `medicine_manufacturer_city`              varchar(255) DEFAULT NULL,
    `medicine_manufacturer_state`             varchar(255) DEFAULT NULL,
    `medicine_manufacturer_description`       varchar(255) DEFAULT NULL,
    `medicine_manufacturer_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `medicine_manufacturer_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (medicine_manufacturer_id),
    FOREIGN KEY (medicine_manufacturer_user_added_id) REFERENCES user (user_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `medicine`
(
    `medicine_id`                int(11) NOT NULL AUTO_INCREMENT,
    `medicine_user_added_id`     int(11) NOT NULL,
    `medicine_name`              varchar(255) DEFAULT NULL,
    `medicine_generic_name`      varchar(255) DEFAULT NULL,
    `medicine_description`       varchar(255) DEFAULT NULL,
    `medicine_purchase_price`    varchar(255) DEFAULT NULL,
    `medicine_selling_price`     varchar(255) DEFAULT NULL,
    -- `medicine_category`          int(11) NOT NULL,
    `medicine_unit`              int(11) NOT NULL,
    -- `medicine_type`              int(11) NOT NULL,
    `medicine_leaf`              int(11) NOT NULL,
    `medicine_manufacturer`      int(11) NOT NULL,
    `medicine_status`            varchar(255) DEFAULT NULL,
    `medicine_creation_time`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `medicine_modification_time` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (medicine_id),
    FOREIGN KEY (medicine_user_added_id) REFERENCES user (user_id),
    -- FOREIGN KEY (medicine_category) REFERENCES medicine_category (medicine_category_id),
    FOREIGN KEY (medicine_unit) REFERENCES medicine_unit (medicine_unit_id),
    -- FOREIGN KEY (medicine_type) REFERENCES medicine_type (medicine_type_id),
    FOREIGN KEY (medicine_leaf) REFERENCES medicine_leaf (medicine_leaf_id),
    FOREIGN KEY (medicine_manufacturer) REFERENCES medicine_manufacturer (medicine_manufacturer_id)

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `pharmacy_medicine`
(
    `pharmacy_medicine_id`                int(11) NOT NULL AUTO_INCREMENT,
    `pharmacy_medicine_user_added_id`     int(11) NOT NULL,
    `pharmacy_medicine_medicine_id`       int(11) NOT NULL,
    `pharmacy_medicine_quantity`          varchar(255) DEFAULT NULL,
    `pharmacy_medicine_batch_id`          varchar(255) DEFAULT NULL,
    `pharmacy_medicine_exp_date`          DATETIME     DEFAULT NULL,
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
    `pharmacy_purchase_user_added_id`     int(11) NOT NULL,
    `pharmacy_purchase_manufacturer_id`   int(11) NOT NULL,
    `pharmacy_purchase_date`              DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pharmacy_purchase_invoice_no`        varchar(255) DEFAULT NULL,
    `pharmacy_purchase_sub_total`         varchar(255) DEFAULT NULL,
    `pharmacy_purchase_vat`               varchar(255) DEFAULT NULL,
    `pharmacy_purchase_discount`          varchar(255) DEFAULT NULL,
    `pharmacy_purchase_grand_total`       varchar(255) DEFAULT NULL,
    `pharmacy_purchase_paid_amount`       varchar(255) DEFAULT NULL,
    `pharmacy_purchase_due_amount`        varchar(255) DEFAULT NULL,
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
    `pharmacy_purchase_medicine_user_added_id`        int(11) NOT NULL,
    `pharmacy_purchase_medicine_medicine_id`          int(11) NOT NULL,
    `pharmacy_purchase_medicine_purchase_id`          int(11) NOT NULL,

    `pharmacy_purchase_medicine_batch_id`             varchar(255) DEFAULT NULL,
    `pharmacy_purchase_medicine_exp_date`             DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pharmacy_purchase_medicine_box_quantity`         varchar(255) DEFAULT NULL,
    `pharmacy_purchase_medicine_total_pieces`         varchar(255) DEFAULT NULL,

    `pharmacy_purchase_medicine_manufacture_price`    varchar(255) DEFAULT NULL,
    `pharmacy_purchase_medicine_box_mrp`              varchar(255) DEFAULT NULL,
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
    `pharmacy_sell_user_added_id`     int(11) NOT NULL,
    `pharmacy_sell_patient_id`        int(11) NOT NULL,
    `pharmacy_sell_indoor_treatment_id`       int(11) DEFAULT NULL,
    `pharmacy_sell_date`              DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pharmacy_sell_sub_total`         varchar(255) DEFAULT NULL,
    `pharmacy_sell_vat`               varchar(255) DEFAULT NULL,
    `pharmacy_sell_discount`          varchar(255) DEFAULT NULL,
    `pharmacy_sell_grand_total`       varchar(255) DEFAULT NULL,
    `pharmacy_sell_paid_amount`       varchar(255) DEFAULT NULL,
    `pharmacy_sell_due_amount`        varchar(255) DEFAULT NULL,
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
    `pharmacy_sell_medicine_user_added_id`       int(11) NOT NULL,
    `pharmacy_sell_medicine_medicine_id`         int(11) NOT NULL,
    `pharmacy_sell_medicine_sell_id`             int(11) NOT NULL,

    `pharmacy_sell_medicine_batch_id`            varchar(255) DEFAULT NULL,
    `pharmacy_sell_medicine_exp_date`            DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pharmacy_sell_medicine_per_piece_price`     varchar(255) DEFAULT NULL,
    `pharmacy_sell_medicine_selling_piece`       varchar(255) DEFAULT NULL,
    `pharmacy_sell_medicine_total_selling_price` varchar(255) DEFAULT NULL,

    `pharmacy_sell_medicine_creation_time`       DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `pharmacy_sell_medicine_modification_time`   DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (pharmacy_sell_medicine_id),
    FOREIGN KEY (pharmacy_sell_medicine_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (pharmacy_sell_medicine_medicine_id) REFERENCES pharmacy_medicine (pharmacy_medicine_id),
    FOREIGN KEY (pharmacy_sell_medicine_sell_id) REFERENCES pharmacy_sell (pharmacy_sell_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- OT management
CREATE TABLE `ot_treatment`
(
    `ot_treatment_id`                        int(11) NOT NULL AUTO_INCREMENT,
    `ot_treatment_user_added_id`             int(11) NOT NULL,
    `ot_treatment_patient_id`                int(11) NOT NULL,
    `ot_treatment_indoor_treatment_id`       int(11) DEFAULT NULL,
    `ot_treatment_reference`                 varchar(255) DEFAULT NULL,
    `ot_treatment_total_bill`                varchar(255) DEFAULT NULL,   
    `ot_treatment_total_bill_after_discount` varchar(255) DEFAULT NULL,   
    `ot_treatment_discount_pc`               varchar(255) DEFAULT 0,      
    `ot_treatment_total_paid`                varchar(255) DEFAULT NULL,   
    `ot_treatment_total_due`                 varchar(255) DEFAULT 0,      
    `ot_treatment_payment_type`              varchar(255) DEFAULT NULL,   
    `ot_treatment_payment_type_no`           varchar(255) DEFAULT NULL,   
    `ot_treatment_note`                      varchar(255) DEFAULT NULL,   
    `ot_treatment_date`                      DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `ot_treatment_creation_time`             DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `ot_treatment_modification_time`         DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (ot_treatment_id),
    FOREIGN KEY (ot_treatment_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (ot_treatment_patient_id) REFERENCES patient (patient_id), -- main patient instance
    FOREIGN KEY (ot_treatment_indoor_treatment_id) REFERENCES indoor_treatment (indoor_treatment_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `ot_treatment_doctor`
(
    `ot_treatment_doctor_id`                        int(11) NOT NULL AUTO_INCREMENT,
    `ot_treatment_doctor_user_added_id`             int(11) NOT NULL,
    `ot_treatment_doctor_doctor_id`                 int(11) NOT NULL,
    `ot_treatment_doctor_treatment_id`              int(11) NOT NULL,
    `ot_treatment_doctor_bill`                      varchar(255) DEFAULT NULL,
    `ot_treatment_doctor_note`                      varchar(255) DEFAULT NULL,   --
    `ot_treatment_doctor_creation_time`             DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `ot_treatment_doctor_modification_time`         DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (ot_treatment_doctor_id),
    FOREIGN KEY (ot_treatment_doctor_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (ot_treatment_doctor_treatment_id) REFERENCES ot_treatment (ot_treatment_id),
    FOREIGN KEY (ot_treatment_doctor_doctor_id) REFERENCES doctor (doctor_id) -- main doctor instance

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `ot_treatment_guest_doctor`
(
    `ot_treatment_guest_doctor_id`                        int(11) NOT NULL AUTO_INCREMENT,
    `ot_treatment_guest_doctor_user_added_id`             int(11) NOT NULL,
    `ot_treatment_guest_doctor_doctor_name`                       varchar(255) DEFAULT NULL,
    `ot_treatment_guest_doctor_treatment_id`              int(11) NOT NULL,
    `ot_treatment_guest_doctor_bill`                      varchar(255) DEFAULT NULL,
    `ot_treatment_guest_doctor_note`                      varchar(255) DEFAULT NULL,   --
    `ot_treatment_guest_doctor_creation_time`             DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `ot_treatment_guest_doctor_modification_time`         DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (ot_treatment_guest_doctor_id),
    FOREIGN KEY (ot_treatment_guest_doctor_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (ot_treatment_guest_doctor_treatment_id) REFERENCES ot_treatment (ot_treatment_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `ot_treatment_item`
(
    `ot_treatment_item_id`                        int(11) NOT NULL AUTO_INCREMENT,
    `ot_treatment_item_user_added_id`             int(11) NOT NULL,
    `ot_treatment_item_treatment_id`              int(11) NOT NULL,
    `ot_treatment_item_name`                      varchar(255) DEFAULT NULL,   
    `ot_treatment_item_price`                     varchar(255) DEFAULT NULL,
    `ot_treatment_item_note`                      varchar(255) DEFAULT NULL,   
    `ot_treatment_item_creation_time`             DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `ot_treatment_item_modification_time`         DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (ot_treatment_item_id),
    FOREIGN KEY (ot_treatment_item_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (ot_treatment_item_treatment_id) REFERENCES ot_treatment (ot_treatment_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `ot_treatment_pharmacy_item`
(
    `ot_treatment_pharmacy_item_id`                        int(11) NOT NULL AUTO_INCREMENT,
    `ot_treatment_pharmacy_item_user_added_id`             int(11) NOT NULL,
    `ot_treatment_pharmacy_item_treatment_id`              int(11) NOT NULL,
    `ot_treatment_pharmacy_item_medicine_id`               int(11) NOT NULL,
    `ot_treatment_pharmacy_item_batch_id`                     varchar(255) DEFAULT NULL,
    `ot_treatment_pharmacy_item_stock_qty`                     varchar(255) DEFAULT NULL,
    `ot_treatment_pharmacy_item_per_piece_price`                     varchar(255) DEFAULT NULL,
    `ot_treatment_pharmacy_item_quantity`                  varchar(255) DEFAULT NULL,
    `ot_treatment_pharmacy_item_bill`                      varchar(255) DEFAULT NULL,
    `ot_treatment_pharmacy_item_note`                      varchar(255) DEFAULT NULL,   --
    `ot_treatment_pharmacy_item_creation_time`             DATETIME     DEFAULT CURRENT_TIMESTAMP,
    `ot_treatment_pharmacy_item_modification_time`         DATETIME ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (ot_treatment_pharmacy_item_id),
    FOREIGN KEY (ot_treatment_pharmacy_item_user_added_id) REFERENCES user (user_id),
    FOREIGN KEY (ot_treatment_pharmacy_item_treatment_id) REFERENCES ot_treatment (ot_treatment_id),
    FOREIGN KEY (ot_treatment_pharmacy_item_medicine_id) REFERENCES pharmacy_medicine (pharmacy_medicine_id) -- main pharmacy medicine instance

) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;