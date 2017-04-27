<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header('Location:login.php');
        exit();
    }
    if(isset($_POST['log_out'])){
        unset($_SESSION['user']);
        unset($_SESSION['group']);
        unset($_SESSION['full_name']);
        session_destroy();
        header('Location:login.php');
        exit();
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
            <a href="/" class="navbar-brand"><i class="fa fa-balance-scale"></i> Правозастосування</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="table1.php">Інспеційна діяльність</a></li>
            <li class="active"><a href="next.php">Інші види діяльності</a></li>
            <li class="<?=$_SESSION['group']=='ДеРЗІТ'?'':'hidden'?>"><a href="cms.php">Адміністрування</a></li>
        </ul>
        <form method="post" class="navbar-form navbar-right">
            <div class="form-group">
                <button class="btn btn-danger" type="submit" name="log_out" id="log_out">
                    <i class="fa fa-sign-out"></i> Вийти
                </button>
            </div>
        </form>
        <p class="navbar-text navbar-right">Ви ввійши, як <?=$_SESSION['full_name']?>!</p>
    </div>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>

</body>

</html>