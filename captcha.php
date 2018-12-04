<?php
    session_start();
    // Генерирует случайное число.
    $rand = mt_rand(1000, 9999);

    // Сохраняет значение переменной  $rand ( капчи ) в сессию
    $_SESSION["rand"] = $rand;

    //Черно-белое изображение
    $im = imageCreateTrueColor(90,50);

    //Белый цвет для текста
    $c = imageColorAllocate($im, 255, 255, 255);

    // Записывает полученное случайное число на изображение
    imageTtfText($im, 20, -10, 10, 30, $c, "fonts/verdana.ttf", $rand);

    header("Content-type: image/png");

    imagePng($im);

    imageDestroy($im);

    
?>