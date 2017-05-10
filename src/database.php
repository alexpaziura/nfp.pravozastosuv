<?php

$link = mysqli_connect('10.10.10.21','pravuser','2FUFZqQN53UzE9xF','pravozastosuv');

if(mysqli_connect_errno()) {
    // echo "Помилка з'єднання з базою данних(".mysqli_connect_errno()."): ".mysqli_connect_error();
    exit();
}

?>