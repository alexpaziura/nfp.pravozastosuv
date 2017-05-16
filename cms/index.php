<?php
    session_start();
    require_once("../src/database.php");
    require_once("../src/functions.php");
    if(!isset($_SESSION['user'])){
        header('Location: ../login.php');
    } else if ($_SESSION['group']!='ДеРЗІТ') {
        header('Location:/');
    }
    if(isset($_POST['log_out'])){
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
            <li><a href="users.php"><i class="fa fa-user fa-lg"></i>&nbsp;&nbsp;&nbsp;Користувачі</a></li>
            <li class="dropdown">
                <a href="#" data-toggle="dropdown"><i class="fa fa-book fa-lg"></i>&nbsp;&nbsp;&nbsp;Довідники <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#tabTypeFu" data-toggle="tab">Тип суб'єкта нагляду</a></li>
                    <li><a href="#tab3primary" data-toggle="tab">Default 5</a></li>
                </ul>
            </li>
            <li><a href="logs.php"><i class="fa fa-cog fa-lg"></i>&nbsp;&nbsp;&nbsp;Логи</a></li>
            <li><a href="#tabSQL" data-toggle="tab"><i class="fa fa-play fa-lg"></i>&nbsp;&nbsp;&nbsp;Виконати SQL</a></li>
        </ul>
    </div>

</div>
<div class="container-fluid">

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
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
        checkTime();
        setInterval(function (){
            checkTime();
        }, 60000);
    });
    // Add slideDown animation to Bootstrap dropdown when expanding.
    $('.dropdown').on('show.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
    });

    // Add slideUp animation to Bootstrap dropdown when collapsing.
    $('.dropdown').on('hide.bs.dropdown', function() {
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
    }, 7000);

</script>
</body>

</html>