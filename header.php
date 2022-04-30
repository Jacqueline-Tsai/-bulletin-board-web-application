<?php
	require_once(ROOT_DIR.'/htdocs/function.php');
?>

<?php
    $title = adminPageTitle();
?>

<head>
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
</head>

<div class="header">
    <h2 style="display:inline-block;">[ <?php echo $title; ?> ] Only Admin Can Modify. Please Dont Attack Me. :)  </h2>
    <div style="display:inline-block; margin-top:2%" class="right">
        <form style="display:inline-block" action="profile.php">
            <button type="submit" role="button" name="logout">Profile</button>
        </form>
        <form style="display:inline-block" action="signOut.php" method="post">
            <button type="submit" role="button" name="logout">Log out</button>
        </form>
    </div>
</div>

