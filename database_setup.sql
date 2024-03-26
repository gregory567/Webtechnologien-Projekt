--
-- Datenbank: `hotel_management`
--
DROP DATABASE IF EXISTS `hotel_management`;
CREATE DATABASE IF NOT EXISTS `hotel_management` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- User: `hotel_administrator`
--
DROP USER IF EXISTS 'hotel_administrator'@'localhost';
FLUSH PRIVILEGES;
CREATE USER 'hotel_administrator'@'localhost' IDENTIFIED BY 'admin';
GRANT ALL PRIVILEGES ON hotel_management.* TO 'hotel_administrator'@'localhost';


--
-- Table: `users` (admin muss manuell angelegt werden)
--
DROP TABLE IF EXISTS `hotel_management`.`users`;
CREATE TABLE `hotel_management`.`users` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `anrede` varchar(64) NOT NULL,
  `vorname` varchar(64) NOT NULL,
  `nachname` varchar(64) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `passwort` varchar(100) NOT NULL,
  `rolle` varchar(64) NOT NULL,
  `status` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `users`
--
INSERT INTO `users` (`id`, `anrede`, `vorname`, `nachname`, `email`, `username`, `passwort`, `rolle`, `status`) VALUES
(1, 'Herr', 'Markus', 'Doe', 'markus.doe@gmail.com', 'markus.doe', '$2y$10$AJezLdY/cuzpneY25qzU1.q6RK4GvAkUDU1YXnDNyFQOXQmDSBwI.', 'user', 'aktiv'),
(2, 'Frau', 'Anna', 'Maier', 'anna.maier@gmail.com', 'anna.maier', '$2y$10$b1Z8LggW/iBGfsbTSkq3POPJcVNiVoLQeN/XSrQ.qMjlnsFCAQqGe', 'user', 'aktiv'),
(3, 'Divers', 'Rafael', 'Uhrmann', 'rafael.uhrmann@gmail.com', 'rafael.uhrmann', '$2y$10$MemeRAqZcyfIAHXGaR5shuM4uEN62SkgZuf2pCQycX3.2INRhV4FS', 'user', 'aktiv');


--
-- Table: `zimmer`
--
DROP TABLE IF EXISTS `hotel_management`.`zimmer`;
CREATE TABLE `hotel_management`.`zimmer` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `etage` int(11) NOT NULL,
  `bettanzahl` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `zimmer`
--
INSERT INTO `zimmer` (`id`, `etage`, `bettanzahl`) VALUES
(1, 1, 3),
(2, 1, 3),
(3, 1, 4),
(4, 2, 2),
(5, 2, 3);


--
-- Table: `reservierungen`
--
DROP TABLE IF EXISTS `hotel_management`.`reservierungen`;
CREATE TABLE `hotel_management`.`reservierungen` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `zimmer` int(64) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `frühstück` varchar(64) NOT NULL,
  `parkplatz` varchar(64) NOT NULL,
  `haustier` varchar(64) NOT NULL,
  `haustier_info` text DEFAULT NULL,
  `status` varchar(64) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  KEY `user_id_constraint` (`user_id`),
  KEY `zimmer_constraint` (`zimmer`),
  CONSTRAINT `user_id_constraint` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `zimmer_constraint` FOREIGN KEY (`zimmer`) REFERENCES `zimmer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `reservierungen`
--
INSERT INTO `reservierungen` (`id`, `user_id`, `zimmer`, `start_date`, `end_date`, `frühstück`, `parkplatz`, `haustier`, `haustier_info`, `status`, `timestamp`) VALUES
(1, 1, 1, '2023-01-14', '2023-01-16', 'mit', 'ohne', 'ja', 'Hamster', 'neu', '2023-01-13 00:58:51'),
(2, 2, 2, '2023-01-17', '2023-01-20', 'ohne', 'mit', 'nein', NULL, 'neu', '2023-01-13 01:02:54'),
(3, 3, 4, '2023-01-17', '2023-01-22', 'ohne', 'ohne', 'ja', 'Hund, Katze', 'neu', '2023-01-13 02:28:07'),
(4, 2, 1, '2023-01-29', '2023-02-05', 'ohne', 'mit', 'nein', NULL, 'neu', '2023-01-14 04:14:28');


--
-- Tabellenstruktur für Tabelle `newsbeitraege`
--
DROP TABLE IF EXISTS `hotel_management`.`newsbeitraege`;
CREATE TABLE `hotel_management`.`newsbeitraege` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `bildpfad` varchar(64) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  KEY `admin_id_constraint` (`user_id`),
  CONSTRAINT `admin_id_constraint` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `newsbeitraege`
--
INSERT INTO `newsbeitraege` (`id`, `user_id`, `text`, `bildpfad`, `timestamp`) VALUES
(1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '../thumbnails/palm-g23b982cfc_1280.jpg', '2023-01-13 00:53:04'),
(2, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '../thumbnails/pool-g24990baf0_1280.jpg', '2023-01-13 00:53:19'),
(3, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '../thumbnails/resort-g9a1d9bb48_1280.jpg', '2023-01-13 00:53:28'),
(4, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '../thumbnails/water-gf3d0010dc_1280.jpg', '2023-01-13 00:53:34'),
(5, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '../thumbnails/beach-gc96e66d4e_1920.jpg', '2023-01-13 09:39:06'),
(6, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '../thumbnails/beach-gfd7f75560_1920.jpg', '2023-01-13 09:39:14');


--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `newsbeitraege`
--
ALTER TABLE `newsbeitraege`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id_constraint` (`user_id`);

--
-- Indizes für die Tabelle `reservierungen`
--
ALTER TABLE `reservierungen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_constraint` (`user_id`),
  ADD KEY `zimmer_constraint` (`zimmer`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `zimmer`
--
ALTER TABLE `zimmer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `newsbeitraege`
--
ALTER TABLE `newsbeitraege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `reservierungen`
--
ALTER TABLE `reservierungen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `zimmer`
--
ALTER TABLE `zimmer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `newsbeitraege`
--
ALTER TABLE `newsbeitraege`
  ADD CONSTRAINT `admin_id_constraint` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `reservierungen`
--
ALTER TABLE `reservierungen`
  ADD CONSTRAINT `user_id_constraint` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `zimmer_constraint` FOREIGN KEY (`zimmer`) REFERENCES `zimmer` (`id`) ON DELETE CASCADE;
COMMIT;



