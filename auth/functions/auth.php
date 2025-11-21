<?php
session_start();

$isAdmin = false;

if (isset($_SESSION['isAdmin'])) {
    $isAdmin = $_SESSION['isAdmin'];
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['isAdmin']);
    session_destroy();
    header('Location: index.php');
    die();
}

if (isset($_GET['action']) && $_GET['action'] === 'login') {
    //Аутентификация
    $login = $_POST['login'];
    $password = $_POST['password'];
    if ($login === 'admin' && password_verify($password, '$2y$10$QnGcqXj3ClVGh/M.C7c8JuKrooNwkOCxSG3ZGdFo5NaPu/zYPK0Xq')) {
        $isAdmin = true;
        $_SESSION['isAdmin'] = true;
        header('Location: index.php');
        die();
    } else {
        die("Не верный логин-пароль");
    }
}