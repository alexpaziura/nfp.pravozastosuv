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
if (isset($_POST['act_dev_mode'])) {
    if (dev_mod(1)) {
        writeLog('DEV_MODE', 'ENABLED', 1);
    } else {
        writeLog('DEV_MODE', 'ENABLED', 0);
    }
    $_SESSION['action_time'] = microtime(true);
}
if (isset($_POST['off_dev_mode'])) {
    if (dev_mod(0)) {
        writeLog('DEV_MODE', 'DISABLED', 1);
    } else {
        writeLog('DEV_MODE', 'DISABLED', 0);
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
    <style>
        .navbar-img {padding:5px 6px !important;}
        .navbar-img img {width:40px;}
        #log_out {
            color: #fbfdff;
            text-align: left;
            margin: 0;
            text-decoration: none;
            width: 100%;
            height: ;
            background-color: #d9534f;
        }
        #log_out:hover,
        #log_out:focus {
            color: #fbfdff;
            text-decoration: none;
            background-color: #a1c9f7;
        }
        .navbar-nav a {
            width: 100%;
            color: #fbfdff;
            text-decoration: none;
        }
        .navbar-nav a:hover,
        .navbar-nav a:focus {
            text-decoration: none;
            background-color: #a1c9f7;
            color: #f2f3f4;
        }
    </style>
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
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle navbar-img" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="../img/user2.png" alt="Profile Image" style="margin-right: 5px;"/>
                    <?=$_SESSION['full_name']?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <a href="../profile" class="btn btn-link dropdown-item" style=" text-align: left;">
                        <i class="fa fa-cog fa-lg"></i> Налаштування
                    </a>
                    <div class="divider" style="margin-top: 0;  margin-bottom: 5px;"></div>
                    <form method="post" class="dropdown-item">
                        <button class="btn btn-link" type="submit" name="log_out" id="log_out">
                            <i class="fa fa-sign-out fa-lg"></i> Вийти
                        </button>
                    </form>
                </ul>
            </li>
        </ul>

    </div>
    <hr id="nav-divider">
    <div class="container" id="nav2row">
        <ul class="nav navbar-nav">
            <li><a href="users"><i class="fa fa-user fa-lg"></i>&nbsp;&nbsp;&nbsp;Користувачі</a></li>
            <li class="dropdown">
                <a href="#" data-toggle="dropdown"><i class="fa fa-book fa-lg"></i>&nbsp;&nbsp;&nbsp;Довідники <span
                            class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="tab_type_fu">Тип суб'єкта нагляду</a></li>
                    <li><a href="#tab3primary" data-toggle="tab">Default 5</a></li>
                </ul>
            </li>
            <li><a href="logs"><i class="fa fa-cog fa-lg"></i>&nbsp;&nbsp;&nbsp;Логи</a></li>
            <li><a href="#tabSQL" data-toggle="tab"><i class="fa fa-play fa-lg"></i>&nbsp;&nbsp;&nbsp;Виконати SQL</a>
            </li>
        </ul>
    </div>

</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="alert alert-danger"
                 id="error_add"
                 style="width: 100%;">
                <h3 style="margin-top: 0px;font-weight: bold;"><i class="fa fa-code fa-lg"></i> Режим розробки!</h3>
                <div class="row hidden" id="confirm">
                    <div class="container" style="width: 100%; margin-top: 0px;">
                        <h4 style="word-wrap: break-word; white-space: normal;">В разі ввімкнення режиму розробки доступ до ресурсу буде здійснюватись тільки з даної IP-адреси (<?=$_SERVER['REMOTE_ADDR']?>)!</h4>
                        <div class="btn-group">
                            <form method="post">
                                <button class="btn btn-danger btn-labeled" type="submit" name="act_dev_mode" id="act_dev_mode">
                                    <span class="btn-label"><i class="fa fa-sign-out fa-lg"></i></span>Підтвердити
                                </button>
                            </form>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-default btn-labeled" type="button" name="cancel_dev_mode" id="cancel_dev_mode">
                                <span class="btn-label"><i class="fa fa-sign-out fa-lg"></i></span>Відміна
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row hidden" id="confirm_off">
                    <div class="container" style="width: 100%;">
                        <h4 style="word-wrap: break-word; white-space: normal; margin-top: 0;">В разі вимкнення режиму розробки доступ до ресурсу буде здійснюватись з будь-якої локальної IP-адреси!</h4>
                        <div class="btn-group">
                            <form method="post">
                                <button class="btn btn-success btn-labeled" type="submit" name="off_dev_mode" id="off_dev_mode">
                                    <span class="btn-label"><i class="fa fa-sign-out fa-lg"></i></span>Підтвердити
                                </button>
                            </form>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-default btn-labeled" type="button" name="cancel_off_dev_mode" id="cancel_off_dev_mode">
                                <span class="btn-label"><i class="fa fa-sign-out fa-lg"></i></span>Відміна
                            </button>
                        </div>
                    </div>
                </div>
                <div class="btn-group">
                    <button class="btn btn-danger btn-labeled" type="button" name="pre_dev_mode" id="pre_dev_mode">
                        <span class="btn-label"><i class="fa fa-sign-out fa-lg"></i></span>Активувати режим розробки
                    </button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-success btn-labeled" type="button" name="del_dev_mode" id="del_dev_mode">
                        <span class="btn-label"><i class="fa fa-sign-out fa-lg"></i></span>Вимкнути режим розробки
                    </button>
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
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../js/jquery-2.1.1.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.js"></script>
<script src="../js/bootstrap-table.js" type="text/javascript"></script>
<script src="../js/bootstrap-table-uk-UA.js" type="text/javascript"></script>
<script src="../js/table-fixed-header.js" type="text/javascript"></script>
<script src="../js/jasny-bootstrap.js" type="text/javascript"></script>
<script src="../js/tabs/tab_user.js" type="text/javascript"></script>
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
    $('#pre_dev_mode').on('click', function () {
        $(this).addClass('hidden');
        $('#del_dev_mode').addClass('hidden');
        $('#confirm').removeClass('hidden');
    });
    $('#cancel_dev_mode').on('click', function () {
        $('#confirm').addClass('hidden');
        $('#pre_dev_mode').removeClass('hidden');
        $('#del_dev_mode').removeClass('hidden');
    });
    $('#del_dev_mode').on('click', function () {
        $(this).addClass('hidden');
        $('#pre_dev_mode').addClass('hidden');
        $('#confirm_off').removeClass('hidden');
    });
    $('#cancel_off_dev_mode').on('click', function () {
        $('#confirm_off').addClass('hidden');
        $('#pre_dev_mode').removeClass('hidden');
        $('#del_dev_mode').removeClass('hidden');
    });
</script>
</body>

</html>