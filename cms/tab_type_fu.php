<?php
session_start();
require_once("../src/database.php");
require_once("../src/functions.php");
if (!isset($_SESSION['user'])) {
    header('Location: ../login');
} else if ($_SESSION['group'] != 'ДеРЗІТ') {
    header('Location:/');
}
if ((isset($_POST['log_out'])) || (!isUserActive())) {
    writeLog('AUTH', 'LOGOUT', 1);
    unset($_SESSION['user']);
    unset($_SESSION['group']);
    unset($_SESSION['full_name']);
    unset($_SESSION['action_time']);
    session_destroy();
    header('Location: ../login');
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
$state_add_1 = '';
$state_edit_1 = '';
if(isset($_POST['add_row'])){
    if (add_row_dic('dic_type_fu')) {
        $state_add_1 = 'success';
    } else {
        $state_add_1 = 'error';
    }
    $_SESSION['action_time'] = microtime(true);
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
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/nav.css">
    <link href="../css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/jasny-bootstrap.css">
    <link rel="stylesheet" href="../css/bootstrap-table.css">
    <link rel="stylesheet" href="../css/table-fixed-header.css">
    <!-- <link href="css/bootstrap.css" rel="stylesheet">HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<div class="navbar navbar-custom navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a href="/" class="navbar-brand"><i class="fa fa-balance-scale fa-lg"></i> Правозастосування</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="../table1">Інспеційна діяльність</a></li>
            <li><a href="../table2">Інші види діяльності</a></li>
            <li class="active <?= $_SESSION['group'] == 'ДеРЗІТ' ? '' : 'hidden' ?>"><a href="/cms/">Адміністрування</a>
            </li>
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
    <hr id="nav-divider">
    <div class="container" id="nav2row">
        <ul class="nav navbar-nav">
            <li><a href="users"><i class="fa fa-user fa-lg"></i>&nbsp;&nbsp;&nbsp;Користувачі</a></li>
            <li class="dropdown active">
                <a href="#" data-toggle="dropdown"><i class="fa fa-book fa-lg"></i>&nbsp;&nbsp;&nbsp;Довідники <span
                            class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li class="active"><a href="tab_type_fu">Тип суб'єкта нагляду</a></li>
                    <li><a href="#tab3primary" data-toggle="tab">Default 5</a></li>
                </ul>
            </li>
            <li><a href="logs"><i class="fa fa-cog fa-lg"></i>&nbsp;&nbsp;&nbsp;Логи</a></li>
            <li><a href="#tabSQL" data-toggle="tab"><i class="fa fa-play fa-lg"></i>&nbsp;&nbsp;&nbsp;Виконати SQL</a>
            </li>
        </ul>
    </div>

</div>
<div class="container-fluid" id="content-body" style="height: 90%">
    <!--<div class="toolbar">
<button id="button" class="btn btn-default">getSelectedRow</button></div>-->
    <div class="row">
        <div class="container">
            <div class="alert alert-success alert-dismissable alert-fixed <?= $state_add_1 == 'success' ? '' : 'hidden' ?>"
                 id="success_add_1">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close fa-2x"></i>
                </button>
                <h4>Запис успішно додано!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-danger alert-dismissable alert-fixed <?= $state_add_1 == 'error' ? '' : 'hidden' ?>"
                 id="error_add_1">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close fa-2x"></i>
                </button>
                <h4>Виникла помилка при додаванні запису!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-success alert-dismissable alert-fixed <?= $state_edit_1 == 'success' ? '' : 'hidden' ?>"
                 id="success_edit_1">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close fa-2x"></i>
                </button>
                <h4>Запис успішно змінено!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-danger alert-dismissable alert-fixed <?= $state_edit_1 == 'error' ? '' : 'hidden' ?>"
                 id="error_edit_1">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close fa-2x"></i>
                </button>
                <h4>Виникла помилка при редагуванні запису!</h4>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: -20px;">
        <div class="container">
            <div id="toolbar_1" class="btn-toolbar">
                <div class="btn-group">
                    <button type="button" class="btn btn-success btn-labeled add" id="add_row">
                        <span class="btn-label"><i class="fa fa-plus fa-lg"></i></span>Додати
                    </button>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-warning btn-labeled edit" id="edit_row">
                        <span class="btn-label"><i class="fa fa-pencil fa-lg"></i></span>Редагувати
                    </button>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-labeled" id="delete_row">
                        <span class="btn-label"><i class="fa fa-trash fa-lg"></i></span>Видалити
                    </button>
                </div>
            </div>
            <div class="center-block">
                <table
                        data-toggle="table"
                        id="table_type_fu"
                        class="table table-striped table-bordered table-fixed-header table-condensed"
                        data-sort-name="id_user"
                        data-sort-order="asc"
                        data-toolbar="#toolbar_1"
                        data-search="true"
                        data-searchOnEnterKey="true"
                        data-click-to-select="true"
                        data-checkbox-header="false"
                        data-resizable="true"
                        style="background-color: seashell;">
                    <thead class="header" style="background-color: seashell;">
                    <tr>

                        <th data-field="state" data-checkbox="true" data-events="clickCheck"></th>
                        <th data-field="id_type" data-sortable="true" data-halign="center" data-align="center">
                            id
                        </th>
                        <th data-field="name_type" data-sortable="true" data-halign="center" data-align="center">
                            Тип суб'єкта нагляду
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $table_type_fu = get_dic('dic_type_fu');
                    foreach ($table_type_fu as $row):
                        if ($row['visible'] == '0') continue; ?>
                        <tr>
                            <td></td>
                            <td><?= $row['id_type_fu'] ?></td>
                            <td><?= $row['name_type_fu'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade container-fluid" id="modal_add_row">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button class="close" type="button" data-dismiss="modal">
                    <i class="fa fa-close fa-2x" style="color: red;"></i>
                </button>
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="modal-title">
                            <i class="fa fa-plus fa-lg" style="color: "></i>
                            &nbsp;&nbsp;Додати запис</h2>
                    </div>
                    <div class="col-sm-5" style="margin-bottom: -20px">
                        <div class="alert alert-danger hidden"
                             id="wrong_fields">
                            <h4 style="margin-bottom: -5px;margin-top: -5px">Не заповнено поле!</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="background-color: #d9d9d9;"> <!--cae8ca-->
                <form id="add-row" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-6 col-md-offset-3">
                            <div class="form-group">
                                <label for="type_sub">Тип суб'єкта нагляду</label>
                                <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font fa-lg"></i>
                                            </span>
                                    <input name="type_sub" type="text" class="form-control" id="type_sub"
                                           maxlength="255">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #d9d9d9;">
                <button class="btn btn-primary center-block btn-labeled" name="add_row" type="submit" form="add-row">
                    <span class="btn-label">
                        <i class="fa fa-floppy-o fa-lg"></i>
                    </span>
                    Зберегти
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade container-fluid" id="modal_edit_row">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button class="close" type="button" data-dismiss="modal">
                    <i class="fa fa-close fa-2x" style="color: red;"></i>
                </button>
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="modal-title">
                            <i class="fa fa-pencil fa-lg" style="color: "></i>
                            &nbsp;&nbsp;Редагувати запис</h2>
                    </div>
                    <div class="col-sm-5" style="margin-bottom: -20px">
                        <div class="alert alert-danger hidden"
                             id="wrong_fieldsE">
                            <h4 style="margin-bottom: -5px;margin-top: -5px">Не заповнено поле!</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="background-color: #d9d9d9;"> <!--cae8ca-->
                <form id="edit-row" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-6 col-md-offset-3">
                            <div class="form-group">
                                <label for="type_subE">Тип суб'єкта нагляду</label>
                                <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font fa-lg"></i>
                                            </span>
                                    <input name="type_subE" type="text" class="form-control" id="type_subE"
                                           maxlength="255">
                                </div>
                                <input type="hidden" name="id_type_fu" id="id_type_fu" value="">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #d9d9d9;">
                <button class="btn btn-primary center-block btn-labeled" name="edit_row" type="submit" form="edit-row">
                    <span class="btn-label">
                        <i class="fa fa-floppy-o fa-lg"></i>
                    </span>
                    Зберегти
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-ch-multi">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header modal-header-warning">
                <button class="close" type="button" data-dismiss="modal" style="color: red;">
                    <i class="fa fa-close fa-2x"></i>
                </button>
                <h2 class="modal-title"><i class="fa fa-warning"></i> &nbsp;&nbsp;Вибрано більше одного запису для
                    редагування.</h2>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-ch-0">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header modal-header-warning">
                <button class="close" type="button" data-dismiss="modal" style="color: red;">
                    <i class="fa fa-close fa-2x"></i>
                </button>
                <h2 class="modal-title"><i class="fa fa-warning"></i> &nbsp;&nbsp;Не вибрано запис для редагування.</h2>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-timer" style="margin-top: 15%;">
    <div class="modal-dialog ">
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
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../js/jquery-2.1.1.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.js"></script>
<script src="../js/bootstrap-table.js" type="text/javascript"></script>
<script src="../js/bootstrap-table-uk-UA.js" type="text/javascript"></script>
<script src="../js/table-fixed-header.js" type="text/javascript"></script>
<script src="../js/jasny-bootstrap.js" type="text/javascript"></script>
<script src="../js/tabs/tab_type_fu.js" type="text/javascript"></script>
<script src="../extensions/export/bootstrap-table-export.js"></script>
<script src="../js/tableExport.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
        checkTime();
        setInterval(function () {
            checkTime();
        }, 60000);
    });
    // Add slideDown animation to Bootstrap dropdown when expanding.
    $('.dropdown').on('show.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
    }).on('hide.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
    });
    function checkTime() {
        var action_time = <?=$_SESSION['action_time']?>;
        var d = new Date();
        var sec = d.getTime() / 1000;
        var diff = action_time - sec;
        if (diff < -3600) {
            $("#modal-timer").modal({backdrop: "static"});
        }
    }
</script>
<script>
    setTimeout(function () {
        $('#success_add').alert("close");
        $('#error_add').alert("close");
        $('#success_edit').alert("close");
        $('#error_edit').alert("close");
    }, 7000);

</script>
</body>

</html>