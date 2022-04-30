<?php
    define('ROOT_DIR', dirname(dirname(__FILE__)));
	require_once(ROOT_DIR.'/htdocs/function.php');
	require_once(ROOT_DIR.'/htdocs/header.php');
    $_SESSION['new_token'] = md5(uniqid(mt_rand(), true));
?>

<?php
    if(!isLoggedIn() || userIdentity() != 'general'){
		redirectTo('signIn.php');
	}
?>

<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="new_token" value="<?php echo $_SESSION['new_token'] ?? '' ?>">
    <input type="text" name="content" autofocus="true">
    <input type="file" name="attachedFile">
    <button type="submit" role="button" name="submit">Submit</button>
</form>
