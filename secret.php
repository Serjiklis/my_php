<?php
session_start();

if(isset($_GET['do']) && $_GET['do'] == 'exit') unset($_SESSION['admin']);

if(!isset($_SESSION['admin']) ) die('У вас нет доступа');

echo "Добро пожаловать, {$_SESSION['admin']} <br>";

echo session_id();

echo '<pre>';
echo print_r($_SESSION);
echo '</pre>';
?>

<a href="secret.php?do=exit">Logout</a>
<ui>
	<li><a href="sess1.php">sess1</a></li>
	<li><a href="sess2.php">sess2</a></li>
	<li><a href="secret.php">secret</a></li>
</ui>