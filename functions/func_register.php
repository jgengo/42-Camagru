<?php

require_once('../config/database.php');
require_once('../config/functions.php');
$keywords = preg_split("/MyWebSite\//", getcwd());
$folder = explode('/', $keywords[1]);
$re = "/^(?=(?:.*[a-zA-Z]){4})(?=(?:.*[0-9]){2})\\w+$/m";

if (!isset($_POST['login']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['password_check']))
	$error = "missing some fields, did you try to edit my html?";
if (!isset($error) && (strlen($_POST['login']) < 5 || strlen($_POST['email']) == 0 || strlen($_POST['password']) < 5 || strlen($_POST['password_check']) < 5))
	$error = "fieds badly filled";
if (!isset($error) && ($_POST['password'] != $_POST['password_check']))
	$error = "passwords field aren't same";
if (!preg_match_all($re, $_POST['password'], $matches))
	$error = "password should at least contains 4 characters and 2 digits";


if (!isset($error))
{
	try
	{
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
	    $error = $e->getMessage();
	}
	$checker = $db->prepare("SELECT COUNT(*) FROM camagru_jgengo.user WHERE (login = :login OR email = :email)");
	$checker->bindValue(':login', $_POST['login']);
	$arr = array(
		":login" => $_POST['login'],
		":email" => $_POST['email']
		);
	$checker->execute($arr);

	if ($checker->fetchColumn() > 0)
		$error = "username or email already taken";
}
if (isset($error))
	die("<script>alert('".$error."'); window.location.replace('../?p=register');</script>");

$insert = $db->prepare('INSERT INTO camagru_jgengo.user (email, login, password, admin, validate_link, created_at) VALUES (:email, :login, :password, 0, :validate_link, :created_at)');
$arr = array(
	":login" => $_POST['login'],
	":password" => hash_it($_POST['password']),
	":email" => $_POST['email'],
	":validate_link" => hash('md5', time()),
	":created_at" => date('Y-m-d')
	);
$insert->execute($arr);
mail ($_POST['email'], "[Camagru] Active your account", "To active your account click that link : http://localhost:8080/".$folder[0]."/?p=activate&hash=".$arr[':validate_link']);
die("<script>alert('Created! A mail has been sent!'); window.location.replace('../?p=register');</script>");



?>