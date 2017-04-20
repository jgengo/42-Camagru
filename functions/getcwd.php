<?php 

echo getcwd();
echo "<br />";
$keywords = preg_split("/MyWebSite\//", getcwd());
$test = explode('/', $keywords[1]);
print_r($test);
print_r($keywords);

?>