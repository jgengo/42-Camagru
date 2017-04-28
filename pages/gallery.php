<?php

require ('config/database.php');

if (is_logged())
{
    try
    {
    	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // to get an exception when caught an error :)
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }

    if (!isset($_GET['id']))
    {
        $find_pic = $db->prepare("
    							SELECT p.*, u.login, count(l.pic_id) as likes
    							FROM camagru_jgengo.pic as p
    							LEFT JOIN camagru_jgengo.user as u ON p.owner_id = u.id
    							LEFT JOIN camagru_jgengo.like as l ON l.pic_id = p.id
    							GROUP BY p.id
    							ORDER BY p.id DESC;
    						");
        $arr = array(
        	":my_id" => $_SESSION['id']
        	);
        $find_pic->execute($arr);
        $pics = $find_pic->fetchAll();
        $find_pic = $db->prepare("
                                SELECT p.*, u.login, count(c.pic_id) as comments
                                FROM camagru_jgengo.pic as p
                                LEFT JOIN camagru_jgengo.user as u ON p.owner_id = u.id
                                LEFT JOIN camagru_jgengo.comment as c ON c.pic_id = p.id
                                GROUP BY p.id
                                ORDER BY p.id DESC;
                            ");
        $arr = array( ":my_id" => $_SESSION['id'] );
        $find_pic->execute($arr);
        $pics2 = $find_pic->fetchAll();

        echo "<h2 id='page_title'>Gallery</h2>";
        echo "<div class='container'>";
        for ($i = 0; $i < count($pics); $i++)
        {
        	echo "
                <div class='vignette'>
                <img class='laphoto' src='images/".$pics[$i]['name']."' />
                <div class='top_vign'><span>".$pics[$i]['likes']." like".( ($pics[$i]['likes'] != 1) ? "s" : "" )."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pics2[$i]['comments']." comment".( ($pics2[$i]['comments'] != 1) ? "s" : "")."</span></div>
                <div class='ownedby' ><span>".$pics[$i]['login']."</span></div>
                <img src='assets/thumb_icon.png' class='thumb' data-id='".$pics[$i]['id']."' />
                <img src='assets/chat.png' class='mess' data-id='".$pics[$i]['id']."' />
                ";
        	if ($pics[$i]['login'] == $_SESSION['login'])
        		echo "<img src='assets/delete_icon2.png' class='delete' data-id='".$pics[$i]['id']."' />";	

        	echo "</div>";
        }
        echo "</div>";
        echo "<script src='assets/gallery.js'></script>";
        } else { // si il y a un &id=
            if (ctype_digit($_GET['id']))
            {
                $find_com = $db->prepare("
                            SELECT c.*, u.login 
                            FROM camagru_jgengo.comment as c
                            LEFT JOIN camagru_jgengo.user as u ON c.owner_id = u.id
                            WHERE c.pic_id = :pic_id
                            ORDER BY c.id ASC;
                ");

                $find_com->bindValue(':pic_id', $_GET['id']);
                $find_com->execute();
                $comments = $find_com->fetchAll();

                echo "<h2 id='page_title'>Comments</h2>";
                
                echo "<div class='comment_container'>
                    <input type='text' id='comment_write' />
                    <p id='count_box'>100 characters left</p>
                    <div id='comment_box'>";
                for ($i = 0; $i < count($comments); $i++)
                {
                    echo "<div class='mess_box'>
                    <p class='login'>".$comments[$i]['login']."</p>
                    <p class='message'>".$comments[$i]['content']."</p>";
                    if ($comments[$i]['login'] == $_SESSION['login'])
                        echo "<img src='assets/delete2.png' class='delete' data-id='".$comments[$i]['id']."' />";  
                    echo "</div>";
                }
                echo "</div></div>";
                echo "<script src='assets/gallery_mess.js'></script>";
            }
        else // si le &id= est pas numerique
            echo "<script>alert('What are you trying?'); window.location.href=".";</script>";
    }
} else { // si le mec est pas logged
  include("assets/forbidden.html");
}
?>