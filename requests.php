<?php
require_once("src/database.php");
require_once("src/functions.php");
if(isset($_GET["table"]) && $_GET["table"] === 'type_fu') {
    $table_type_fu = get_dic('dic_type_fu');
    //echo json_encode($table_type_fu);
?>
    [
    <?php
    $i = 0;
    foreach ($table_type_fu as $row):
        if ($row['visible'] == '0') continue; ?>
        {
            "id_type": "<?= $row['id_type_fu'] ?>",
            "name_type": "<?= $row['name_type_fu']?>"
        },
    <?php
    $i++;
    endforeach;?>
    ]
<?php }?>