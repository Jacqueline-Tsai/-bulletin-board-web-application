<?php
	session_start();
	define('ROOT_DIR', dirname(dirname(__FILE__)));
	require_once(ROOT_DIR.'/htdocs/function.php');
	require_once(ROOT_DIR.'/htdocs/header.php');
?>

<?php
	if(!isLoggedIn() || userIdentity() != "admin"){
		redirectTo('signIn.php');
	}
    $title = adminPageTitle();
    //echo $_POST['title'];
    //echo implode("|",$_POST);
    if (isset($_POST['save'])){
        $new_title = htmlspecialchars($_POST['title']);
        var_dump($new_title);
        saveAdminTitle($new_title);
        redirectTo('admin.php');
    }
?>



<form class="form" action="editTitle.php" method="post">
    <input type="text" name="title" autofocus="true" value="<?php echo $title; ?>">
    <button type="submit" role="button" name="save">Save</button>
</form>