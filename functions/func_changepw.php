<?php


require_once('../config/database.php');
require_once('../config/functions.php');

session_start();

$re = "/^(?=(?:.*[a-zA-Z]){4})(?=(?:.*[0-9]){2})\\w+$/m";

if (!isset($_POST['password']) || !isset($_POST['password_check']))
	$error = "You tried to change the html fields?";
if (!isset($error) && (strlen($_POST['password']) < 5 || strlen($_POST['password_check']) < 5) )
	$error = "Not enough character for your password.";
if (!isset($error) && ($_POST['password'] != $_POST['password_check']))
	$error = "passwords field aren't same";
if (!preg_match_all($re, $_POST['password'], $matches))
	$error = "password should at least contains 4 characters and 2 digits";

if (isset($error))
	die("<script>alert('".$error."'); window.location.replace('../?p=changepw');</script>");

try
{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error = $e->getMessage();
}

if (isset($error))
	die("<script>alert('".$error."'); window.location.replace('../?p=changepw');</script>");
else {
	$changepw = $db->prepare("UPDATE camagru_jgengo.user SET password = :password, pwreset = 0 WHERE user.id = :user_id;");
	$arr = array(
	 		":password" => hash_it($_POST['password']),
	 		":user_id" => $_SESSION['id']
	 	);
	$changepw->execute($arr);
	die("<script>alert('Password changed'); window.location.href='../';</script>");
}
?>