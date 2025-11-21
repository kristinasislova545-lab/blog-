<?php
include 'functions/auth.php';
include 'functions/calc.php';

$result = 0;
$arg1 = 0;
$arg2 = 0;
$currentColor = $_COOKIE['site_color'] ?? '#ffffff';

if (!empty($_POST)) {
    $arg1 = (float)($_POST['arg1'] ?? 0);
    $arg2 = (float)($_POST['arg2'] ?? 0);
    $operation = $_POST['operation'] ?? '';
    $result = calculate($arg1, $arg2, $operation);
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
<?php include 'parts/menu.php' ?>

<br>
<form action="" method="post">
    <input type="text" name="arg1" size="5" value="<?=$arg1?>">
                      <input type="submit" name="operation" value="add">
                      <input type="submit" name="operation" value="sub">
                      <input type="submit" name="operation" value="mul">
                      <input type="submit" name="operation" value="div">
    <input type="text" name="arg2" size="5" value="<?=$arg2?>">
                     =
    <input type="text" readonly size="15" value="<?=$result?>">
</form>
</body>
</html>