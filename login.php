<?php
include "boot.php";


if(isset($_GET["auth"]))
{
    $_SESSION['username'] = null;
    header('Location: /');
    die;
}


if (check_auth()) {
    header('Location: /');
    die;
}

//Проверка логина\пароля
if(isset($_POST['username']))
{
    $use_auth=true;
    // Тут данные пользователей: array('логин' => 'пароль', 'логин' => 'пароль', ...)
    $auth_users = array(
        'user1' => 'user1',
        'user2' =>'user2',
    );
    
    // Авторизация
    if ($use_auth) 
    {
        sleep(1);
        if (isset($auth_users[$_POST['username']]) && $_POST['password'] === $auth_users[$_POST['username']]) {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['root_path'] = $_SERVER['DOCUMENT_ROOT']."/".$_SESSION['username'];
          set_mess('Вы успешно вошли!', 'success');
            $_SESSION['root_path'] = $_SESSION['username'];
            header('Location: /');
             die;
        } else {
           set_mess('Не правильный логин или пароль!', 'danger');
            //echo "no";

        }
    }
}


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Моя ФайловаяПомоечка .::. Авторизация</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="favicon.png" rel="shortcut icon" type="image/png" />

        <link type="text/css" href="css/bootstrap-index.css" rel="stylesheet" />        
      

        <style type="text/css">
            * html, html, body, body>div {min-height:100vh;
                height: 100vh;}
            body{
                position: relative;
                font-family: 'Open Sans', "Segoe UI Light","Helvetica Neue","Segoe UI","Segoe WP",sans-serif;
                min-height: 100vh;
                height: 100vh;
            }

            form .form-group{
                margin-bottom: 1em;
            }

            div.vh100{
                min-height:100vh;
            }

            .notifications{
                position: absolute;
                width: 250px;
                height: 100px;
                top: 1%;
                left: 260px;
                margin-left: -125px;
            }

            input[type=text],input[type=password]{height: auto;}
            h2{color: #357ebd;}
            h4{color: #a94442;}
            .well{margin-bottom: 0;}
            .auth-panel{

                height: 100%;
                min-height: 100%;
                background-color: #f5f5f5;
                border-right: 1px solid #f5f5f5;
                -webkit-box-shadow: 10px 0 5px -2px #888;
                min-width: 220px;
            }

            .portal-description{
                font-size: larger;
                text-align: justify;
            }

            @media screen and (max-width: 767px) {
                body {
                    padding-right: 0;
                    padding-left: 0;
                }

                body>div{display: table;}
                .auth-panel,.portal-description{
                    border: none;
                    -webkit-box-shadow: none;
                }
                .well,.control-group{
                    margin: 5px!important;
                    padding: 5px;
                }
            }
            .auth-form{
                margin-bottom: 1em;
            }
            .auth-form input[type=submit]{
                margin-top: 1em;
            }
        </style>

        <script type="text/javascript" src="/assets/js/jquery-2.1.3.min.js?25402718"></script>
        <!--[if lt IE 10]>
            <link type="text/css" href="/assets/css/iefix.css?25748" rel="stylesheet" />            <script type="text/javascript" src="/assets/js/jquery.placeholder.js?61708791"></script>            <script type="text/javascript">
                $(function() {
                    $('input, textarea').placeholder();
                });
            </script>
        <![endif]-->

        <!--[if lt IE 9]>
            <script>
                alert('Ваш браузер сильно устарел! Обновите его или установите, например, Google Chrome.');
                location.href = 'http://www.google.com/chrome/?hl=ru';
            </script>
        <![endif]-->
    </head>
<body>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 auth-panel vh100">

            <div class="well-sm text-center">
                <img src="/img/logo.png" alt="ФайлоПомоечка" title="Файлопомоечка" class="img" />            </div>

            <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
                <div class="alert alert-warning text-center">
                Вам необходимо авторизоваться для доступа к запрашиваемой странице
                </div>
            </div>
<?php
            
            get_mess();
            ?>
            <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 text-center">
                
                <form action="" method="post" accept-charset="utf-8" class="auth-form" autocomplete="off">                <div class="form-group">
                    <div class="row-fluid">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <label class="control-label" for="username">Логин</label>                        </div>
                    <div class="col-xs-12 col-sm-12 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
                    <input type="text" id="username" name="username" value="" class="form-control" autocomplete="off" />                    </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row-fluid">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <label class="control-label" for="password">Пароль</label>                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
                    <input type="password" id="password" name="password" value="" class="form-control" autocomplete="off" />                    </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row-fluid">
                    <div class="col-xs-12 col-sm-12 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
                    <input type="submit" id="signin" name="signin" value="Войти" class="btn btn-primary btn-lg" autocomplete="off" />                    </div>
                    </div>
                </div>
                </form>            </div>

            <div class="row-fluid">
            <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 text-center">
                <a href="" class="btn btn-link">Забыли пароль?</a>
                <a href="" class="btn btn-link" target="_blank">Инфо</a>            </div>
            </div>

            <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 text-center">
                <div class="alert alert-info text-center">
                    Разделы системы, доступные без авторизации
                </div>
                А таких нет =)
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-offset-1 col-md-6 col-lg-offset-1 col-lg-6 portal-description vh100">

                <div class="callout callout-danger">
                    <h4><i class="icon icon-warning-sign"></i>&nbsp;Уважаемый(-ая)!</h4>
                    <div>Если у Вас что-то не работает, нет учётной записи и/или не получается войти - смиритесь!
                       <p>Этот сервис не для всех!</p>
                    </div>
                </div>

                <div class="row-fluid">
                    <h2 class="text-center">Добро пожаловать!</h2>
                    <h4 class="text-center">Вас приветствует ФайлоПомоечка!</h4>
                </div>

                <div class="row-fluid">
                    <h4><i class="icon-certificate"></i> Наша система защищена</h4>
                    <p>Именно поэтому мы настоятельно рекомендуем Вам никому и ни при каких обстоятельствах не передавать пароль от Вашей учётной записи. Все действия совершённые авторизованным пользователем приравниваются к действию конкретного человека! Будьте внимательны!</p>
                </div>

                <div class="row-fluid">
                    <h4><i class="icon-user"></i> У Вас нет учётной записи?</h4>
                    <p>С этим ничего не поделать =)</p>
                </div>

    </div>
</div>
</body>
</html>