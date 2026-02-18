CREATE TABLE IF NOT EXISTS `#__sitzplan_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `setting_key` varchar(255) NOT NULL UNIQUE,
  `setting_value` longtext,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__sitzplan_zones` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 5,
  `position` enum('vorne','hinten') NOT NULL DEFAULT 'vorne',
  `gender_rule` enum('offen','M','F') NOT NULL DEFAULT 'offen',
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_date` datetime ON UPDATE CURRENT_TIMESTAMP,
  `ordering` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__sitzplan_seats` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `seat_key` varchar(50) NOT NULL UNIQUE,
  `person_id` int(11),
  `person_name` varchar(255),
  `person_gender` enum('M','F') NOT NULL,
  `seat_type` enum('main','zone') NOT NULL DEFAULT 'main',
  `zone_id` int(11),
  `row_number` int(11),
  `seat_number` int(11),
  `side` enum('L','R'),
  `is_overflow` tinyint(1) DEFAULT 0,
  `assigned_date` datetime,
  `modified_date` datetime ON UPDATE CURRENT_TIMESTAMP,
  KEY `seat_key` (`seat_key`),
  KEY `person_id` (`person_id`),
  KEY `zone_id` (`zone_id`),
  FOREIGN KEY (`zone_id`) REFERENCES `#__sitzplan_zones`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__sitzplan_participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `email` varchar(255),
  `notes` text,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_date` datetime ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `#__sitzplan_participants` (name, gender) VALUES
('Ahmad Karimi', 'M'),
('Fatima Al-Rashid', 'F'),
('Yusuf Demir', 'M'),
('Maryam Hosseini', 'F'),
('Ibrahim Sahin', 'M'),
('Aisha Nasser', 'F'),
('Omar Benali', 'M'),
('Zainab Malik', 'F'),
('Tariq Mansour', 'M'),
('Hana Bergmann', 'F'),
('Karim El-Amin', 'M'),
('Leila Ozdemir', 'F'),
('Bilal Rahman', 'M'),
('Samira Tounsi', 'F'),
('Hassan Al-Farsi', 'M'),
('Nour Abdallah', 'F'),
('Mustafa Celik', 'M'),
('Rania Khalil', 'F');

INSERT INTO `#__sitzplan_config` (setting_key, setting_value) VALUES
('rows', '8'),
('seats_left', '6'),
('seats_right', '6'),
('aisle_width', '44'),
('event_name', 'Musterveranstaltung 2025');

INSERT INTO `#__sitzplan_zones` (name, count, position, gender_rule) VALUES
('Ehrenreihe', 6, 'vorne', 'offen'),
('Orchester', 8, 'hinten', 'M');