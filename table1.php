<?php
session_start();
error_reporting(E_ERROR);
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
    unset($_POST);
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
/*        .paggination-dots {
            padding: 2px 5px 2px 5px;
            margin: 2px;
            border: 1px solid #EEE;

            color: #DDD;
        }*/
    </style>
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
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle navbar-img" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="img/user2.png" alt="Profile Image" style="margin-right: 5px;"/>
                    <?=$_SESSION['full_name']?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <a href="profile" class="btn btn-link dropdown-item" style=" text-align: left;">
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
    <div class="row" style="margin-top: -20px;" id="row-table-inspekt">

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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h2 class="modal-title"><i class="fa fa-download"></i> &nbsp;&nbsp;Завантаження данних</h2>
            </div>
            <div class="modal-body" style="background-color: #d9d9d9;">
                <div class="progress">
                    <div class="progress-bar progress-bar-primary progress-bar-striped active"
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
<script src="js/jquery-2.1.1.js"></script>
<script src="js/jquery-ui.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="./js/bootstrap.js" type="text/javascript"></script>
<script src="./js/bootstrap-table.js" type="text/javascript"></script>
<script src="./js/bootstrap-table-uk-UA.js" type="text/javascript"></script>

<script src="extensions/export/bootstrap-table-export.js"></script>
<script src="js/tableExport.js"></script>
<script src="./js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="./js/bootstrap-datepicker.uk.min.js" type="text/javascript"></script>
<script src="./js/jasny-bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>


<script>


    function checkTime() {
        /*var action_time = <?=$_SESSION['action_time']?>;
        var d = new Date();
        var sec = d.getTime() / 1000;
        var diff = action_time - sec;
        if (diff < -3600) {
            $("#modal-timer").modal({backdrop: "static"});
        }*/
    }
    function loadData(page) {
        $.ajax({
            type:'POST',
            url:'../src/req.php',
            data: "table=inspekt&page="+page,
            dataType: 'html',

            success:function(mydata){
                $('#row-table-inspekt').html(mydata);
                $("#table").bootstrapTable();
                $("#table-footer").find('.pagination li').removeClass('active-primary');
                $('#inspekt-'+page).addClass('active-primary');
            },
            error: function () {
                alert("error");

            }
        });

    }
    $(function () {
        checkTime();
        setInterval(function () {
            checkTime();
        }, 60000);
        $("#modal-progress").modal({backdrop: "static"});
        loadData(1);
        $("#modal-progress").modal('toggle');
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
<script src="./js/table-fixed-header.js" type="text/javascript"></script>
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