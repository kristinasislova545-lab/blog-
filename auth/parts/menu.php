<?php
$currentColor = $_COOKIE['site_color'] ?? '#ffffff';
?>
<style>
    body {
        background-color: <?= $currentColor ?>;
        transition: background-color 0.3s;
    }
</style>

<nav>
    <a href="index.php">Калькулятор</a> | 
    <a href="posts.php">Посты</a> | 
    <a href="cookies.php">Счетчик и цвет</a> | 
    <a href="functions/logout.php">Выход</a>
</nav>