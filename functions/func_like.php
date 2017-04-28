<?php

session_start();
require ('../config/database.php');

if (!isset($_POST['id']))
	$error = "missing some fields, did you try to edit my html?";
if (!isset($error) && (strlen($_POST['id']) == 0))
	$error = "fieds badly filled";


if (!isset($error))
{
	try
	{
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
	    $error = "Erreur !: " . $e->getMessage() . "<br/>";
	    die($error);
	}
}

if (!isset($error))
{
	$check = $db->prepare("SELECT * FROM camagru_jgengo.like WHERE (pic_id = :id AND owner_id = :sessionid)");
	$arr = array(
		":id" => $_POST['id'],
		":sessionid" => $_SESSION['id']
		);
	$check->execute($arr);
	$liked = count($check->fetchAll());
}

if (isset($error))
	die ($error);

if (!isset($error))
{
	if ($liked == 0)
	{
		$insert = $db->prepare('INSERT INTO camagru_jgengo.like (owner_id, pic_id, created_at) VALUES (:owner_id, :pic_id, :created_at)');
		$arr = array(
			":owner_id" => $_SESSION['id'],
			":pic_id" => $_POST['id'],
			":created_at" => date('Y-m-d')
		);
		$insert->execute($arr);
		die ("add done");
	}
	else 
	{
		$del_pic = $db->prepare("DELETE FROM camagru_jgengo.like WHERE (pic_id = :id AND owner_id = :owner_id)");
		$arr = array(
			":id" => $_POST['id'],
			":owner_id" => $_SESSION['id']
			);
		$del_pic->execute($arr);
		die ("delete: done");
	}
}
die ("?");

// $check->bindValue(':id', $_POST['id']);
// $check->execute();
// $user = $check->fetchAll();

// if ($user[0]['login'] != $_SESSION['login'])
// 	$error = "you're not allowed to delete others pictures!";

// if (isset($error))
// 	die($error);

// $del_pic = $db->prepare("DELETE FROM camagru_jgengo.pic WHERE id = :id");
// $del_pic->bindValue(':id', $_POST['id']);
// $del_pic->execute();

?>