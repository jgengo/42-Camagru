<?php

require_once('config/database.php');

try
{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // to get an exception when caught an error :)
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}


$find_user = $db->prepare("SELECT * FROM camagru_jgengo.user WHERE validate_link = :validate_link");
$find_user->bindValue(':validate_link', $_GET['hash']);
$find_user->execute();
$user = $find_user->fetch();

if (isset($user['id']))
{
 $valid_link = $db->prepare("UPDATE camagru_jgengo.user SET validate_link = '1' WHERE user.id = :user_id;");
 $valid_link->bindValue(':user_id', $user['id']);
 $valid_link->execute();
 mail($user['email'], "[Camagru] Account validated", "Hey ".$user['login'].", Your account has been activated!");
 echo "<script>alert('account validated'); window.location.href='.';</script>";
} else {
	echo "not valid hash";
}


//UPDATE `user` SET `validate_link` = '1' WHERE `user`.`id` = 4;

?>