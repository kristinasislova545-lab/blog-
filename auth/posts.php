<?php
include 'functions/auth.php';

$posts = json_decode(file_get_contents('data/posts.json'), true);


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php include 'parts/menu.php' ?>


<h2>Посты</h2>

<?php foreach ($posts as $post): ?>

    <a href="post.php?id=<?= htmlspecialchars($post['id']) ?>">
        <b><?= htmlspecialchars($post['title']) ?></b>
    </a><br>

<?php endforeach; ?>

</body>
</html>