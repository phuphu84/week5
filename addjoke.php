<?php
include 'includes/DatabaseConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $joketext = trim($_POST['joketext'] ?? '');

    if ($joketext === '') {
        die('Please enter a joke text.');
    }
    $uploadDir = __DIR__ . '/images/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

$imageName = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tmp  = $_FILES['image']['tmp_name'];
    $ext  = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) die('Invalid type');
    $imageName = uniqid('joke_', true).'.'.$ext;
    move_uploaded_file($tmp, $uploadDir.$imageName);
}

$stmt = $pdo->prepare('INSERT INTO jokes (joketext, jokedate, image) VALUES (:t, CURDATE(), :img)');
$stmt->execute([':t'=>$joketext, ':img'=>$imageName]);


    header('Location: jokes.php');
    exit;
}
