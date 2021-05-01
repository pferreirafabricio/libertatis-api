DROP TABLE IF EXISTS `players`;

CREATE TABLE `players` (
  `nick` varchar(60) NOT NULL,
  `name` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`nick`)
);

INSERT INTO players(nick, name) VALUES('admin', 'Administrator');

DROP TABLE IF EXISTS `players_history`;

CREATE TABLE `players_history` (
  `nick` varchar(60) NOT NULL,
  `date` DATE NOT NULL,
  `points` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`nick`),
  FOREIGN KEY (`nick`) REFERENCES `players` (`nick`) ON DELETE CASCADE
);