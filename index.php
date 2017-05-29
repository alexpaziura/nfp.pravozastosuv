<?php
    session_start();
    require_once("src/database.php");
    require_once("src/functions.php");
    if(!isset($_SESSION['user'])){
        header('Location:login');
    }
    if(isset($_POST['log_out'])){
        writeLog('AUTH','LOGOUT',1);
        unset($_SESSION['user']);
        unset($_SESSION['group']);
        unset($_SESSION['full_name']);
        session_destroy();
        header('Location:login');
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
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="./css/jasny-bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <!-- <link href="css/bootstrap.css" rel="stylesheet">HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="css/font-awesome.css" rel="stylesheet">
    <style>
        #telo h2 {
            /*color: #FFDD1B;*/
            /*color: #228DFF;*/
            color: #0e437e;
            font-family: Appetite;
            font-size: 3em;
            text-align: center;
            text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #fff, 0 0 40px #0e437e, 0 0 70px #0e437e;
        }
        #telo .btn-primary {
            background: #007299;
            box-shadow: 0 0 10px #fff;
        }
    </style>
</head>

<body>

<div class="navbar navbar-custom navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a href="/" class="navbar-brand"><i class="fa fa-balance-scale fa-lg"></i> Правозастосування</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="table1">Інспеційна діяльність</a></li>
            <li><a href="table2">Інші види діяльності</a></li>
            <li class="<?=$_SESSION['group']=='ДеРЗІТ'?'':'hidden'?>"><a href="cms/">Адміністрування</a></li>
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
</div>

<div class="container" id="telo">
    <h2>Початкова сторінка <?=apache_getenv("DEV_MODE")?></h2>
    <a href="table1" class="btn btn-group-justified btn-primary btn-lg">Інспекційна діяльність</a>
    <br>
    <a href="table2" class="btn btn-group-justified btn-primary btn-lg">Інші види діяльності</a>
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
    <script src="js/jquery-2.1.1.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>
<script>
    function checkTime() {
        var action_time = <?=$_SESSION['action_time']?>;
        var d = new Date();
        var sec = d.getTime() / 1000;
        var diff = action_time - sec;
        if (diff < -3600) {
            $("#modal-timer").modal({backdrop: "static"});
        }
    }
    $(function () {
        checkTime();
        setInterval(function () {
            checkTime();
        }, 60000);
    });
</script>

</body>

</html>