<?php

require_once('database.php');

$sql = "
USE camagru_jgengo;
CREATE TABLE IF NOT EXISTS `user` (
	`id` int(10) NOT NULL auto_increment, 
	`email` varchar(255), 
	`login` varchar(255), 
	`password` varchar(255), 
	`admin` boolean,
	`pwreset` boolean,
	`validate_link` varchar(255),
	`created_at` date, PRIMARY KEY( `id` )
);
CREATE TABLE IF NOT EXISTS `pic` (
	`id` int(10) NOT NULL auto_increment,
	`name` varchar(255),
	`owner_id` int(11) NOT NULL,
	`created_at` date,
	PRIMARY KEY( `id` )
);
CREATE TABLE IF NOT EXISTS `comment` (
	`id` int(10) NOT NULL auto_increment,
	`owner_id` int(11) NOT NULL,
	`pic_id` int(11) NOT NULL,
	`content` text,
	`created_at` date,
	PRIMARY KEY( `id` )
);
CREATE TABLE IF NOT EXISTS `like` (
	`id` int(10) NOT NULL auto_increment,
	`owner_id` int(11) NOT NULL,
	`pic_id` int(11) NOT NULL,
	`created_at` date,
	PRIMARY KEY( `id` )
);";

try
{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // to get an exception when caught an error :)
	$db->exec("CREATE DATABASE IF NOT EXISTS camagru_jgengo;");
	$db->exec($sql);
	echo "<p><b>database and tables successfully installed.</b></p>";
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

?>