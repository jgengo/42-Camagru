<?php

function get_content_from($folder)
{
	return array_map( 
		function($str) { 
			return str_replace('.php', '', $str); },
		array_slice(scandir(ROOT.'/'.$folder), 2)
	);
}

function is_logged()
{
	return (isset($_SESSION['login']));
}

function is_admin()
{
	return ($_SESSION['admin']);
}

function hash_it($plain)
{
	return (hash("SHA256", $plain));
}

function stats_taken()
{
	session_start();
	require_once('database.php');
	try
	{
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // to get an exception when caught an error :)
	} catch (PDOException $e) {
    	print "Erreur !: " . $e->getMessage() . "<br/>";
    	return(0);
		die();
	}
	$count_img = $db->prepare("SELECT COUNT(*) FROM camagru_jgengo.pic WHERE owner_id = :id");
	$count_img->bindValue(':id', $_SESSION['id']);
	$count_img->execute();
	
	$count_comm = $db->prepare("SELECT COUNT(*) FROM camagru_jgengo.comment WHERE owner_id = :id");
	$count_comm->bindValue(':id', $_SESSION['id']);
	$count_comm->execute();

	$count_like = $db->prepare("SELECT COUNT(*) FROM camagru_jgengo.like WHERE owner_id = :id");
	$count_like->bindValue(':id', $_SESSION['id']);
	$count_like->execute();


	return array ($count_img->fetchColumn(), $count_comm->fetchColumn(), $count_like->fetchColumn());
}

?>