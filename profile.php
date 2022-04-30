<?php
	define('ROOT_DIR', dirname(dirname(__FILE__)));
	require_once(ROOT_DIR.'/htdocs/function.php');
	require_once(ROOT_DIR.'/htdocs/header.php');
    $_SESSION['new_token'] = md5(uniqid(mt_rand(), true));
?>

<?php
	$profile = userProfile()['profile_photo'];
?>

<img src="<?php echo $profile; ?>" style="height:400px">
<div>Change profile photo :</div>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="new_token" value="<?php echo $_SESSION['new_token'] ?? '' ?>">
    <input type="file" accept=".jpg,.jepg,.png,.gif" name="profileImage">
    <button type="submit" role="button" name="submit">Submit</button>
</form>
<form action="upload.php" method="post">
    <input type="hidden" name="new_token" value="<?php echo $_SESSION['new_token'] ?? '' ?>">
    <input type="text" name="profileUrl">
    <button type="submit" role="button" name="submit">Submit</button>
</form>
<!--
<div class="custom-file-upload">
    <div class="file-upload-wrapper">
        <input type="file" class="custom-file-upload-hidden">
        <input type="text" class="file-upload-input">
        <button type="button" class="file-upload-button">Select a File</button>
    </div>
</div>-->
