<?php
    define('ROOT_DIR', dirname(dirname(__FILE__)));
	require_once(ROOT_DIR.'/htdocs/function.php');
?>

<?php
    if (isLoggedIn()) {
        if(userIdentity() == "general"){
            redirectTo('bulletin.php');
        }
        if(userIdentity() == "admin"){
            redirectTo('admin.php');
        }
    }
    if (isset($_POST['signUp'])){
        $account = htmlspecialchars($_POST['account'], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
        if(signUp($account, $password)){
            echo "sign up success";
        }
        else{
            echo "this account already exist or invalid, please choose another one";
        }        
    }
    if (isset($_POST['signIn'])){
        $account = htmlspecialchars($_POST['account'], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
        signIn($account, $password);
        echo "account or password invalid, please try again";
    }
?>
<head>
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
</head>
<div class="sign-in-board">
    <div class="center">
        <h3><center>Sign In Page</center></h3>
        <form action="signIn.php" method="post">
            <div style="margin:10px">
                <label>Account<br></label>
                <input style="width:270px" type="text" name="account" autofocus="true"><br>
            </div>
            <div style="margin:10px">
                <label>Password<br></label>
                <input style="width:270px" type="password" name="password"><br>
            </div>
            <button type="submit" name="signIn">sign in</button>
            <button type="submit" name="signUp">sign up</button>
        </form>
    </div>
</div>