<?php
	error_reporting(E_ERROR | E_PARSE);
    session_start();
    define('ROOT_DIR', dirname(dirname(__FILE__)));
?>
<?php
    $config = parse_ini_file(ROOT_DIR.'/htdocs/config.ini');
    $mysqli = new mysqli($config['db_addr'], $config['db_user'], $config['db_pass'], $config['db_name']);
    $mysqli -> set_charset("UTF8");
    function redirectTo($href){
        header("Location: {$href}");
        exit;
    }
    function signUp($account, $password) {        
        $result = $GLOBALS['mysqli'] -> query("select * from `user` where `account` = '" . $account . "'");
        if($result -> num_rows == 0){
            $GLOBALS['mysqli'] -> query("insert into `user` values('" . $account . "', '" . $password . "', 'general', '')");
            return true;
        }
        return false;
    }
    function signIn($account, $password) {
        $result = $GLOBALS['mysqli'] -> query("select `password`, `identity` from `user` where `account` = '" . $account . "'");
        if($result -> num_rows == 1){
            $row = $result -> fetch_array(MYSQLI_ASSOC);
            if($row['password'] == $password){
                $_SESSION['user_account'] = $account;
                $_SESSION['user_identity'] = $row['identity'];
                redirectTo('signIn.php');
            }            
        }
    }
    function signOut() {
        unset($_SESSION['user_account']);
        unset($_SESSION['user_identity']);
        redirectTo('signIn.php');
    }
    function isLoggedIn() {
        return isset($_SESSION['user_account']);
    }
    function userAccount(){
        return isLoggedIn()? $_SESSION['user_account'] : '';
    }
    function userIdentity(){
        return isLoggedIn()? $_SESSION['user_identity'] : '';
    }
    function changeProfile($profile){
        $GLOBALS['mysqli'] -> query("update `user` set `profile_photo` = '" . $profile . "' where `account` = '" . userAccount() . "'");
    }
    function userProfile(){
        $result = $GLOBALS['mysqli'] -> query("select `profile_photo` from `user` where account = '" . userAccount() . "'");
        return $result->fetch_assoc();
    }
    function allPost(){
        $result = $GLOBALS['mysqli'] -> query("select * from `post` order by time desc");
        while ($row = $result->fetch_assoc()){
            $output[] = $row;
        }
        return $output;
    }
    function postById($id){
        $result = $GLOBALS['mysqli'] -> query("select * from `post` where id = " . $id);
        return $result->fetch_assoc();
    }
    function addPost($content, $time){
        $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
        $GLOBALS['mysqli'] -> query("insert into `post`(content, time, author_account, attached_file) values('" . $content . "', '" . $time . "', '" . userAccount() . "', '')");
        return $GLOBALS['mysqli'] -> insert_id;
    }
    function addPostFile($id, $file){
        $GLOBALS['mysqli'] -> query("update `post` set attached_file = '" . $file . "' where id = " . $id);
    }
    function deletePost($id){
        $result = $GLOBALS['mysqli'] -> query("select attached_file from `post` where id = " . $id);
        unlink($result->fetch_assoc()['attached_file']);
        $GLOBALS['mysqli'] -> query("delete from `post` where id = " . $id);
    }
    function adminPageTitle(){
        $result = $GLOBALS['mysqli'] -> query("select `title` from `admin_page`");
        return $result -> fetch_array(MYSQLI_ASSOC)['title'];
    }
    function saveAdminTitle($title){
        $GLOBALS['mysqli'] -> query("update `admin_page` set `title` = '" . $title . "'");
    }
    function replaceBBcodes($text) {
    	$text = strip_tags($text);
		$find = array(
			'~\[b\](.*?)\[/b\]~s',
			'~\[i\](.*?)\[/i\]~s',
			'~\[u\](.*?)\[/u\]~s',
			'~\[color=([^"><]*?)\](.*?)\[/color\]~s',
			'~\[img\](https?://[^"><]*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
		);
		$replace = array(
			'<b>$1</b>',
			'<i>$1</i>',
			'<span style="text-decoration:underline;">$1</span>',
			'<span style="color:$1;">$2</span>',
			'<img style="max-height:200px; max-width:200px;" src="$1" alt="" />'
		);
		return preg_replace($find, $replace, $text);
	}
    function randomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    function newSessionToken(){
        if(isset($_SESSION['sessiontoken'])){
            destroySessionToken();
        }
        $_SESSION['sessiontoken'] = md5(uniqid());
    }
    function destroySessionToken(){
        unset( $_SESSION['sessiontoken']);
    }
?>