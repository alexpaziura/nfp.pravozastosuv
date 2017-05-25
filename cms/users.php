<?php
session_start();
require_once("../src/database.php");
require_once("../src/functions.php");
if(!isset($_SESSION['user'])){
    header('Location: ../login.php');
} else if ($_SESSION['group']!='ДеРЗІТ') {
    header('Location:/');
}
if ((isset($_POST['log_out']))||(!isUserActive())) {
    writeLog('AUTH','LOGOUT',1);
    unset($_SESSION['user']);
    unset($_SESSION['group']);
    unset($_SESSION['full_name']);
    unset($_SESSION['action_time']);
    session_destroy();
    header('Location: ../login.php');
}
if (isset($_POST['relogin'])) {
    writeLog('AUTH','LOGOUT',1);
    unset($_SESSION['user']);
    unset($_SESSION['group']);
    unset($_SESSION['full_name']);
    unset($_SESSION['action_time']);
    session_destroy();
    header('Location: ../login.php');
}

$state_add = '';
$state_edit = '';
$state_del = '';

if(isset($_POST['add_user'])){
    if (add_user()) {
        $state_add = 'success';
    } else {
        $state_add = 'error';
    }
    $_SESSION['action_time'] = microtime(true);
}
if(isset($_POST['edit_user'])){
    if (edit_user()) {
        $state_edit = 'success';
    } else {
        $state_edit = 'error';
    }
    $_SESSION['action_time'] = microtime(true);
}
if(isset($_POST['delete_user'])){
    if (delete_user()) {
        $state_del = 'success';
    } else {
        $state_del = 'error';
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
            <li><a href="../table1.php">Інспеційна діяльність</a></li>
            <li><a href="../table2.php">Інші види діяльності</a></li>
            <li class="active <?=$_SESSION['group']=='ДеРЗІТ'?'':'hidden'?>"><a href="/cms/">Адміністрування</a></li>
        </ul>
        <form method="post" class="navbar-form navbar-right">
            <div class="form-group">
                <button class="btn btn-danger btn-labeled" type="submit" name="log_out" id="log_out">
                    <span class="btn-label"><i class="fa fa-sign-out fa-lg"></i></span>Вийти
                </button>
            </div>
        </form>
        <p class="navbar-text navbar-right">Ви ввійши, як <?=$_SESSION['full_name']?>!</p>

    </div>
    <hr id="nav-divider">
    <div class="container" id="nav2row">
        <ul class="nav navbar-nav">
            <li class="active"><a href="users.php"><i class="fa fa-user fa-lg"></i>&nbsp;&nbsp;&nbsp;Користувачі</a></li>
            <li class="dropdown">
                <a href="#" data-toggle="dropdown"><i class="fa fa-book fa-lg"></i>&nbsp;&nbsp;&nbsp;Довідники <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="tab_type_fu.php">Тип суб'єкта нагляду</a></li>
                    <li><a href="#tab3primary" data-toggle="tab">Default 5</a></li>
                </ul>
            </li>
            <li><a href="logs.php"><i class="fa fa-cog fa-lg"></i>&nbsp;&nbsp;&nbsp;Логи</a></li>
            <li><a href="#tabSQL" data-toggle="tab"><i class="fa fa-play fa-lg"></i>&nbsp;&nbsp;&nbsp;Виконати SQL</a></li>
        </ul>
    </div>

</div>
<div class="container-fluid" id="content-body" style="height: 90%">
    <div class="row">
        <div class="container">
            <div class="alert alert-success alert-dismissable alert-fixed <?= $state_add == 'success' ? '' : 'hidden' ?>"
                 id="success_add">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close fa-2x" style="color: red;"></i>
                </button>
                <h4>Користувача успішно додано!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-danger alert-dismissable alert-fixed <?= $state_add == 'error' ? '' : 'hidden' ?>"
                 id="error_add">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close fa-2x" style="color: red;"></i>
                </button>
                <h4>Виникла помилка при додаванні користувача!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-success alert-dismissable alert-fixed <?= $state_edit == 'success' ? '' : 'hidden' ?>"
                 id="success_edit">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close fa-2x" style="color: red;"></i>
                </button>
                <h4>Користувача успішно змінено!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-danger alert-dismissable alert-fixed <?= $state_edit == 'error' ? '' : 'hidden' ?>"
                 id="error_edit">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close fa-2x" style="color: red;"></i>
                </button>
                <h4>Виникла помилка при редагуванні користувача!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-success alert-dismissable alert-fixed <?= $state_del == 'success' ? '' : 'hidden' ?>"
                 id="success_del">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close fa-2x" style="color: red;"></i>
                </button>
                <h4>Користувача успішно видалено!</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="alert alert-danger alert-dismissable alert-fixed <?= $state_del == 'error' ? '' : 'hidden' ?>"
                 id="error_del">
                <button type="button" class="close alert-close" data-dismiss="alert">
                    <i class="fa fa-close fa-2x" style="color: red;"></i>
                </button>
                <h4>Виникла помилка при видаленні користувача!</h4>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: -20px;">
        <div class="container">
            <div id="toolbar" class="btn-toolbar">
                <div class="btn-group">
                    <button type="button" class="btn btn-success btn-labeled" id="addUser">
                        <span class="btn-label"><i class="fa fa-user-plus fa-lg"></i></span>Додати користувача
                    </button>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-warning btn-labeled" id="editUser">
                        <span class="btn-label"><i class="fa fa-pencil fa-lg"></i></span>Редагувати користувача
                    </button>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-labeled" id="deleteUser">
                        <span class="btn-label"><i class="fa fa-user-times fa-lg"></i></span>Видалити користувача
                    </button>
                </div>
            </div>
            <div class="">
                <table
                    data-toggle="table"
                    id="table_user"
                    class="table table-striped table-bordered table-fixed-header table-condensed"
                    data-sort-name="id_user"
                    data-sort-order="asc"
                    data-toolbar="#toolbar"
                    data-search="true"
                    data-height="825"
                    data-searchOnEnterKey="true"
                    data-click-to-select="true"
                    data-checkbox-header="false"
                    data-resizable="true"
                    style="background-color: seashell;">
                    <thead class="header" style="background-color: seashell;">
                    <tr>

                        <th data-field="state" data-checkbox="true" data-events="clickCheck"></th>
                        <th data-field="id_user" data-sortable="true" data-halign="center" data-align="center"
                            class="hidden">
                            id
                        </th>
                        <th data-field="username" data-sortable="true" data-halign="center" data-align="center">
                            Ім'я користувача
                        </th>
                        <th data-field="full_name" data-sortable="true" data-halign="center" data-align="center">
                            ПІБ
                        </th>
                        <th data-field="memberof" data-sortable="true" data-halign="center" data-align="center">
                            Член групи
                        </th>
                        <th data-field="active_user" data-sortable="true"  data-halign="center" data-align="center">
                            Статус
                        </th>
                    </tr>
                    </thead>
                    <tbody >
                    <?php $table_users = get_users();
                    foreach ($table_users as $row):
                        if ($row['visible']=='0') continue;?>
                        <tr>
                            <td></td>
                            <td class="hidden"><?= $row['id_user'] ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['full_name'] ?></td>
                            <td><?= $row['memberof'] ?></td>
                            <td><?= $row['active_user']=='1'?
                                    "<i class='fa fa-check' style='color:#5cb85c;'></i>"
                                    :"<i class='fa fa-ban' style='color: #d9534f;'></i>"?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
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
                <h2 class="modal-title"><i class="fa fa-refresh fa-spin"></i> &nbsp;&nbsp;Не обхідна повторна авторизація!</h2>
            </div>
            <div class="modal-body" style="background-color: #d9d9d9;"> <!--f1c2c0-->
                <form id="form-relogin" method="post" autocomplete="off">
                    <button class="btn btn-danger center-block btn-labeled" name="relogin" type="submit" form="form-relogin">
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
<div class="modal fade container-fluid" id="modal_add_user">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button class="close" type="button" data-dismiss="modal">
                    <i class="fa fa-close fa-2x" style="color: red;"></i>
                </button>
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="modal-title"><i class="fa fa-user-plus fa-lg" style="color: "></i> &nbsp;&nbsp;Додавання користувача</h2>
                    </div>
                    <div class="col-sm-5" style="margin-bottom: -20px">
                        <div class="alert alert-danger hidden"
                             id="wrong_fields">
                            <h4 style="margin-bottom: -5px;margin-top: -5px">Не вірно заповнено поле/поля!</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="background-color: #d9d9d9;"> <!--cae8ca-->
                <form id="add-user" method="post" autocomplete="off">
                    <p style="color: red">
                        <sup>
                            <i class="fa fa-asterisk" style="color: red"></i>
                        </sup> - Обов'язкове поле!</p>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="username">Ім'я користувача <sup>
                                        <i class="fa fa-asterisk" style="color: red"></i>
                                    </sup></label>
                                <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-user fa-lg"></i>
                                            </span>
                                <input name="username" type="text" class="form-control" id="username" maxlength="255">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="username">Пароль
                                    <sup>
                                        <i class="fa fa-asterisk" style="color: red"></i>
                                    </sup>
                                </label>
                                <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-lock fa-lg"></i>
                                            </span>
                                <input name="password" type="password" class="form-control" id="password" maxlength="255">
                                </div>
                                </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="pib">ПІБ <sup>
                                        <i class="fa fa-asterisk" style="color: red"></i>
                                    </sup></label>
                                <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font fa-lg"></i>
                                            </span>
                                <input name="pib" type="text" class="form-control" id="pib" maxlength="255">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="memberof">Член групи <sup>
                                        <i class="fa fa-asterisk" style="color: red"></i>
                                    </sup></label>
                                <select name="memberof" id="memberof" class="form-control">
                                    <option value="" hidden></option>
                                    <option value="UR">ЮР</option>
                                    <option value="SK">СК</option>
                                    <option value="FK">ФК</option>
                                    <option value="KS">КС</option>
                                    <option value="NPZ">НПЗ</option>
                                    <option value="RRFP">РРФП</option>
                                    <option value="DeRZIT">ДеРЗІТ</option>
                                    <option value="All_read">Всі на читання</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="active">Активний</label>
                                <label class="btn btn-lg btn-success tog btn-group-justified" id="ltoggle"
                                       style="padding-top: 4px; padding-bottom: 4px">
                                    <input type="checkbox" name="active" autocomplete="off"
                                           class="hidden" checked="checked" id="activeUser">
                                    <div id="title"><i class="fa fa-check"></i> Так</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: #d9d9d9;">
                <button class="btn btn-primary center-block btn-labeled" name="add_user" type="submit" form="add-user">
                    <span class="btn-label">
                        <i class="fa fa-floppy-o fa-lg"></i>
                    </span>
                    Зберегти
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade container-fluid" id="modal_edit_user">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button class="close" type="button" data-dismiss="modal">
                    <i class="fa fa-close fa-2x" style="color: red;"></i>
                </button>
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="modal-title"><i class="fa fa-pencil fa-lg" style="color: "></i> &nbsp;&nbsp;Редагування користувача</h2>
                    </div>
                    <div class="col-sm-5" style="margin-bottom: -20px">
                        <div class="alert alert-danger hidden"
                             id="wrong_fields_edit">
                            <h4 style="margin-bottom: -5px;margin-top: -5px">Не вірно заповнено поле/поля!</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="background-color: #d9d9d9;">
                <form id="edit-user" method="post" autocomplete="off">
                    <p style="color: red">
                        <sup>
                            <i class="fa fa-asterisk" style="color: red"></i>
                        </sup> - Обов'язкове поле!</p>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="username_edit">Ім'я користувача <sup>
                                        <i class="fa fa-asterisk" style="color: red"></i>
                                    </sup></label>
                                <input name="username_edit" type="text" class="form-control" id="username_edit" maxlength="255">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="password_edit">Пароль
                                    <sup>
                                        <i class="fa fa-asterisk" style="color: red"></i>
                                    </sup>
                                </label>
                                <input name="password_edit" type="password" class="form-control" id="password_edit" maxlength="255">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="pib_edit">ПІБ <sup>
                                        <i class="fa fa-asterisk" style="color: red"></i>
                                    </sup></label>
                                <input name="pib_edit" type="text" class="form-control" id="pib_edit" maxlength="255">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="memberof_edit">Член групи <sup>
                                        <i class="fa fa-asterisk" style="color: red"></i>
                                    </sup></label>
                                <select name="memberof_edit" id="memberof_edit" class="form-control">
                                    <option value="" hidden></option>
                                    <option value="UR">ЮР</option>
                                    <option value="SK">СК</option>
                                    <option value="FK">ФК</option>
                                    <option value="KS">КС</option>
                                    <option value="NPZ">НПЗ</option>
                                    <option value="RRFP">РРФП</option>
                                    <option value="DeRZIT">ДеРЗІТ</option>
                                    <option value="All_read">Всі на читання</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="active">Активний</label>
                                <label class="btn btn-lg btn-success tog btn-group-justified" id="ltoggle_edit"
                                       style="padding-top: 4px; padding-bottom: 4px">
                                    <input type="checkbox" name="active_edit" autocomplete="off"
                                           class="hidden" checked="checked" id="activeUser_edit">
                                    <div id="title_edit"><i class="fa fa-check"></i> Так</div>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <input type="hidden" name="id_user" id="id_user" value="">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer" style="background-color: #d9d9d9;">
                <button class="btn btn-primary center-block btn-labeled" name="edit_user" type="submit" form="edit-user">
                    <span class="btn-label">
                        <i class="fa fa-floppy-o fa-lg"></i>
                    </span>
                    Зберегти
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_delete_user">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <button class="close" type="button" data-dismiss="modal">
                    <i class="fa fa-close fa-2x" style="color: #0F0F0F;"></i>
                </button>
                <h2 class="modal-title"><i class="fa fa-user-times"></i> &nbsp;&nbsp;Видалення користувача!</h2>
            </div>
            <div class="modal-body" style="background-color: #d9d9d9;"> <!--f1c2c0-->
                <form id="delete-user" method="post" autocomplete="off">
                    <input type="hidden" name="id_user_delete" id="id_user_delete" value="">
                    <p id="del_user_textT" class="hidden"></p>
                    <div class="form-group">
                        <p style="font-weight: bold;">Підтвердіть видалення наступних користувачів:</p>
                        <div id="del_user_text" style="font-weight: bold;"></div>
                    </div>
                    <button class="btn btn-danger center-block btn-labeled" name="delete_user" type="submit" form="delete-user">
                    <span class="btn-label">
                        <i class="fa fa-trash fa-lg"></i>
                    </span>
                        Видалити
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
<script src="../js/tabs/tab_user.js" type="text/javascript"></script>
<script>
    $(function() {
        checkTime();
        setInterval(function (){
            checkTime();
        }, 60000);
    });
    // Add slideDown animation to Bootstrap dropdown when expanding.
    $('.dropdown').on('show.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
    }).on('hide.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
    });

    function checkTime() {
        var action_time = <?=$_SESSION['action_time']?>;
        var d = new Date();
        var sec = d.getTime()/1000;
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
        $('#success_del').alert("close");
        $('#error_del').alert("close");
    }, 7000);

</script>
</body>

</html>