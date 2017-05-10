<?php
require_once("src/database.php");
require_once("src/functions.php");
if (isset($_POST['id_inst_row'])) {
    echo get_row_inspect($_POST['id_inst_row']);
}