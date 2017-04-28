<?php

require_once('../config/database.php');
require_once('../config/functions.php');

if (!isset($_POST['login']) || !isset($_POST['password']))
	$error = "did ya tried to change my html page? really?";
if (!isset($error) && (strlen($_POST['login']) < 5 || strlen($_POST['password']) < 5))
	$error = "not enough character for your login or password";

if (!isset($error))
{
	try
	{
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // to get an exception when caught an error :)
	} catch (PDOException $e) {
	    $error = "Erreur !: " . $e->getMessage();
	}
	if (!isset($error))
	{
		$count_login = $db->prepare("SELECT COUNT(*) FROM camagru_jgengo.user WHERE login = :login");
		$count_login->bindValue(':login', $_POST['login']);
		$count_login->execute();
	}
	if (!isset($error) && !($count_login->fetchColumn() > 0))
		$error = "This username does not exist";

	if (!isset($error))
	{
		$db_select = $db->prepare("SELECT * FROM camagru_jgengo.user WHERE login = :login");
		$db_select->bindValue(':login', $_POST['login']);
		$db_select->execute();

		$user = $db_select->fetch();
		if ($user['validate_link'] != 1)
			$error = "You\'ve to validate your email";
	}

	if (isset($error))
		die("<script>alert('".$error."'); window.location.replace('../');</script>");

	if (hash_it($_POST['password']) == $user['password'])
	{
		session_start();
		$_SESSION['login'] = $user['login'];
		$_SESSION['admin'] = $user['admin'];
		$_SESSION['id'] = $user['id'];
		if ($user['pwreset'] == 1)
			die("<script>alert('You should change your password !!!'); window.location.replace('../');</script>");
		else 
			die("<script>window.location.replace('../');</script>");
	} else { die("<script>alert('Wrong Password'); window.location.replace('../');</script>"); }
}


?>