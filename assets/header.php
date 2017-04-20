<header>
	<h1 class='title'>Camagru</h1>
	<ul class='navbar'>
		<li><a href='.'>Home</a></li>
		<?php 
		if (is_logged()) {
			echo "<li><a href='?p=cam'>Take a pic</a></li>";
			echo "<li><a href='#'>Gallery</a></li>";
		}
		if (is_admin())
		{
			echo "<li id='admin'><a href='?p=admin'>Admin</a></li>";
		}
		?>
	</ul>
</header>