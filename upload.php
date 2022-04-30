<?php
    define('ROOT_DIR', dirname(dirname(__FILE__)));
	require_once(ROOT_DIR.'/htdocs/function.php');
?>

<?php
    if(!isLoggedIn() || userIdentity() != 'general'){
        redirectTo('signIn.php');
    }
    if(!isset($_POST["submit"])){
        redirectTo('signIn.php');
    }
    $token = filter_input(INPUT_POST, 'new_token', FILTER_SANITIZE_STRING);
    if (!$token || $token !== $_SESSION['new_token']) {
        redirectTo('signIn.php');
    }
    $imageFileType = array("jpeg", "jpg", "gif", "png");
    if(isset($_POST["profileUrl"])){
        $profileUrl = htmlspecialchars($_POST["profileUrl"], ENT_QUOTES, 'UTF-8');
        $fileType = pathinfo($profileUrl)['extension'];
        if(!in_array($fileType, $imageFileType) || !exif_imagetype($_POST["profileUrl"])){
            redirectTo('profile.php');
        }
        unlink(userProfile()['profile_photo']);
        $targetFile = 'profile' . userAccount() . '_' . randomString(10) . '.' . $fileType;
        file_put_contents($targetFile, file_get_contents(profileUrl));
        changeProfile($targetFile);
        redirectTo('profile.php');
    }
    else if($_FILES['profileImage']){
        $fileName = htmlspecialchars($_FILES['profileImage']['name'], ENT_QUOTES, 'UTF-8');
        $fileType = substr($fileName, strrpos($fileName, '.')+1);
        if(!in_array($fileType, $imageFileType)){
            redirectTo('profile.php');
        }
        unlink(userProfile()['profile_photo']);
        $targetFile = 'profile' . userAccount() . '_' . randomString(10) . '.' . $fileType;
        //$check = getimagesize($_FILES["image"]["tmp_name"]);
        move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile);
        changeProfile($targetFile);
        redirectTo('profile.php');
    }
    else if($_FILES['attachedFile']){
        $postId = addPost($_POST['content'], date('Y-m-d H:i:s'));
        $fileName = htmlspecialchars($_FILES['attachedFile']['name'], ENT_QUOTES, 'UTF-8');
        if(!$fileName){
            redirectTo('bulletin.php');
        }
        $fileType = substr($fileName, strrpos($fileName, '.')+1);
        $targetFile = 'post' . $postId . '_' . randomString(10) . '.' . $fileType;
        move_uploaded_file($_FILES['attachedFile']['tmp_name'], $targetFile);
        addPostFile($postId, $targetFile . '.zip');
        //exec('tar zcvf ' . $targetFile . '.tar.gz .');
        $zip = new ZipArchive;
        $zip->open($targetFile . '.zip', ZipArchive::CREATE);
        $zip->addFile($targetFile);
        $zip->close();
        unlink($targetFile);
        redirectTo('bulletin.php');
    }
?>


