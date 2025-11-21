<?php
include 'functions/auth.php';

// Счетчик посещений
if (isset($_COOKIE['counter'])) {
    $counter = $_COOKIE['counter'] + 1;
} else {
    $counter = 0;
}
setcookie('counter', $counter, time() + 36000, '/');

// Обработка цвета сайта
$currentColor = $_COOKIE['site_color'] ?? '#ffffff';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['site_color'])) {
    $color = $_POST['site_color'];
    if (preg_match('/^#[a-f0-9]{6}$/i', $color)) {
        setcookie('site_color', $color, time() + 36000, '/');
        $currentColor = $color;
        $message = 'Цвет сохранен!';
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        body {
            background-color: <?= $currentColor ?>;
        }
    </style>
</head>
<body>
<?php include 'parts/menu.php' ?><br>

<?php if ($message): ?>
    <p style="color: green;"><?= $message ?></p>
<?php endif; ?>

Число посещений страницы: <?= $counter ?>.

<h3>Настройка цвета сайта</h3>
<form method="post">
    <label>Выберите цвет фона:</label>
    <input type="color" name="site_color" value="<?= $currentColor ?>">
    <input type="submit" value="Сохранить цвет">
</form>

</body>
</html>

