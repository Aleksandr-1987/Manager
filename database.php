<?php
$dbhost = "localhost";
$dbname = "my_test";
$username = "root";
$password = "";

$stmt = new PDO("mysql:host=$dbhost; dbname=$dbname", $username, $password);

function get_files_all($sort_by = 'filename', $order = 'DESC') {
    global $stmt;
    $files = $stmt->query("SELECT * FROM files ORDER BY $sort_by $order");
    return $files;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
        $upload = $stmt->prepare("INSERT INTO files (filename, filepath) VALUES (?, ?)");
        $upload->execute([$file['name'], $uploadFile]);
        header('Location: index.php');
    } else {
        echo "Ошибка загрузки файла.";
    }
}

if (isset($_GET['id'])) {
    $some = $_GET['id'];
    $delete = $stmt->prepare("SELECT * FROM files WHERE id = ?");
    $delete->execute([$_GET['id']]);
    $file = $delete->fetch();

    if ($file) {
        unlink($file['filepath']);
        $stmt->prepare("DELETE FROM files WHERE id = ?")->execute([$_GET['id']]);
    }
    header('Location: index.php');
}
