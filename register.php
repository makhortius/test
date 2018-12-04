<?php
    session_start();

    require_once("dbconnect.php");

    $_SESSION["error_messages"] = '';
    $_SESSION["success_messages"] = '';


    if(isset($_POST["btn_submit_register"]) && !empty($_POST["btn_submit_register"])){


        $captcha = trim($_POST["captcha"]);

        if(isset($_POST["captcha"]) && !empty($captcha)){

            //Сравнивает полученное значение с значением из сессии. 
            if(($_SESSION["rand"] != $captcha) && ($_SESSION["rand"] != "")){
                
                // Если капча не верна, то возвращает пользователя на страницу регистрации, и там выведит ему сообщение об ошибке что он ввёл неправильную капчу.
                $error_message = "<p class='mesage_error'><strong>Ошибка!</strong> Вы ввели неправильную капчу </p>";

                $_SESSION["error_messages"] = $error_message;

                //Возвращает пользователя на страницу регистрации
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_register.php");

                exit();
            }
            
            if(isset($_POST["first_name"])){
                
                $first_name = trim($_POST["first_name"]);

                if(!empty($first_name)){

                    $first_name = htmlspecialchars($first_name, ENT_QUOTES);
                }else{
 
                    $_SESSION["error_messages"] .= "<p class='mesage_error'>Укажите Ваше имя</p>";

                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$address_site."/form_register.php");

                    exit();
                }

                
            }else{

                $_SESSION["error_messages"] .= "<p class='mesage_error'>Отсутствует поле с именем</p>";


                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_register.php");


                exit();
            }

            
            if(isset($_POST["last_name"])){


                $last_name = trim($_POST["last_name"]);

                if(!empty($last_name)){

                    $last_name = htmlspecialchars($last_name, ENT_QUOTES);
                }else{

 
                    $_SESSION["error_messages"] .= "<p class='mesage_error' >Укажите Вашу фамилию</p>";
                    
  
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$address_site."/form_register.php");


                    exit();
                }

                
            }else{

 
                $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле с фамилией</p>";
                

                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_register.php");

  
                exit();
            }

            
            if(isset($_POST["email"])){

                $email = trim($_POST["email"]);

                if(!empty($email)){


                    $email = htmlspecialchars($email, ENT_QUOTES);


                    //Проверяет формат полученного почтового адреса с помощью регулярного выражения
                    $reg_email = "/^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i";

                    //Если формат полученного почтового адреса не соответствует регулярному выражению
                    if( !preg_match($reg_email, $email)){
                        $_SESSION["error_messages"] .= "<p class='mesage_error' >Вы ввели неправельный email</p>";
                        
                        //Возвращает пользователя на страницу регистрации
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: ".$address_site."/form_register.php");


                        exit();
                    }

                    //Проверяю нет ли уже такого адреса в БД.
                    $result_query = $mysqli->query("SELECT `email` FROM `users` WHERE `email`='".$email."'");
                    
                    //Если кол-во полученных строк ровно единице, значит пользователь с таким почтовым адресом уже зарегистрирован
                    if($result_query->num_rows == 1){

                        //Если полученный результат не равен false
                        if(($row = $result_query->fetch_assoc()) != false){
                             
                                $_SESSION["error_messages"] .= "<p class='mesage_error' >Пользователь с таким почтовым адресом уже зарегистрирован</p>";
                                

                                header("HTTP/1.1 301 Moved Permanently");
                                header("Location: ".$address_site."/form_register.php");
                            
                        }else{
 
                            $_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка в запросе к БД</p>";
                            
                            header("HTTP/1.1 301 Moved Permanently");
                            header("Location: ".$address_site."/form_register.php");
                        }

                        $result_query->close();

                        exit();
                    }

                    $result_query->close();
                }else
                {
                    $_SESSION["error_messages"] .= "<p class='mesage_error' >Укажите Ваш email</p>";
                    
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$address_site."/form_register.php");

                    exit();
                }

            }else{
                $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле для ввода Email</p>";
                
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_register.php");

                exit();
            }

            
            if(isset($_POST["password"])){

                $password = trim($_POST["password"]);

                if(!empty($password)){
                    $password = htmlspecialchars($password, ENT_QUOTES);

                    //Шифрует папроль
                    $password = md5($password."top_secret"); 
                }else{
                    $_SESSION["error_messages"] .= "<p class='mesage_error' >Укажите Ваш пароль</p>";
                    
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$address_site."/form_register.php");

                    exit();
                }

            }else{

                $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле для ввода пароля</p>";
                
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_register.php");

                exit();
            }

            //Запрос на добавления пользователя в БД
            $result_query_insert = $mysqli->query("INSERT INTO `users` (first_name, last_name, email, password) VALUES ('".$first_name."', '".$last_name."', '".$email."', '".$password."')");

            if(!$result_query_insert){
                $_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка запроса на добавления пользователя в БД</p>";
                
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_register.php");

                exit();
            }else{

                $_SESSION["success_messages"] = "<p class='success_message'>Регистрация прошла успешно!!! <br />Теперь Вы можете авторизоваться используя Ваш логин и пароль.</p>";

                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_auth.php");
            }

            $result_query_insert->close();

            $mysqli->close();
            
        }else{

            exit("<p><strong>Ошибка!</strong> Отсутствует проверечный код, то есть код капчи. Вы можете перейти на <a href=".$address_site."> главную страницу </a>.</p>");
        }

    }else{

        exit("<p><strong>Ошибка!</strong> Вы зашли на эту страницу напрямую, поэтому нет данных для обработки. Вы можете перейти на <a href=".$address_site."> главную страницу </a>.</p>");
    }

  
?>