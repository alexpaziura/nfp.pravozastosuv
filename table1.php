<?php
session_start();
//error_reporting(E_ERROR);
$format_date = 'd.m.Y';
$for_date_change = 'd.m.Y H:i:s';
$state_add = '';
$state_edit = '';
require_once("src/database.php");
require_once("src/functions.php");
if ((isset($_POST['log_out']))||(!isUserActive())) {
    writeLog('AUTH','LOGOUT',1);
    unset($_SESSION['id_user']);
    unset($_SESSION['user']);
    unset($_SESSION['group']);
    unset($_SESSION['full_name']);
    session_destroy();
    header('Location:login');
    exit();
}
if (!isset($_SESSION['user'])) {
    header('Location:login');
    exit();
}
if (isset($_POST['add_nag'])) {
    if (add_inspekt()) {
        $state_add = 'success';
    } else {
        $state_add = 'error';
    }
    $_SESSION['action_time'] = microtime(true);
    //header ("location: ".$_SERVER['REQUEST_URI']);
}
if (isset($_POST['edit_nag'])) {
    if (edit_nag()) {
        $state_edit = 'success';
    } else {
        $state_edit = 'error';
    }
    $_SESSION['action_time'] = microtime(true);
}
if (isset($_POST['relogin'])) {
    writeLog('AUTH', 'LOGOUT', 1);
    unset($_SESSION['user']);
    unset($_SESSION['group']);
    unset($_SESSION['full_name']);
    unset($_SESSION['action_time']);
    session_destroy();
    header('Location: ../login');
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
    <link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>
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
<script src="js/jquery-ui.min.js"></script>
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
<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
<script>
    $(document).ready(function () {
        $("#editBtn").click(function () {
            var $table = $('#table');
            var selection = $table.bootstrapTable('getSelections');
            if (selection.length > 1) {
                $("#modal-ch-multi").modal({backdrop: "static"});
            } else if (selection.length === 1) {
                $("#modal_edit_n").modal({backdrop: "static"});
                click1e();
            } else if (selection.length === 0) {
                $("#modal-ch-0").modal({backdrop: "static"});
            }
        });
        $("#addBtn").click(function () {
            $("#modal-add-naglyad").modal({backdrop: "static"});
            click1();
        });

    });

</script>

<div class="navbar navbar-custom navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a href="/" class="navbar-brand"><i class="fa fa-balance-scale fa-lg"></i> Правозастосування</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="table1">Інспеційна діяльність</a></li>
            <li><a href="table2">Інші види діяльності</a></li>
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
            <div class="alert alert-success alert-dismissable alert-fixed
            <?php
            if ($state_add == 'success') {
                echo '';
            } else {
                echo 'hidden';
            }
            ?>"
                 id="success_add">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close fa-2x"></i>
                </button>
                <h4>Запис успішно додано!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-danger alert-dismissable alert-fixed <?php
            if ($state_add == 'error') {
                echo '';
            } else {
                echo 'hidden';
            }
            ?>"
                 id="error_add">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close fa-2x"></i>
                </button>
                <h4>Виникла помилка при додаванні запису!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-success alert-dismissable alert-fixed <?= $state_edit == 'success' ? '' : 'hidden' ?>"
                 id="success_edit">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close fa-2x"></i>
                </button>
                <h4>Запис успішно змінено!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-danger alert-dismissable alert-fixed <?= $state_edit == 'error' ? '' : 'hidden' ?>"
                 id="error_edit">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close fa-2x"></i>
                </button>
                <h4>Виникла помилка при редагуванні запису!</h4>
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
                <div class="btn-group <?= $_SESSION['group'] == 'ДеРЗІТ' ? '' : 'hidden' ?>">
                    <button type="button" class="btn btn-danger btn-labeled" id="delete-row">
                        <span class="btn-label"><i class="fa fa-trash fa-lg"></i></span>Видалити запис
                    </button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-default btn-filter btn-labeled">
                        <span class="btn-label"><i class="fa fa-filter fa-lg"></i></span>Фільтрувати
                    </button>
                </div>
            </div>
            <div class="">
                <table
                        data-toggle="table"
                        id="table"
                        class="table table-striped table-bordered table-fixed-header table-condensed"
                        data-sort-name="Npz"
                        data-sort-order="asc"
                        data-toolbar="#toolbar"
                        data-search="true"
                        data-height="850"
                        data-checkbox-header="false"
                        data-searchOnEnterKey="true"
                        data-click-to-select="true"
                        data-resizable="true"
                        style="background-color: seashell;">
                    <thead class="header" style="background-color: seashell;">
                    <tr>

                        <th data-field="state" data-checkbox="true" rowspan="4" data-events="clickCheck"></th>
                        <th data-field="id_inspekt" data-sortable="true" rowspan="4" data-halign="center" data-align="center"
                            class="col-xs-1 hidden">id_inspekt
                        </th>
                        <th data-field="active" data-sortable="true" rowspan="4" data-halign="center" data-align="center"
                            class="col-xs-1">active
                        </th>
                        <th data-field="date_change" data-sortable="true" rowspan="4" data-halign="center" data-align="center"
                            class="col-xs-1">date_change
                        </th>
                        <th data-field="username" data-sortable="true" rowspan="4" data-halign="center" data-align="center"
                            class="col-xs-1">username
                        </th>
                        <th data-field="nzp" data-sortable="true" rowspan="4" data-halign="center" data-align="center"
                            class="col-xs-1">№<br>з/п <br>[1]
                        </th>
                        <th data-field="pidrozdil" data-sortable="true" rowspan="4" data-halign="center" data-align="center"
                            class="col-xs-1">Індекс<br>самостійного<br>структурного<br>підрозділу<br>[2]
                        </th>
                        <th data-field="short_name_fu" class="col-xs-1" data-sortable="true" rowspan="4"
                            data-halign="center" data-align="center">Скорочена <br>назва ФУ<br>[3]
                        </th>
                        <th data-field="edrpo" class="col-xs-1" data-sortable="true" rowspan="4" data-halign="center"
                            data-align="center">Код за ЄДРПОУ ФУ<br>або ІНН або паспорт<br>[4]
                        </th>
                        <th data-field="type_fo" data-sortable="true" rowspan="4" data-halign="center" data-align="center">
                            Тип суб'єкта нагляду<br>[5]
                        </th>
                        <th data-field="vid_perevirki" data-sortable="true" rowspan="4" data-halign="center"
                            data-align="center">Вид перевірки<br>[6]
                        </th>
                        <th data-field="pidstava_pozaplan" data-sortable="true" rowspan="4" data-halign="center"
                            data-align="center">Підстава проведення <br> позапланової перевірки<br>[7]
                        </th>
                        <th colspan="2" data-halign="center" data-align="center">Термін проведення<br> перевірки</th>
                        <th colspan="2" data-halign="center" data-align="center">Період діяльності,<br> що охоплюються
                            перевіркою
                        </th>
                        <th colspan="2" data-halign="center" data-align="center">Наказ про здійснення<br>заходу державного
                            нагляду
                        </th>
                        <th colspan="2" data-halign="center" data-align="center">Направлення (Подання)
                            про<br>проведення перевірки
                        </th>
                        <th colspan="2" data-halign="center" data-align="center">Інспекційна група</th>
                        <th colspan="2" data-halign="center" data-align="center">Акт<br>перевірки</th>
                        <th colspan="3" data-halign="center" data-align="center">Акт, складений відповідно<br>до ЗУ
                            №222-VIII
                        </th>
                        <th colspan="7" data-halign="center" data-align="center">Розпорядження про усунення порушень</th>
                        <th colspan="8" data-halign="center" data-align="center">Постанова про застосування штрафної
                            санкції
                        </th>
                        <th colspan="23" data-halign="center" data-align="center">Процедури стягнення в судовому порядку
                        </th>

                        <th colspan="8" data-halign="center" data-align="center">Процедури примусового стягнення за рішенням
                            суду
                        </th>
                        <th colspan="9" data-halign="center" data-align="center">Додатково зібрана інформація</th>


                    </tr>
                    <tr>
                        <th data-field="d_start_perevirki" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Дата<br> початку<br>[8]
                        </th>
                        <th data-field="d_end_perevirki" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Дата<br> закінчення<br>[9]
                        </th>
                        <th data-field="d_start_dialnist" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Дата<br> початку<br>[10]
                        </th>
                        <th data-field="d_end_dialnist" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Дата<br> закінчення<br>[11]
                        </th>
                        <th data-field="d_nak_zah" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Дата<br>[12]
                        </th>
                        <th data-field="n_nak_zah" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Номер<br>[13]
                        </th>
                        <th data-field="d_napr_proved" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Дата<br>[14]
                        </th>
                        <th data-field="n_napr_proved" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Номер<br>[15]
                        </th>
                        <th data-field="ker_inspekt_group" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">П.І.Б. керівника<br>інспекційної групи<br>[16]
                        </th>
                        <th data-field="ch_inspekt_group" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">П.І.Б. членів<br>інспекційної групи<br>[17]
                        </th>
                        <th data-field="d_akt_perevirki" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Дата<br>[18]
                        </th>
                        <th data-field="n_akt_perevirki" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Номер<br>[19]
                        </th>
                        <th data-field="d_akt_zu" data-sortable="true" rowspan="3" data-halign="center" data-align="center">
                            Дата<br>[20]
                        </th>
                        <th data-field="n_akt_zu" data-sortable="true" rowspan="3" data-halign="center" data-align="center">
                            Номер<br>[21]
                        </th>
                        <th data-field="vid_akt_zu" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Вид акту<br>[22]
                        </th>
                        <th data-field="d_rozp_usun" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Дата<br>[23]
                        </th>
                        <th data-field="n_rozp_usun" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Номер<br>[24]
                        </th>
                        <th data-field="strok_usun_por" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Строки<br>усунення<br>порушення<br>[25]
                        </th>
                        <th data-field="b_usun_lic_umov" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Застосоване розпорядження <br>є розпорядження про усунення <br>порушення
                            ліц.умов<br>[26]
                        </th>
                        <th data-field="info_vik_rozp" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Інформація про<br>виконання розпорядження<br>[27]
                        </th>
                        <th data-field="d_dovidki_vik_rozp" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Дата Довідки про<br>виконання розпорядження<br>[28]
                        </th>
                        <th data-field="dn_akt_nevik" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Акт у разі невиконання<br>вимог розпорядження<br>[29]
                        </th>
                        <th data-field="d_post_shtraf" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Дата постанови<br>про штраф<br>[30]
                        </th>
                        <th data-field="n_post_shtraf" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Номер постанови<br>про штраф<br>[31]
                        </th>
                        <th data-field="suma_shtraf" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Сума<br>штрафу,<br>грн<br>[32]
                        </th>
                        <th data-field="strok_splat_shtraf" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Строк<br>сплати<br>штрафу<br>[33]
                        </th>
                        <th data-field="info_splat_shtraf" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Інформація про<br>сплату штрафу<br>(Дата сплати по<br>платіжному дорученню)
                            <br>[34]
                        </th>
                        <th data-field="info_usun_por" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Інформація про<br>усунення порушення,<br>за яке застосована<br>штрафна
                            санкція<br>[35]
                        </th>
                        <th data-field="d_dovidki_vik_post" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Дата Довідки про<br>виконання постанови<br>[36]
                        </th>
                        <th data-field="dn_sluj_ur" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Дата та номер<br>службової записки<br>до ЮрДеп щодо стягнення<br>штрафної
                            санкції<br>у судовому порядку<br>[37]
                        </th>
                        <th data-field="sluj_perep_splat" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Службова переписка<br>щодо сплати судового збору<br>[38]
                        </th>
                        <th data-field="dn_doc_splat" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Номер документа про<br> сплату судового збору<br>[39]
                        </th>
                        <th data-field="dn_sluj_nap_mat" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Дата/номер службової записки<br> щодо направлення матеріалів<br> для подання
                            позовної заяви<br>[40]
                        </th>
                        <th data-field="name_sud_dn_poz" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Назва суду,дата/номер позовної заяви<br>про стягення штрафної санкції
                        </th>
                        <th colspan="15" data-halign="center" data-align="center">Судовий розгляд</th>
                        <th colspan="3" data-halign="center" data-align="center">Інформація щодо розподілу судових витрат
                        </th>
                        <th data-field="dn_list_dobro_splat" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Дата/№ листа до суб'єкту <br>нагляду про добровільну сплату<br> штрафної
                            санкції (судового<br> збору) за рішенням суду<br>[60]
                        </th>
                        <th data-field="shtraf_splach_dobro" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Штрафна санкція сплачена <br>добровільно за рішенням суду<br>(№п/д, дата,
                            сума)<br>[61]
                        </th>
                        <th data-field="dn_sluj_primus" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Дата/№ службової<br>записки щодо необхідності<br>примусового виконання<br>рішення
                            суду<br>[62]
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
                            <br>[70]
                        </th>
                        <th data-field="napr_zap_dfs" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Направлено запит до <br>органів ДФС щодо<br>здійснення
                            фінансово-господарської<br>діяльності та пов'язаних осіб
                            <br>[71]
                        </th>
                        <th data-field="napr_zai_police" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Направлено запит до <br>органів національної поліції<br>про ухилення від
                            виконання<br>рішення суду
                            <br>[72]
                        </th>
                        <th data-field="napr_info_bank" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Направлено інформацію до<br>банківських установ про<br>наявність несплачених<br>штрафних
                            санкцій<br>[73]
                        </th>
                        <th data-field="napr_info_zasn" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Направлено інформацію до<br>засновників та посадових осіб про<br>наявність
                            несплаченої<br>штрафної санкції<br>[74]
                        </th>
                        <th data-field="napr_info_prokuror" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Направлено інформацію до<br>органів прокуратури про<br>наявність несплаченої<br>штрафної
                            санкції<br>[75]
                        </th>
                        <th data-field="napr_info_oms" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Направлено інформацію до<br>органів місцевого самоврядування про<br>наявність
                            несплаченої<br>штрафної санкції<br>[76]
                        </th>
                        <th data-field="napr_info_dfs" data-sortable="true" rowspan="3" data-halign="center"
                            data-align="center">Направлено інформацію до<br>органів ДФС про<br>наявність несплаченої<br>штрафної
                            санкції<br>[77]
                        </th>
                    </tr>
                    <tr>
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
                            data-align="center">Повернуто судовий збір <br>за рішенням суду до бюджету<br>(№п/д, дата, сума)<br>[59]
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
                    <!--<div id="filt">
                        <tr class="filters">
                            <th></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                            <th><input type="text" class="form-control"></th>
                        </tr>
                    </div>-->

                    </thead>
                    <tbody id="table_body">
                    <?php $table_inspekt = get_table_inspect();
                    $start1 = microtime(true);
                    $table_type_fu = get_dic('dic_type_fu');
                    $table_vid_perevirki = get_dic('dic_vid_perevirki');
                    $table_p = get_dic('dic_pidstava_pozaplan');
                    $table_akt_zu = get_dic('dic_akt_zu');
                    $table_info_vik = get_dic('dic_info_vik');
                    $time1 = microtime(true) - $start1;
                    $start2 = microtime(true);
                    $table_dics = get_dics();
                    $time2 = microtime(true) - $start2;
                    ?>
                    <?php foreach ($table_inspekt as $row): ?>
                        <tr>
                            <td></td>
                            <td class="hidden"><?= $row['id_inspekt'] ?></td>
                            <td><?= $row['active'] ?></td>
                            <td><?= $row['date_change'] == NULL ? '' : date($for_date_change, $row['date_change']) ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['nzp'] ?></td>
                            <td><?= $row['pidrozdil'] ?></td>
                            <td><?= $row['short_name_fu'] ?></td>
                            <td><?= $row['edrpo'] ?></td>
                            <td><?= "<div class='hidden'>".$row['type_fu']."</div>".$row['name_type_fu'] ?></td>
                            <td><?= "<div class='hidden'>".$row['vid_perevirki']."</div>".$row['name_vid_perevirki'] ?></td>
                            <td>
                                <?
                                $pidstavi = $row['pidstava_pozaplan'];
                                $result = '';
                                $pieces = explode("; ", $pidstavi);
                                foreach ($pieces as $pidstav) {
                                    $num = (int) $pidstav;
                                    foreach ($table_p as $row_p){
                                        if($row_p['id_pozaplan']==$num) {
                                            $result .= $row_p['name_pozaplan'].'; ';
                                            break;
                                        }
                                    }
                                }?>
                                <?= "<div class='hidden'>".$row['pidstava_pozaplan']."</div>".$result;?></td>
                            <td><?= $row['d_start_perevirki'] == NULL ? '' : date($format_date, $row['d_start_perevirki']) ?></td>
                            <td><?= $row['d_end_perevirki'] == NULL ? '' : date($format_date, $row['d_end_perevirki']) ?></td>
                            <td><?= $row['d_start_dialnist'] == NULL ? '' : date($format_date, $row['d_start_dialnist']) ?></td>
                            <td><?= $row['d_end_dialnist'] == NULL ? '' : date($format_date, $row['d_end_dialnist']) ?></td>
                            <td><?= $row['d_nak_zah'] == NULL ? '' : date($format_date, $row['d_nak_zah']) ?></td>
                            <td><?= $row['n_nak_zah'] ?></td>
                            <td><?= $row['d_napr_proved'] == NULL ? '' : date($format_date, $row['d_napr_proved']) ?></td>
                            <td><?= $row['n_napr_proved'] ?></td>
                            <td><?= $row['ker_inspekt_group'] ?></td>
                            <td><?= $row['ch_inspekt_group'] ?></td>
                            <td><?= $row['d_akt_perevirki'] == NULL ? '' : date($format_date, $row['d_akt_perevirki']) ?></td>
                            <td><?= $row['n_akt_perevirki'] ?></td>
                            <td><?= $row['d_akt_zu'] == NULL ? '' : date($format_date, $row['d_akt_zu']) ?></td>
                            <td><?= $row['n_akt_zu'] ?></td>
                            <td>
                                <div data-toggle="popover" data-trigger="hover"
                                     data-content="<?= $row['name_akt_zu'] ?>" class="akt_zu">
                                <span>
                                    <?= $row['vid_akt_zu'] == '1' ? '': $row['vid_akt_zu']?>
                                </span>
                                </div>
                            </td>
                            <td><?= $row['d_rozp_usun'] == NULL ? '' : date($format_date, $row['d_rozp_usun']) ?></td>
                            <td><?= $row['n_rozp_usun'] ?></td>
                            <td><?= $row['strok_usun_por'] ?></td>
                            <td><? switch($row['b_usun_lic_umov']){
                                    case '1': echo 'Так'; break;
                                    case '2': echo 'Ні'; break;
                                    default: echo ''; break;
                                } ?></td>
                            <td><?= $row['name_info_vik'] ?></td>
                            <td><?= $row['d_dovidki_vik_rozp'] == NULL ? '' : date($format_date, $row['d_dovidki_vik_rozp'])?></td>
                            <td><?= $row['dn_akt_nevik'] ?></td>
                            <td><?= $row['d_post_shtraf'] == NULL ? '' : date($format_date, $row['d_post_shtraf']) ?></td>
                            <td><?= $row['n_post_shtraf'] ?></td>
                            <td><?= $row['suma_shtraf'] ?></td>
                            <td><?= $row['strok_splat_shtraf'] == NULL ? '' : date($format_date, $row['strok_splat_shtraf']) ?></td>
                            <td><?= $row['info_splat_shtraf'] == NULL ? '' : date($format_date, $row['info_splat_shtraf']) ?></td>
                            <td><?= $row['info_usun_por'] ?></td>
                            <td><?= $row['d_dovidki_vik_post'] == NULL ? '' : date($format_date, $row['d_dovidki_vik_post']) ?></td>
                            <td><?= $row['dn_sluj_ur'] ?></td>
                            <td><?= $row['sluj_perep_splat'] ?></td>
                            <td><?= $row['dn_doc_splat'] ?></td>
                            <td><?= $row['dn_sluj_nap_mat'] ?></td>
                            <td><?= $row['name_sud_dn_poz'] ?></td>
                            <td><?= $row['n_sud_sprav'] ?></td>
                            <td><?= $row['d_sud_rish'] == NULL ? '' : date($format_date, $row['d_sud_rish']) ?></td>
                            <td><?= $row['d_sud_rish_ros'] == NULL ? '' : date($format_date, $row['d_sud_rish_ros']) ?></td>
                            <td><?= $row['short_zm_rish'] ?></td>
                            <td><?= $row['name_apel_sud'] ?></td>
                            <td><?= $row['n_ssprav_apel'] ?></td>
                            <td><?= $row['d_srish_apel'] == NULL ? '' : date($format_date, $row['d_srish_apel']) ?></td>
                            <td><?= $row['d_res_srish_apel'] == NULL ? '' : date($format_date, $row['d_res_srish_apel']) ?></td>
                            <td><?= $row['short_zm_rish_apel'] ?></td>
                            <td><?= $row['dn_kasac_scar'] ?></td>
                            <td><?= $row['n_sprav_kasac'] ?></td>
                            <td><?= $row['d_rish_kasac'] == NULL ? '' : date($format_date, $row['d_rish_kasac']) ?></td>
                            <td><?= $row['d_rish_res_kasac'] == NULL ? '' : date($format_date, $row['d_rish_res_kasac']) ?></td>
                            <td><?= $row['short_zm_rish_kasac'] ?></td>
                            <td><?= $row['primitka_sud_roz'] ?></td>
                            <td><?= $row['splach_sud_zbir'] ?></td>
                            <td><?= $row['poklad_sud_zbir'] ?></td>
                            <td><?= $row['povern_sud_zbir'] ?></td>
                            <td><?= $row['dn_list_dobro_splat'] ?></td>
                            <td><?= $row['shtraf_slpach_dobro'] ?></td>
                            <td><?= $row['dn_sluj_primus'] ?></td>
                            <td><?= $row['dn_lz_vikon_list'] ?></td>
                            <td><?= $row['dn_otrum_vikon_list'] ?></td>
                            <td><?= $row['dn_napr_list_dvs'] ?></td>
                            <td><?= $row['dn_rekv_otk_vp'] ?></td>
                            <td><?= $row['short_opis_zah_dvs'] ?></td>
                            <td><?= $row['dn_rekv_zak_vp'] ?></td>
                            <td><?= $row['primitka_dod'] ?></td>
                            <td><?= $row['napr_zap_derjrei'] ?></td>
                            <td><?= $row['napr_zap_dfs'] ?></td>
                            <td><?= $row['napr_zai_police'] ?></td>
                            <td><?= $row['napr_info_bank'] ?></td>
                            <td><?= $row['napr_info_zasn'] ?></td>
                            <td><?= $row['napr_info_prokuror'] ?></td>
                            <td><?= $row['napr_info_oms'] ?></td>
                            <td><?= $row['napr_info_dfs'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <script>
                        $(document).ready(function() {
                            $('.akt_zu').popover({
                                html: false,
                                trigger: 'hover',
                                animation: true,
                                placement: "top"
                            });
                        });
                    </script>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<?php
if (isset($_POST['edit_nag'])) {
    echo '<br><pre>';
    var_dump($_POST);
    echo '</pre>';
    echo '<br><pre>';
    var_dump(edit_nag());
    echo '</pre>';
    //echo edit_nag();
}
/*
echo 'Время выполнения скрипта tables: '.$time1.' сек.';
echo "<br>";
echo 'Время выполнения скрипта all tables: '.$time2.' сек.';
echo "<br>";
echo "Difference: ".($time2-$time1);*/
?>
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
<div class="modal fade" id="modal-timer" style="margin-top: 15%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h2 class="modal-title"><i class="fa fa-refresh fa-spin"></i> &nbsp;&nbsp;Не обхідна повторна
                    авторизація!</h2>
            </div>
            <div class="modal-body" style="background-color: #d9d9d9;"> <!--f1c2c0-->
                <form id="form-relogin" method="post" autocomplete="off">
                    <button class="btn btn-danger center-block btn-labeled" name="relogin" type="submit"
                            form="form-relogin">
                    <span class="btn-label">
                        <i class="fa fa-floppy-o fa-lg"></i>
                    </span>
                        Авторизуватись
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once 'src/modal_add_naglyad.php'; ?>
<script src="js/form-add.js"></script>

<?php require_once 'src/modal_edit_n.php'; ?>

<script src="js/form-edit-n.js"></script>


<script>
    $('#table').bootstrapTable('resetView');
    var height_table = $('body').height() - 80;
    $("#table").attr("data-height", height_table.toString());
    var classColor = 'success';
    $('.akt_zu').popover();
    $("#table")
        .on('all.bs.table', function (e, name, args) {
            $('.akt_zu').popover();
            $('tbody').find('.selected').addClass(classColor);
        })
        .on('click-row.bs.table', function (e, row, $element) {
            if($($element).hasClass(classColor)) {
                $($element).removeClass(classColor);
            } else {
                $($element).addClass(classColor);
            }
        })
        .on('check.bs.table', function (e, row, $element) {
        $($element).parent().parent().addClass(classColor);
        })
        .on('uncheck.bs.table', function (e, row, $element) {
            $($element).parent().parent().removeClass(classColor);
        })
        .on('check-all.bs.table', function (e, $element) {
            $($element).parent().parent().addClass(classColor);
        })
        .on('uncheck-all.bs.table', function (e, $element) {
            $($element).parent().parent().removeClass(classColor);
        });
    function checkTime() {
        /*var action_time = <?=$_SESSION['action_time']?>;
        var d = new Date();
        var sec = d.getTime() / 1000;
        var diff = action_time - sec;
        if (diff < -3600) {
            $("#modal-timer").modal({backdrop: "static"});
        }*/
    }
    $(function () {
        checkTime();
        setInterval(function () {
            checkTime();
        }, 60000);
    });
</script>
<script>
    setTimeout(function () {
        $('#success_add').alert("close");
        $('#error_add').alert("close");
        $('#success_edit').alert("close");
        $('#error_edit').alert("close");
    }, 7000);
</script>
<script>

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