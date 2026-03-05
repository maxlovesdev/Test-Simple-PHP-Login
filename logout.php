<?php 
 $past = time() - 3600; 
 setcookie('ID_your_site', '', $past); 
 setcookie('Key_your_site', '', $past); 
 header("Location: login.php"); 
 ?> 
