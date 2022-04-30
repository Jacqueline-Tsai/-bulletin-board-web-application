<?php
    session_start();
    define('ROOT_DIR', dirname(dirname(__FILE__)));
    require_once(ROOT_DIR.'/htdocs/function.php');
?>

<?php
    signOut();
?>
