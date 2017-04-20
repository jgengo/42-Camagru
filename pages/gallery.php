<?php

require ('../config/database.php');

try
{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // to get an exception when caught an error :)
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

$find_pic = $db->prepare("SELECT * FROM camagru_jgengo.pic ORDER BY id DESC");
$find_pic->execute();
$pics = $find_pic->fetchAll();

// die(print_r($pics));

echo "<div class='container'>";
for ($i = 0; $i <= 20; $i++)
{
	echo "
	<div class='vignette' style='background-image: url(images/".$pics[$i]['name'].");'>
	<span class='delete'>X</span>
	</div>";
}
echo "</div>";
?>

<script>
var lists = document.querySelectorAll(".delete"), 
    doSomething = function() {
        this.parentNode.style.display = 'none';
        alert('test');
    };
[].map.call(lists, function(elem) {
    elem.addEventListener("click", doSomething, false);
});
</script>