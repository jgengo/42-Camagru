<?php

parse_str(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY), $query);

if (!isset($_POST['comm']))
	die("what are you trying?");
else if (strlen($_POST['comm']) > 100)
	die("too big");

require_once('../config/database.php');
session_start();

$pic_id = isset($query['id']) && is_numeric($query['id'])? $query['id'] : 0;

try
{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die($e->getMessage());
}
$insert = $db->prepare('INSERT INTO camagru_jgengo.comment (owner_id, pic_id, content) VALUES (:owner_id, :pic_id, :comm)');
$arr = array(
	":owner_id" => $_SESSION['id'],
	":pic_id" => $pic_id,
	":comm" => htmlentities($_POST['comm'])
);
$insert->execute($arr);
die('ok');
?>