<?php
session_start();
require_once("database.php");
require_once("functions.php");
$answer["state"] = "";
if (isset($_POST["table"]) && $_POST["table"] === 'inspekt') {
    if (add_inspekt()) {
        $answer["state"] = 'success';
    } else {
        $answer["state"] = 'error';
    }
    $_SESSION['action_time'] = microtime(true);
    $page = intval(get_page_row_inspekt($_POST["nzp"]));
    /*if (!is_int($page)) {
        $page = 1;
    }*/

    echo "{\"state\":\"".$answer["state"]."\", \"page\":\"".$page."\"}";

}
?>


