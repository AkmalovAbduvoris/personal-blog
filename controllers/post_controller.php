<?php
require  __DIR__ . '/../db.php';

$deletePost = function()use ($db) {
    $id = $_POST['deleteId'];
    $stmt = $db->prepare("DELETE FROM  posts WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
};

$editPost = function($newTitle, $newText, $newStatus, $id) use ($db) {
    $stmt = $db->prepare("UPDATE posts SET title = :title, text = :text, status = :status WHERE id = :id");
    $stmt->bindParam(':title', $newTitle);
    $stmt->bindParam(':text', $newText);
    $stmt->bindParam(':status', $newStatus);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
};

$fetchPosts = function()  use ($db) {
    $data = $db->query("SELECT posts.id, title, text, name, created_at, updated_at FROM posts JOIN users on posts.user_id = users.id WHERE status = 'published'")->fetchAll(PDO::FETCH_ASSOC); 
    
    return $data;
};

$createPost = function($title, $text, $status, $userId) use ($db) {
    $stmt = $db->prepare("INSERT INTO posts(title, text, status, user_id) VALUES(:title, :text, :status, :user_id)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':text', $text);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
};

$getPostById = function($id) use ($db) {
    $data = $db->query("SELECT * FROM posts WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
    return $data;
};

$singlePost = function($id) use ($db) {
    $item = $db->query("SELECT * FROM posts WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
    return $item;
};