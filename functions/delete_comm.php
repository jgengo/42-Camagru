<?php

session_start();
require ('../config/database.php');

if (!isset($_POST['id']))
	die("missing some fields, did you try to edit my html?");
if (strlen($_POST['id']) == 0 && is_numeric($_POST['id']))
	die("fields badly filled");

try
{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	$error = "Erreur !: " . $e->getMessage() . "<br/>";
	die();
}

$check = $db->prepare("
						SELECT c.*, u.login 
						FROM camagru_jgengo.comment as c 
						INNER JOIN camagru_jgengo.user as u 
						ON c.owner_id = u.id 
						WHERE c.id = :id
					");

$check->bindValue(':id', $_POST['id']);
$check->execute();
$user = $check->fetchAll();

if ($user[0]['login'] != $_SESSION['login'])
	die("you're not allowed to delete others pictures!");

$del_pic = $db->prepare("DELETE FROM camagru_jgengo.comment WHERE id = :id");
$del_pic->bindValue(':id', $_POST['id']);
$del_pic->execute();
die('ok');

?>