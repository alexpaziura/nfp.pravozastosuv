<?php
session_start();
$format_date = 'd.m.Y';
$for_date_change = 'd.m.Y H:i:s';
$state_add = '';
require_once("src/database.php");
require_once("src/functions.php");
if (!isset($_SESSION['user'])) {
    header('Location:login');
    exit();
}
if (isset($_POST['log_out'])) {
    unset($_SESSION['user']);
    unset($_SESSION['group']);
    unset($_SESSION['full_name']);
    session_destroy();
    header('Location:login');
    exit();
}
if (isset($_POST['add_nag'])) {
    if (add_inspekt()) {
        $state_add = 'success';
    } else {
        $state_add = 'error';
    }
    unset($_POST);
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Правозастосування</title>

    <!-- Bootstrap -->
    <link href="./css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/bootstrap-table.css">
    <link rel="stylesheet" href="./css/table-fixed-header.css">
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="stylesheet" href="./css/jasny-bootstrap.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="./css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/bootstrap-datepicker.css">
    <!-- <link href="css/bootstrap.css" rel="stylesheet">HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body id="body" style="height: 100%;">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- <script src="js/jquery-1.12.4.min.js"></script>-->
<script src="js/jquery-2.1.1.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="./js/bootstrap.js" type="text/javascript"></script>
<script src="./js/bootstrap-table.js" type="text/javascript"></script>
<script src="./js/bootstrap-table-uk-UA.js" type="text/javascript"></script>
<script src="./js/table-fixed-header.js" type="text/javascript"></script>
<script src="extensions/export/bootstrap-table-export.js"></script>
<script src="js/tableExport.js"></script>
<script src="./js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="./js/bootstrap-datepicker.uk.min.js" type="text/javascript"></script>
<script src="./js/jasny-bootstrap.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $("#editBtn").click(function () {
            var $table = $('#table');
            var selection = $table.bootstrapTable('getSelections');
            if (selection.length > 1) {
                $("#modal-ch-multi").modal({backdrop: "static"});
            } else if (selection.length == 1) {
                $("#modal-1").modal({backdrop: "static"});
            } else if (selection.length == 0) {
                $("#modal-ch-0").modal({backdrop: "static"});
            }
        });
        $("#addBtn").click(function () {
            $("#modal-add-naglyad").modal({backdrop: "static"});
        });
        /*$("#modal-add-naglyad").on('show.bs.modal', function () {
         $('.form-control').val('');
         });*/
        $("#modal-1").on('show.bs.modal', function () {
            var $table = $('#table');
            var selection = $table.bootstrapTable('getSelections');
            var selectedRowJS = JSON.stringify(selection[0]);
            var selRow = JSON.parse(selectedRowJS);
            $("#modal-1 #nzp1").val(selRow.nzp);
        });
    });

</script>


<!--<script type="text/javascript">
    $(document).ready(function() {
        $(function(){
            //2. Получить элемент, к которому необходимо добавить маску
            $("#d_start_perevirki").mask("99.99.9999", {placeholder: "дд.мм.рррр" });
            $("#d_end_perevirki").mask("99.99.9999", {placeholder: "дд.мм.рррр" });
        });
    });
</script>-->

<div class="navbar navbar-custom navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a href="/" class="navbar-brand"><i class="fa fa-balance-scale fa-lg"></i> Правозастосування</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="table1">Інспеційна діяльність</a></li>
            <li  class="active"><a href="table2">Інші види діяльності</a></li>
            <li class="<?= $_SESSION['group'] == 'ДеРЗІТ' ? '' : 'hidden' ?>"><a href="cms/">Адміністрування</a></li>
        </ul>
        <form method="post" class="navbar-form navbar-right">
            <div class="form-group">
                <button class="btn btn-danger btn-labeled" type="submit" name="log_out" id="log_out">
                    <span class="btn-label"><i class="fa fa-sign-out fa-lg"></i></span>Вийти
                </button>
            </div>
        </form>
        <p class="navbar-text navbar-right">Ви ввійши, як <?= $_SESSION['full_name'] ?>!</p>
    </div>
</div>
<div class="container-fluid" id="content-body" style="height: 90%">
    <!--<div class="toolbar">
<button id="button" class="btn btn-default">getSelectedRow</button></div>-->
    <div class="row">
        <div class="container">
            <div class="alert alert-success alert-dismissable alert-fixed <?= $state_add == 'success' ? '' : 'hidden' ?>"
                 id="success_add">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close"></i>
                </button>
                <h4>Запис успішно додано!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-danger alert-dismissable alert-fixed <?= $state_add == 'error' ? '' : 'hidden' ?>"
                 id="success_err">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close"></i>
                </button>
                <h4>Виникла помилка при додаванні запису!</h4>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: -20px;">
        <div class="container-fluid">
            <div id="toolbar" class="btn-toolbar">
                <div class="btn-group <?= $_SESSION['group'] != 'ЮР' ? '' : 'hidden' ?>">
                    <button type="button" class="btn btn-success btn-labeled add" id="addBtn">
                        <span class="btn-label"><i class="fa fa-plus fa-lg"></i></span>Додати запис
                    </button>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-warning btn-labeled edit" id="editBtn">
                        <span class="btn-label"><i class="fa fa-pencil fa-lg"></i></span>Редагувати запис
                    </button>
                </div>
                <div class="btn-group <?= $_SESSION['group'] == 'ДеРЗІТ' ? 'hidden' : 'hidden' ?>">
                    <button type="button" class="btn btn-danger btn-labeled" id="delete-row">
                        <span class="btn-label"><i class="fa fa-trash fa-lg"></i></span>Видалити запис
                    </button>
                </div>
            </div>
            <table
                data-toggle="table"
                id="table"
                class="table table-striped table-bordered table-fixed-header table-condensed"
                data-sort-name="Npz"
                data-sort-order="asc"
                data-toolbar="#toolbar"
                data-search="true"
                data-searchOnEnterKey="true"
                data-click-to-select="true"
                data-resizable="true"
                style="background-color: seashell;">
                <thead class="header" style="background-color: seashell;">
                <tr>

                    <th data-field="state" data-checkbox="true" rowspan="4"></th>
                   <!-- <th data-field="id_other" data-sortable="true" rowspan="4" data-halign="center" data-align="center"
                        class="col-xs-1">id_other
                    </th>
                    <th data-field="active" data-sortable="true" rowspan="4" data-halign="center" data-align="center"
                        class="col-xs-1">active
                    </th>
                    <th data-field="date_change" data-sortable="true" rowspan="4" data-halign="center" data-align="center"
                        class="col-xs-1">date_change
                    </th>
                    <th data-field="username" data-sortable="true" rowspan="4" data-halign="center" data-align="center"
                        class="col-xs-1">username
                    </th>-->
                    <th data-field="nzp" data-sortable="true" rowspan="4" data-halign="center" data-align="center"
                        class="col-xs-1">№<br>з/п
                    </th>
                    <th data-field="pidrozdil" data-sortable="true" rowspan="4" data-halign="center" data-align="center"
                        class="col-xs-1">Індекс<br>самостійного<br>структурного<br>підрозділу
                    </th>
                    <th data-field="d_akt" data-sortable="true" rowspan="4" data-halign="center" data-align="center"
                        class="col-xs-1">Дата акту
                    </th>
                    <th data-field="n_akt" data-sortable="true" rowspan="4" data-halign="center" data-align="center"
                        class="col-xs-1">№ акту
                    </th>
                    <th data-field="short_name_fu" class="col-xs-1" data-sortable="true" rowspan="4"
                        data-halign="center" data-align="center">Скорочена <br>назва ФУ
                    </th>
                    <th data-field="edrpo" class="col-xs-1" data-sortable="true" rowspan="4" data-halign="center"
                        data-align="center">Код за ЄДРПОУ ФУ<br>або ІНН або паспорт
                    </th>
                    <th data-field="type_fu" data-sortable="true" rowspan="4" data-halign="center" data-align="center">
                        Тип суб'єкта нагляду
                    </th>
                    <th data-field="id_vid_naglyad" data-sortable="true" rowspan="4" data-halign="center" data-align="center">
                        Індекс виду<br>наглядової діяльності
                    </th>
                    <th colspan="3" data-halign="center" data-align="center">
                        Зупинення провадження у справі
                    </th>
                    <th colspan="3" data-halign="center" data-align="center">
                        Рішення про закриття справи
                    </th>
                    <th colspan="9" data-halign="center" data-align="center">
                        Захід впливу щодо усунення порушень
                    </th>
                    <th colspan="14" data-halign="center" data-align="center">
                        Захід впливу у вигляді штрафної санкції
                    </th>
                    <th colspan="22" data-halign="center" data-align="center">
                        Процедури стягнення у судовому порядку
                    </th>
                    <th data-field="dn_list_dobro_splat" data-sortable="true" rowspan="4" data-halign="center"
                        data-align="center">Дата/№ листа до суб'єкту <br>нагляду про добровільну сплату<br> штрафної
                        санкції (судового<br> збору) за рішенням суду
                    </th>
                    <th colspan="8" data-halign="center" data-align="center">Процедури примусового стягнення за рішенням
                        суду
                    </th>
                    <th colspan="9" data-halign="center" data-align="center">Додатково зібрана інформація</th>
                </tr>
                <tr>
                    <th data-field="d_rozpor" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Дата<br>розпорядження
                    </th>
                    <th data-field="n_rozpor" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">№<br>розпорядження
                    </th>
                    <th data-field="pidstav_zupin" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Підстава для<br>зупинення
                    </th>
                    <th data-field="d_rish_zak" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Дата<br>рішення
                    </th>
                    <th data-field="n_rish_zak" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">№<br>рішення
                    </th>
                    <th data-field="pidstav_zak" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Підстава для<br>закриття справи
                    </th>
                    <th data-field="d_roz_zah" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Дата<br>розпорядження
                    </th>
                    <th data-field="n_roz_zah" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">№<br>розпорядження
                    </th>
                    <th data-field="s_vik_zah" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Строк виконання<br>розпорядження
                    </th>
                    <th data-field="s_povid_zah" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Строк повідомлення<br>про виконення<br>розпорядження
                    </th>
                    <th data-field="klopot_prodov_zah" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Наявність клопотання<br>про продовження строку<br>виконання розпорядження
                        <br>(вх.дата, №)
                    </th>
                    <th data-field="res_klopot_prodov_zah" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Результат розгляду клопотання<br>(якщо так - дата, №РК, новий строк,<br> якщо ні - вих.№, дата листа)
                    </th>
                    <th data-field="info_vik_zah" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Інформація про<br>виконання розпорядження
                    </th>
                    <th data-field="d_dov_vik_zah" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Дата Довідки про<br>виконання розпорядження
                    </th>
                    <th data-field="dn_akt_nevik_zah" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Акт у разі<br>невиконання вимог<br>розпорядження<br>(дата, №)
                    </th>
                    <th data-field="d_post_shtraf" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Дата<br>постанови<br>про штраф
                    </th>
                    <th data-field="n_post_shtraf" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">№ постанови<br>про штраф
                    </th>
                    <th data-field="sum_shtraf" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Сума<br>штрафу,<br>грн
                    </th>
                    <th data-field="s_splat_shtraf" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Строк<br>сплати<br>штрафу
                    </th>
                    <th data-field="oscar_postan_nkfp" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Оскарження постанови<br>до НКФП (вх. дата<br>надходження скарги)
                    </th>
                    <th data-field="res_roz_scar" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Результати розгладу<br>скарги (зміст)
                    </th>
                    <th colspan="2" data-halign="center" data-align="center">
                        Розпорядження Комісії
                    </th>
                    <th data-field="d_new_roz" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Дата нового<br>розгляду
                    </th>
                    <th data-field="rish_new_roz" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Рішення, прийняте за<br>результатами нового розгляду
                    </th>
                    <th data-field="info_splat_shtraf" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Інформація про<br>сплату штрафу<br>(дата сплати <br>по платужному дорученню)
                    </th>
                    <th data-field="info_usun_porush" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Інформація про<br>усунення порушення,<br>за яке застосованна<br>штрафна санкція
                    </th>
                    <th data-field="d_dov_vik_shtraf" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Дата Довідки про<br>виконення постанови
                    </th>
                    <th data-field="dn_sluj_ur_shtraf" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Дата/№ служ.записки<br>до ЮрДеп щодо стягнення<br>штрафної санкції у<br>судовому порядку
                    </th>
                    <th data-field="sluj_perep_sud_zbir" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Службова переписка щодо сплати судового збору<br>(дата/№ службової записки)
                        (фіксується подання на<br>сплату - повернення з  причинами про неможливість<br> сплати - повторне подання, інше)
                    </th>
                    <th data-field="dn_splat_sud_zbir" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Дата/№ документу<br>(платіжного доручення)<br>про сплату<br>судового збору
                    </th>
                    <th data-field="dn_sluj_pozov" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Дата/№ служ.записки<br>щодо направлення<br>матеріалів для подання<br>позовної заяви
                    </th>
                    <th data-field="name_sud_dn_pz" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Назва суду, дата/№<br>позовної заяви про<br>стягнення штрафної санкції
                    </th>
                    <th colspan="15" data-halign="center" data-align="center">Судовий розгляд</th>
                    <th colspan="3" data-halign="center" data-align="center">Інформація щодо розподілу судових витрат
                    </th>
                    <th data-field="shtraf_splach_dobro" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Штрафна санкція сплачена <br>добровільно за рішенням суду<br>(№п/д, дата,
                        сума)
                    </th>
                    <th data-field="dn_sluj_primus" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Дата/№ службової<br>записки щодо необхідності<br>примусового виконання<br>рішення
                        суду
                    </th>
                    <th data-field="dn_lz_vikon_list" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Подано до суду лист-заяву<br>про видачу виконавчого<br>листа (дата/№)
                    </th>
                    <th data-field="dn_otrum_vikon_list" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Дата отримання/<br>вх.№ Нацкомфінпослуг<br>виконавчого листа
                    </th>
                    <th colspan="4" data-halign="center" data-align="center">органами ДВС в рамках ВП</th>
                    <th data-field="primitka_dod" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Примітки
                    </th>
                    <th data-field="napr_zap_derjrei" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Направлено запит до <br>держреєстра на встановлення <br>місцезнаходження
                    </th>
                    <th data-field="napr_zap_dfs" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Направлено запит до <br>органів ДФС щодо<br>здійснення
                        фінансово-господарської<br>діяльності та пов'язаних осіб
                    </th>
                    <th data-field="napr_zai_police" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Направлено запит до <br>органів національної поліції<br>про ухилення від
                        виконання<br>рішення суду
                    </th>
                    <th data-field="napr_info_bank" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Направлено інформацію до<br>банківських установ про<br>наявність несплачених<br>штрафних
                        санкцій
                    </th>
                    <th data-field="napr_info_zasn" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Направлено інформацію до<br>засновників та посадових осіб про<br>наявність
                        несплаченої<br>штрафної санкції
                    </th>
                    <th data-field="napr_info_prokuror" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Направлено інформацію до<br>органів прокуратури про<br>наявність несплаченої<br>штрафної
                        санкції
                    </th>
                    <th data-field="napr_info_oms" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Направлено інформацію до<br>органів місцевого самоврядування про<br>наявність
                        несплаченої<br>штрафної санкції
                    </th>
                    <th data-field="napr_info_dfs" data-sortable="true" rowspan="3" data-halign="center"
                        data-align="center">Направлено інформацію до<br>органів ДФС про<br>наявність несплаченої<br>штрафної
                        санкції
                    </th>
                </tr>
                <tr>
                    <th data-field="d_rozp_com" data-sortable="true" rowspan="2" data-halign="center"
                        data-align="center">Дата
                    </th>
                    <th data-field="n_rozp_com" data-sortable="true" rowspan="2" data-halign="center"
                        data-align="center">№
                    </th>
                    <th colspan="2" data-halign="center" data-align="center">Відкриття окружним адміністративним
                        судом<br> провадження за позовною заявою
                    </th>
                    <th colspan="2" data-halign="center" data-align="center">Результат розгляду окружним <br>адміністративним
                        судом
                    </th>
                    <th data-field="name_apel_sud" data-sortable="true" rowspan="2" data-halign="center"
                        data-align="center">Назва апеляційного<br>адміністративного суду,<br>дата/№ апецяційної скарги
                    </th>
                    <th colspan="2" data-halign="center" data-align="center">Прийняття апеляційної<br>скарги до розгляду
                    </th>
                    <th colspan="2" data-halign="center" data-align="center">Результат розгляду апеляційним<br>адміністративним
                        судом
                    </th>
                    <th data-field="dn_kasac_scar" data-sortable="true" rowspan="2" data-halign="center"
                        data-align="center">Дата/№<br>касаційної<br>скарги
                    </th>
                    <th colspan="2" data-halign="center" data-align="center">Прийняття касаційної<br>скарги до розгляду
                    </th>
                    <th colspan="2" data-halign="center" data-align="center">Результат розгляду Вищим
                        адміністративним<br> судом/ Верховним судом
                    </th>
                    <th data-field="primitka_sud_roz" data-sortable="true" rowspan="2" data-halign="center"
                        data-align="center">Примітки
                    </th>
                    <th data-field="splach_sud_zbir" data-sortable="true" rowspan="2" data-halign="center"
                        data-align="center">Сплачено та/або застосовано<br> звільнення, розстрочення(відстрочення)<br>
                        сплати судового збору
                    </th>
                    <th data-field="poklad_sud_zbir" data-sortable="true" rowspan="2" data-halign="center"
                        data-align="center">Покладено сплату<br>судового збору на<br>позивача/відповідача
                    </th>
                    <th data-field="povern_sud_zbir" data-sortable="true" rowspan="2" data-halign="center"
                        data-align="center">Повернуто судовий збір <br>за рішенням суду до бюджету<br>(№п/д, дата, сума)
                    </th>
                    <th data-field="dn_napr_list_dvs" data-sortable="true" rowspan="2" data-halign="center"
                        data-align="center">Направлено виконавчий<br>лист до органів ДВС<br>(№/дата листа)
                    </th>
                    <th data-field="dn_rekv_otk_vp" data-sortable="true" rowspan="2" data-halign="center"
                        data-align="center">Реквізити Постанови про<br>розпочате ВП<br>(дата/вх.№ Нацкомфінпослуг)
                    </th>
                    <th data-field="short_opis_zah_dvs" data-sortable="true" rowspan="2" data-halign="center"
                        data-align="center">Заходи здійсненні органами<br>ДВС в рамках ВП<br>(короткий опис)
                    </th>
                    <th data-field="dn_rekv_zak_vp" data-sortable="true" rowspan="2" data-halign="center"
                        data-align="center">Реквізити Постанови про<br>закриття ВП/повернення<br>виконавчого листа<br>(дата/вх.№
                        Нацкомфінпослуг)
                    </th>
                </tr>
                <tr>
                    <th data-field="n_sud_sprav" data-sortable="true" data-halign="center" data-align="center">№ судової
                        справи/<br>вхі.№<br>Нацкомфінпослуг
                    </th>
                    <th data-field="d_sud_rish" data-sortable="true" data-halign="center" data-align="center">Дата
                        судового рішення/<br>дата за вх.№<br>Нацкомфінпослуг
                    </th>
                    <th data-field="d_sud_rish_ros" data-sortable="true" data-halign="center" data-align="center">Дата
                        судового рішення/<br>дата за вх.№<br>Нацкомфінпослуг
                    </th>
                    <th data-field="short_zm_rish" data-sortable="true" data-halign="center" data-align="center"
                        class="col-xs-1">Короткий зміст рішення
                    </th>
                    <th data-field="n_ssprav_apel" data-sortable="true" data-halign="center" data-align="center">№
                        судової справи/<br>вхі.№<br>Нацкомфінпослуг
                    </th>
                    <th data-field="d_srish_apel" data-sortable="true" data-halign="center" data-align="center">Дата
                        судового рішення/<br>дата за вх.№<br>Нацкомфінпослуг
                    </th>
                    <th data-field="d_res_srish_apel" data-sortable="true" data-halign="center" data-align="center">Дата
                        судового рішення/<br>дата за вх.№<br>Нацкомфінпослуг
                    </th>
                    <th data-field="short_zm_rish_apel" data-sortable="true" data-halign="center" data-align="center"
                        class="col-xs-1">Короткий зміст рішення
                    </th>
                    <th data-field="n_sprav_kasac" data-sortable="true" data-halign="center" data-align="center">№
                        судової справи/<br>вхі.№<br>Нацкомфінпослуг
                    </th>
                    <th data-field="d_rish_kasac" data-sortable="true" data-halign="center" data-align="center">Дата
                        судового рішення/<br>дата за вх.№<br>Нацкомфінпослуг
                    </th>
                    <th data-field="d_rish_res_kasac" data-sortable="true" data-halign="center" data-align="center">Дата
                        судового рішення/<br>дата за вх.№<br>Нацкомфінпослуг
                    </th>
                    <th data-field="short_zm_rish_kasac" data-sortable="true" data-halign="center" data-align="center"
                        class="col-xs-1">Короткий зміст рішення
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


</div>
<div class="modal" id="modal-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button class="close" type="button" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button>
                <h2 class="modal-title"><i class="fa fa-pencil"></i> &nbsp;&nbsp;Редагування запису</h2>
            </div>
            <div class="modal-body">
                <input type="text" name="nzp" id="nzp1">
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="button" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-ch-0">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header modal-header-warning">
                <button class="close" type="button" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button>
                <h2 class="modal-title"><i class="fa fa-warning"></i> &nbsp;&nbsp;Не вибрано запис для редагування.</h2>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-ch-multi">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header modal-header-warning">
                <button class="close" type="button" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button>
                <h2 class="modal-title"><i class="fa fa-warning"></i> &nbsp;&nbsp;Вибрано більше одного запису для
                    редагування.</h2>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-progress">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header modal-header-warning">
                <div class="progress">
                    <div class="progress-bar progress-bar-success progress-bar-striped active"
                         style="width:100%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'modal_add_naglyad.php'; ?>
<script src="js/form-add.js"></script>
<script>
    //var height_table = $('body').height() - 80;
   //$("#table").attr("data-height", height_table.toString());
    $('#table').bootstrapTable('resetView');
    /*$("#table").on('click-row.bs.table', function (e, row, $element) {
     var classColor = 'success';
     if($($element).hasClass(classColor)) {
     $($element).removeClass(classColor);
     } else {
     $($element).addClass(classColor);
     }
     });*/
</script>
<script>
    setTimeout(function () {
        $('#success_add').alert("close");
        $('#success_err').alert("close");
    }, 7000);
</script>

<!--<script>
    $(document).ready(function(){
    var select;
    $('#table')
        .on('dbl-click-row.bs.table', function (e, row, $element) {
            $("#modal-1").modal({backdrop: "static"});
        });
    });
</script>-->
</body>

</html>