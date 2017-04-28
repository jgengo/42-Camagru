<?php

session_start();
require ('../config/database.php');

if (!isset($_POST['id']))
	$error = "missing some fields, did you try to edit my html?";
if (!isset($error) && (strlen($_POST['id']) == 0))
	$error = "fields badly filled";


if (!isset($error))
{
	try
	{
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
	    $error = "Erreur !: " . $e->getMessage() . "<br/>";
	    die();
	}
}

$check = $db->prepare("SELECT p.*, u.login FROM camagru_jgengo.pic as p INNER JOIN camagru_jgengo.user as u ON p.owner_id = u.id WHERE p.id = :id");
$check->bindValue(':id', $_POST['id']);
$check->execute();
$user = $check->fetchAll();

if ($user[0]['login'] != $_SESSION['login'])
	$error = "you're not allowed to delete others pictures!";

if (isset($error))
	die($error);

$del_pic = $db->prepare("DELETE FROM camagru_jgengo.pic WHERE id = :id");
$del_pic->bindValue(':id', $_POST['id']);
$del_pic->execute();

?>