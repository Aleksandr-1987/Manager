<?php
$dbhost = "localhost";
$dbname = "my_test";
$username = "root";
$password = "";

$stmt = new PDO("mysql:host=$dbhost; dbname=$dbname", $username, $password);

if (isset($_GET['id'])) {
    $edit = $stmt->prepare("SELECT * FROM files WHERE id = ?");
    $edit->execute([$_GET['id']]);
    $file = $edit->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newContent = $_POST['content'];
    file_put_contents($file['filepath'], $newContent);
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать файл</title>
</head>
<body>
    <h1>Редактирование файла: <?php echo $file['filename']; ?></h1>
    <form method="post">
        <textarea style="width: 600px; height: 400px" name="content"><?php echo htmlspecialchars(file_get_contents($file['filepath'])); ?></textarea>
        <button type="submit">Сохранить</button>
    </form>
</body>
</html>