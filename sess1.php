<?php

session_start();

define('ADMIN', 'admin');

if(!empty($_POST['login']))
{
	if($_POST['login'] === ADMIN)
	{
		$_SESSION['admin'] = ADMIN;
		$_SESSION['res'] = 'Админ здесь!';

	} else {
		$_SESSION['res'] = 'Кто ты чудовище?';
	}

	header("Location: sess1.php");
	die;
}

?>

<?php
	if(isset($_SESSION['res']))
{
	echo $_SESSION['res'];
	unset($_SESSION['res']);
}

?>

<hr>

<form action="" method="post">
	<input type="text" placeholder="input login" name="login">
	<button type="submit">Send</button>
</form>



<ui>
	<li><a href="sess1.php">sess1</a></li>
	<li><a href="sess2.php">sess2</a></li>
	<li><a href="secret.php">secret</a></li>
</ui>