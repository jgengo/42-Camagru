<link rel="stylesheet" type="text/css" href="../assets/main.css">

<?php

require_once('../config/functions.php');
require_once('../config/database.php');



try
{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // to get an exception when caught an error :)
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

$find_user = $db->prepare("SELECT * FROM camagru_jgengo.user WHERE email = :email");
$find_user->bindValue(':email', $_POST['email']);
$find_user->execute();
$user = $find_user->fetch();

$random = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10);
if (isset($user['id']))
{
 $valid_link = $db->prepare("UPDATE camagru_jgengo.user SET password = :password, pwreset = 1 WHERE user.id = :user_id;");
 $arr = array(
 		":password" => hash_it($random),
 		":user_id" => $user['id']
 	);
 $valid_link->execute($arr);

 mail($user['email'], "[Camagru] new password", "Hey ".$user['login'].", Your new password is: ".$random);
 die("<script>alert('new password sent by mail'); window.location.href='../';</script>");
} else {
	die("<script>alert('email unknown'); window.location.href='../?p=forgot';</script>");
}

?>