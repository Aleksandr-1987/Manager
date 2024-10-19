<?php
$dbhost = "localhost";
$dbname = "my_test";
$username = "root";
$password = "";

$pdo = new PDO("mysql:host=$dbhost; dbname=$dbname", $username, $password);

if (isset($_GET['id'])) {
    $fileId = $_GET['id'];    
    
    $stmt = $pdo->prepare("SELECT * FROM files WHERE id = ?");
    $stmt->execute([$fileId]);
    $file = $stmt->fetch();

    if ($file) {
        if (file_exists($file['filepath'])) {
            $fileType = mime_content_type($file['filepath']);
            header("Content-Type: $fileType");
            readfile($file['filepath']);
            exit;
        } else {
            echo "Файл не найден.";
        }
    } else {
        echo "Запись не найдена.";
    }
} else {
    echo "ID файла не передан.";
}