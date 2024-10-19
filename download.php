<?php
$dbhost = "localhost";
$dbname = "my_test";
$username = "root";
$password = "";

$pdo = new PDO("mysql:host=$dbhost; dbname=$dbname", $username, $password);

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM files WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $file = $stmt->fetch();

    if ($file) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file['filepath']) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file['filepath']));
        readfile($file['filepath']);
        exit;
    }
}