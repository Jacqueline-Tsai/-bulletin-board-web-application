<?php
	session_start();
	define('ROOT_DIR', dirname(dirname(__FILE__)));
	require_once(ROOT_DIR.'/htdocs/header.php');
?>

<?php
	if(!isLoggedIn() || userIdentity() != "admin"){
		redirectTo('signIn.php');
	}
	//echo "Admin Page" . "<br/>";
?>

<form class="form" action="editTitle.php" method="post">
    <button type="submit" role="button" name="edit">Edit</button>
</form>
