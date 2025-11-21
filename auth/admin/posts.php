<?php
include '../functions/auth.php';

//авторизация
if (!$isAdmin) {
    Die("Вы не админ");
}

$posts = json_decode(file_get_contents('../data/posts.json'), true);
$success = $_GET['success'] ?? null;


if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'] ?? null;
    if ($id === null || !array_key_exists($id, $posts)) {

        if (isset($_GET['ajax'])) {
            $response = [
                'success' => false
            ];
            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            die();
        }

        header('Location: ?success=2');
        die();
    }

    unset($posts[$id]);

    file_put_contents('../data/posts.json', json_encode($posts, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

    if (isset($_GET['ajax'])) {
        $response = [
            'success' => true,
            'id' => $id
        ];
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        die();
    }
    header('Location: ?success=1');
    die();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php include '../parts/menu.php' ?>

<?php if ($success === "2"): ?>
    <p style="color:red">Ошибка удаления</p>
<?php endif; ?>
<div id="message"></div>
<?php if ($success === "1"): ?>
    <p style="color:green">Пост удален</p>
<?php endif; ?>

<h2>Посты</h2>
<a href="/create-post.php">Создать пост</a><br><br>
<?php foreach ($posts as $post): ?>
    <div id="<?= htmlspecialchars($post['id']) ?>">
        <a href="edit-post.php?action=edit&id=<?= htmlspecialchars($post['id']) ?>">[edit]</a>
        <button class="delete-btn" data-id="<?= htmlspecialchars($post['id']) ?>">X</button>
        <a href="posts.php?action=delete&id=<?= htmlspecialchars($post['id']) ?>"
           onclick="return confirm('Вы уверены, что хотите удалить пост ?')">[X]</a>
        <a href="post.php?id=<?= htmlspecialchars($post['id']) ?>">
            <b><?= htmlspecialchars($post['title']) ?></b>
        </a>
    </div>
<?php endforeach; ?>

<script>
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', async () => {

            if (!confirm('Вы уверены, что хотите удалить пост ?')) {
                return
            }
            try {
                const id = button.getAttribute('data-id');
                const response = await fetch('posts.php?action=delete&ajax&id=' + id);
                const answer = await response.json();
                if (answer.success) {
                    document.getElementById(answer.id).remove();
                    document.getElementById('message').innerHTML = '<p style="color:green">Пост удален</p>';
                } else {
                    document.getElementById('message').innerHTML = '<p style="color:red">Ошибка удаления поста</p>';
                }

            } catch (error) {
                console.log('error')
            }

        })
    });

</script>
</body>
</html>