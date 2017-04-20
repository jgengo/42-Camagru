<?php
require_once('config/config.php');

require_once('assets/head.php');

require_once('assets/header.php'); 

?>

<div class="wrapper">
<article>

<?php
if (isset($_GET['p']) && in_array($_GET['p'], $authorized_pages))
{
	include_once('pages/'.$_GET['p'].'.php');
}
?>

</article>

<?php 
require_once('assets/aside.php'); 
?>

</div> <!-- wrapper -->
<footer>
made by <a href='https://www.linkedin.com/in/jordane-gengo-388626137/'>jgengo</a>
</footer>
</body>
</html>

