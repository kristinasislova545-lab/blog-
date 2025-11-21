<?php
include 'functions/auth.php';

//авторизация
if (!$isAdmin) {
    Die("Вы не админ");
}

$categories = json_decode(file_get_contents('data/categories.json'), true);


//CREATE
if (!empty($_POST)) {
    $posts = json_decode(file_get_contents('data/posts.json'), true);
    //добавляете пост в файл

    $title = htmlspecialchars($_POST['title']);
    $text = htmlspecialchars($_POST['text']);
    $category_id = (int)$_POST['category_id'];

    $errors = [];

    //Валидация
    if (empty($title)) {
        $errors['title'] = 'Заполните поле title';
    }
    if (empty($text)) {
        $errors['text'] = 'Заполните поле text';
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        //проверить файл
        $extensionMimeMap = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp'
        ];


        $maxFileSize = 5 * 1024 * 1024;

        if ($_FILES['image']['size'] > $maxFileSize) {
            $errors['image'] = 'Файл слишком большой';
        }
        $uploadDir = 'upload/';

        $fileName = $_FILES['image']['name'];

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $detectedMimeType = finfo_file($finfo, $_FILES['image']['tmp_name']);
        finfo_close($finfo);

        $ext = $extensionMimeMap[$fileExtension] ?? '';

        if ($ext !== $detectedMimeType) {
            $errors['image'] = 'Не правильный тип файла';
        }


        $safeFileName = uniqid() . '_' . date('Y-m-d_H-i-s') . '.' . $fileExtension;

        if (!isset($errors['image'])) {
            if  (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $safeFileName)) {
                $errors['image'] = 'Файл не загружен';
            }
        }


    }


    if (empty($errors)) {
        //создаем новый пост в массиве, id генерится автоматом
        $posts[] = [
            'category_id' => $category_id,
            'title' => $title,
            'text' => $text,
            'image' => $safeFileName ?? ''

        ];

        //добавляем сгенерированный id в массив
        $lastKey = array_key_last($posts);
        $posts[$lastKey]['id'] = $lastKey;

        //сделать красиво, чтобы id шел первым
        $posts[$lastKey] = array_merge(['id' => $lastKey], $posts[$lastKey]);



        file_put_contents('data/posts.json', json_encode($posts, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        //редирект методом GET
        header('Location: post.php?id=' . $lastKey . '&success=[1,2]');
        die();

    }

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Document</title>
</head>
<body>
<?php include 'parts/menu.php' ?>


<h2>Создать пост</h2>
<form action="" method="post" enctype="multipart/form-data">
    Заголовок поста:<br>
    <input type="text" name="title" value="<?= $_POST['title'] ?? '' ?>">
    <?php if (!empty($errors['title'])):?>
        <p style="color:red"><?=$errors['title']?></p>
    <?php endif;?>

    <br>
    Категория:<br>
    <select name="category_id">
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id'] ?>"
                <?= ($_POST['category_id'] ?? '') == $category['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($category['name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    Текст поста:<br>
    <textarea name="text" cols="30" rows="3"><?= $_POST['text'] ?? '' ?></textarea>
    <?php if (!empty($errors['text'])):?>
        <p style="color:red"><?=$errors['text']?></p>
    <?php endif;?>
    <br>
    <input type="file" name="image"><br>
    <?php if (!empty($errors['image'])):?>
        <p style="color:red"><?=$errors['image']?></p>
    <?php endif;?>
    <br>

    <input type="submit" value="Добавить">
</form>
</body>
</html>