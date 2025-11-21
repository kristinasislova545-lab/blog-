<?php
include 'functions/auth.php';
//READ
const STATUSES = [
    'ok' => 'Пост успешно создан',
    'info' => 'Поздравляю',
];


$posts = json_decode(file_get_contents('data/posts.json'), true);
$id = (int)$_GET['id'];
$post = $posts[$id] ?? null;

$success = STATUSES[($_GET['success'] ?? null)] ?? null;


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php include 'parts/menu.php' ?>

<?php if (!empty($success)): ?>
    <p style="color:green"><?=$success?></p>
<?php endif; ?>



<?php if (!is_null($post)): ?>
    <h2><?= htmlspecialchars($post['title']) ?></h2>
    <div>
        <p>
            <?php if (!empty($post['image'])): ?>
                <img src="/upload/<?=$post['image']?>" alt="" width="200"><br>
            <?php endif;?>
            <?= htmlspecialchars($post['text']) ?></p>
    </div>
<?php else: ?>
    Нет поста
<?php endif; ?>
</body>
</html>