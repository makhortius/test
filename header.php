<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="ru-RU" style="background-color: #6B8E23">
<head>
    <meta charset="utf-8">
    <title>FWT</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            "use strict";

            //регулярное выражение для проверки email
            var pattern = /^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i;
            var mail = $('input[name=email]');
            
            mail.blur(function(){
                if(mail.val() != ''){

                    // Проверяю, если введенный email соответствует регулярному выражению
                    if(mail.val().search(pattern) == 0){
                        // Убираю сообщение об ошибке
                        $('#valid_email_message').text('');

                        //Активирую кнопку отправки
                        $('input[type=submit]').attr('disabled', false);
                    }else{
                        //Выводим сообщение об ошибке
                        $('#valid_email_message').text('Не правильный Email');

                        // Дезактивирую кнопку отправки
                        $('input[type=submit]').attr('disabled', true);
                    }
                }else{
                    $('#valid_email_message').text('Введите Ваш email');
                }
            });

            //Проверка длины пароля 
            var password = $('input[name=password]');
            
            password.blur(function(){
                if(password.val() != ''){

                    //Если длина введенного пароля меньше шести символов, то выводится сообщение об ошибке
                    if(password.val().length < 6){
                        $('#valid_password_message').text('Минимальная длина пароля 6 символов');

                        // Дезактивирую кнопку отправки
                        $('input[type=submit]').attr('disabled', true);
                        
                    }else{
                        // Убираю сообщение об ошибке и активирую кнопку отправки
                        $('#valid_password_message').text('');
                        $('input[type=submit]').attr('disabled', false);
                    }
                }else{
                    $('#valid_password_message').text('Введите пароль');
                }
            });
        });
    </script>
</head>
<body>

    <img src="fwt.jpg" alt="FreeWayTravels" border="1" class="fwt">
  <h1 align="center" style="color: white"><b>ДОБРО ПОЖАЛОВАТЬ!</b></h1>
  <hr style="color: #ADFF2F">

    <a href="/index.php" class="btn">Главная</a>

    <div id="auth_block">
    <?php 
        //Проверяю авторизован ли пользователь
        if(!isset($_SESSION['email']) && !isset($_SESSION['password'])){
            // если нет, то вывожу блок с ссылками на страницу регистрации и авторизации
    ?>
             <div class="btna">
                <a href="/form_auth.php">Вход</a>
            </div>
            <div class="btnr">
                <a href="/form_register.php">Регистрация</a>
            </div>

           
    <?php
        }else{
            //Если пользователь авторизован, то вывожу ссылку Выход
    ?>  
            <div id="link_logout">
                <a href="/logout.php">Выход</a>
            </div>
    <?php
        }
    ?>
    </div>
     <div class="clear"></div>
</div>

