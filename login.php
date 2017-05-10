<?php
session_start();
$username = '';
$pwd = '';
$correct_data = true;
    if(isset($_SESSION['user'])&&isset($_SESSION['group'])) {
        header('Location:/');
       // echo $_SESSION['user'].'<br>'.$_SESSION['group'];
    }
    if(isset($_POST['login'])) {
            $username = trim(htmlspecialchars($_POST['username']));
            $pwd = trim(htmlspecialchars($_POST['password']));
            require_once("src/database.php");
            require_once("src/functions.php");
            if (get_user()) {
                header('Location:/');
                exit;
            } else {
                $correct_data = false;
            }
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
    <link rel="stylesheet" href="css/style.css">
    <!-- <link href="css/bootstrap.css" rel="stylesheet">HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="css/font-awesome.css" rel="stylesheet">
</head>

<body>
<div class="navbar navbar-custom navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a href="/" class="navbar-brand"
               style="transform: translateX(-50%); left: 50%; position: absolute;">
                <i class="fa fa-balance-scale fa-lg"></i> Правозастосування</a>
        </div>
    </div>
</div>
<div class="container" style="margin-top:30px">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><strong>Авторизація</strong></h3></div>

            <div class="panel-body">
                <form id="form-login" method="post" autocomplete="off">

                    <div class="alert alert-danger <?=$correct_data?'hidden':''?>" id="wrong_field">
                        <a class="close" href="#" onclick="$('#wrong_field').addClass('hidden');">×</a>Невірний логін чи пароль!
                    </div>
                    <div style="margin-bottom: 12px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="username" type="text" class="form-control" name="username" value="" placeholder="Ім'я користувача">
                    </div>

                    <div style="margin-bottom: 12px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Пароль">
                    </div>

                    <button id="login" class="btn btn-success center-block btn-labeled" name="login" form="form-login" type="submit" disabled="disabled">
                        <span class="btn-label"><i class="fa fa-sign-in fa-lg"></i></span>Ввійти
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container" id="ad-log"></div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-2.1.1.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
    });
</script>
<script>
    $('#form-login').submit(function () {

        var $user_field  = $('#username');
        var $pass_field = $('#password');

        var username = $.trim($user_field.val());
        var password = $.trim($pass_field.val());
        var noError = true;
        if ((username === '')||(password === '')) {
            $('#wrong_field').removeClass('hidden');
            noError = false;
        }
        if (username === '') {
            $user_field.addClass('required_field');
        } else {
            $user_field.removeClass('required_field');
        }
        if (password === '') {
            $pass_field.addClass('required_field');
        } else {
            $pass_field.removeClass('required_field')
        }
        return noError;
    });
    $('#username').keyup(function() {
        var $user_field  = $('#username');
        var username = $.trim($user_field.val());
        var regex = /^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/;
        if ( (username === '') || ( !regex.test( $(this).val() ) ) ) {
            $('#login').prop('disabled',true);
            $user_field.removeClass('accepted_field');
            $user_field.addClass('required_field');
        } else {
            $user_field.removeClass('required_field');
            $user_field.addClass('accepted_field');
            if ($('#password').val()!=='') {
                $('#login').prop('disabled',false);
            }
        }
    });
    $('#password').keyup(function() {
        var $pass_field = $('#password');
        var password = $.trim($pass_field.val());
        var regex = /(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
        if ( (password === '') || ( !regex.test( $(this).val() ) ) ) {
            $('#login').prop('disabled',true);
            $pass_field.removeClass('accepted_field');
            $pass_field.addClass('required_field');
        } else {
            $pass_field.removeClass('required_field');
            $pass_field.addClass('accepted_field');
            if ($('#username').val()!=='') {
                $('#login').prop('disabled',false);
            }
        }
    });
</script>
<!--<script>
    $(document).ready( function () {
        $("#login").click( function () {
            $('#ad-log').html('');
            $("#wrong_field").addClass("hidden");
            var username = $("#username").val();
            var password = $("#password").val();
            if(username.length==0 || password.length==0) {
                $("#wrong_field").removeClass("hidden");
                return false;
            }
        });
    });
</script>-->

</body>

</html>