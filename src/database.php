<?php

$link = mysqli_connect($_SERVER['SERVER_ADDR'],'pravuser','2FUFZqQN53UzE9xF','pravozastosuv');

if(mysqli_connect_errno()) {
    // echo "Помилка з'єднання з базою данних(".mysqli_connect_errno()."): ".mysqli_connect_error();
    exit();
}

?>