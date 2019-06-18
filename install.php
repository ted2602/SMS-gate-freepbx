<?php
/**
 * Created by Itach-soft.
 */
global $db;
/* FreePBX installer file
 * This file is run when the module is installed through module admin
 *
 * Note: install.sql is depreciated and may not work. Its recommended to use this file instead.
 *
 * If this file returns false then the module will not install
 * EX:
 * return false;
 *
 */
$sql = "

CREATE TABLE IF NOT EXISTS `smsgate_settings` (
  `gateid` varchar(255) NOT NULL,
  `gatebrand` varchar(255) NOT NULL,
  `gateip` varchar(255) DEFAULT NULL,
  `gateapiport` varchar(255) DEFAULT NULL,
  `gateusername` varchar(255) DEFAULT NULL,
  `gatepassword` varchar(255) DEFAULT NULL,
  `gateports` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `smsgate_settings`(`gateid`, `gatebrand`, `gateip`, `gateapiport`, `gateusername`, `gatepassword`, `gateports`)
VALUES (1,'dinstar','','','','','');

   CREATE TABLE IF NOT EXISTS `smsgate_stat` (
  `mesid` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(255) NOT NULL,
  `gateid` varchar(255) DEFAULT NULL,
  `portid` varchar(255) NOT NULL,
  `number` varchar(255) DEFAULT NULL,
  `text` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  UNIQUE KEY `mesid` (`mesid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

$check = sql($sql);
if (DB::IsError($check)) {
    die_freepbx( "Can not create table: " . $check->getMessage() .  "\n");
}