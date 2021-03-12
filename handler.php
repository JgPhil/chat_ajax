<?php

$dsn = 'mysql:dbname=chat;host=127.0.0.1';
$user = 'phil';
$password = '!ù:m;l';

if (!isset($pdo)) {
    try {
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
    }
}

$task = 'read';

if ($_GET['action']) {
    $task = $_GET['action'];
}

if ($task === 'write') {
    postMessage();
} else {
    getMessages();
}

function getMessages()
{
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM messages ORDER BY created_at DESC');
    $messages = $stmt->fetchAll();
    echo json_encode($messages);
}

function postMessage()
{
    global $pdo;
    try {
        $author = $_POST['author'];
        $content = $_POST['content'];
        $stmt = $pdo->prepare('INSERT INTO messages SET author=:author, content=:content, created_at=NOW();');
        $stmt->execute([
            'author' => $author,
            'content' => $content
        ]);
        echo json_encode([
            'status' => 'success'
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'error' => 'Un problème est survenu'
        ]);
    }
}
