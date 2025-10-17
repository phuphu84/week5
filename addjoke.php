<?php
include 'includes/DatabaseConnection.php';

if (isset($_POST['joketext']) && $_POST['joketext'] !== '') {
    $imagePath = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
  
        $uploadDir = 'images/';
        $absoluteUploadDir = dirname(__FILE__) . '/' . $uploadDir;
        
      
        if (!file_exists($absoluteUploadDir)) {
            mkdir($absoluteUploadDir, 0777, true);
        }

      
        $fileName = basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
       
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $uniqueFileName = uniqid() . '_' . $fileName;
            $uploadFile = $absoluteUploadDir . $uniqueFileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $imagePath = $uniqueFileName;
            }
        }
    }

    try {
        $sql = 'INSERT INTO jokes (joketext, jokedate, image_path) 
                VALUES (:joketext, CURDATE(), :image_path)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':joketext', $_POST['joketext']);
        $stmt->bindValue(':image_path', $imagePath);
        $stmt->execute();
        header('Location: jokes.php');
        exit;
    } catch (PDOException $e) {
        $title = 'Database error';
        $output = 'Database error: ' . $e->getMessage();
    }
} else {
    $title = 'Add a new joke';
    ob_start();
    include 'templates/addjoke.html.php';
    $output = ob_get_clean();
}
include 'templates/layout.html.php';
