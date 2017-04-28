<?php

require_once('../config/database.php');
session_start();

$name = time().".png";
$path = "../images/";
$img = $_POST['pic'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$pic = base64_decode($img);


// $png = imagecreatefrompng('../filters/Happy_face.png');
// $jpeg = imagecreatefrompng($path.$name);

// list($width, $height) = getimagesize($pic);
// // list($newwidth, $newheight) = getimagesize('../filters/Happy_face.png');
// // $out = imagecreatetruecolor($newwidth, $newheight);
// // imagecopyresampled($out, $jpeg, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
// // imagecopyresampled($out, $png, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);
// // imagejpeg($out, 'out.jpg', 100);

//     //allows the transparency of the clipart over the image
// imagealphablending($jpeg, true);
// imagesavealpha($jpeg, true);
// // superimposes clipart onto the original
// imagecopy($jpeg, $png, 0, 0, 0, 0, $width, $height);
// // writing new image to temp file
// imagepng($jpeg, "temp.png");


if (!file_exists($path.$name))
	file_put_contents($path.$name, $pic);

try
{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error = $e->getMessage();
}
$insert = $db->prepare('INSERT INTO camagru_jgengo.pic (name, owner_id, created_at) VALUES (:name, :owner_id, :created_at)');
$arr = array(
	":name" => $name,
	":owner_id" => $_SESSION['id'],
	":created_at" => date('Y-m-d')
);
$insert->execute($arr);

?>