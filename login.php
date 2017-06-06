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
        <div class="panel panel-primary">
            <div class="panel-heading"><h3 class="panel-title text-center"><strong>Авторизація</strong></h3></div>

            <div class="panel-body" style="background-color: #d9d9d9;">
                <form id="form-login" method="post" autocomplete="off">

                    <div class="alert alert-danger <?=$correct_data?'hidden':''?>" id="wrong_field">
                        <a class="close" href="#" onclick="$('#wrong_field').addClass('hidden');">×</a>Невірний логін чи пароль!
                    </div>
                    <div style="margin-bottom: 12px" class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa-lg"></i></span>
                        <input id="username" type="text" class="form-control" name="username" value="" placeholder="Ім'я користувача">
                    </div>

                    <div style="margin-bottom: 12px" class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg"></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Пароль">
                    </div>

                    <button id="login" class="btn btn-primary center-block btn-labeled" name="login" form="form-login" type="submit" disabled="disabled">
                        <span class="btn-label"><i class="fa fa-sign-in fa-lg"></i></span>Ввійти
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?=$_ENV['construction']?>
<div class="container" id="ad-log"></div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-2.1.1.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
<script>
    var loginBtn = $('#login');
    $('#form-login').on('submit', function () {

        var $user_field  = $('#username');
        var $pass_field = $('#password');
        var username = $.trim($user_field.val());
        var password = $.trim($pass_field.val());
        var noError = true;
        if (username === '') {
            $user_field.addClass('required_field');
            noError = false;
        }
        if (password === '') {
            $pass_field.addClass('required_field');
            noError = false;
        }
        return noError;
    });
    $('#username').on('keyup', function() {
        var $user_field  = $(this);
        var username = $.trim($user_field.val());
        var regex = /^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/;
        if ( (username === '') || ( !regex.test( $user_field.val() ) ) ) {
            $user_field.removeClass('accepted_field').addClass('required_field');
        } else {
            $user_field.removeClass('required_field').addClass('accepted_field');
        }
        if(checkFields()) {
            loginBtn.prop('disabled',false);
        } else {
            loginBtn.prop('disabled',true);
        }
    });
    $('#password').on('keyup', function() {
        var $pass_field = $(this);
        var password = $.trim($pass_field.val());
        var regex = /(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
        if ( (password === '') || ( !regex.test( $pass_field.val() ) ) ) {
            $pass_field.removeClass('accepted_field').addClass('required_field');
        } else {
            $pass_field.removeClass('required_field').addClass('accepted_field');
        }
        if(checkFields()) {
            loginBtn.prop('disabled',false);
        } else {
            loginBtn.prop('disabled',true);
        }
    });
    function checkFields() {
        var fields = $(".form-control:not(.accepted_field)");
        var bool = true;
        if (fields.length !== 0) {
            bool = false;
        }
        return bool;
    }
</script>
</body>

</html>