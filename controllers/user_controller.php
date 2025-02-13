<?php
require  __DIR__ . '/../db.php';

$loginUser = function($email, $password) use ($db) {
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    
    $user = $stmt->fetch();

    if ($user && $password == $user['password']) {
      $_SESSION['email'] = $user['email'];
        return $user;
    }
    
    return null;
};

$registerUser = function($name, $email, $password) use ($db) {
    $user = $db->prepare("SELECT * FROM users WHERE name = :name AND email = :email AND password = :password");
    $user->execute([
        'name' => $name,
        'email' => $email,
        'password' => $password
    ]);
    $user = $user->fetchAll();
    if(!$user) {
        $stmt = $db->prepare("INSERT INTO users(name, email ,password) VALUES (:name, :email ,:password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        return true;
    }else {
        return false;
    }
};

$findUserId = function() use ($db) {
    if(isset($_COOKIE['user'])) {
        $userName = $_COOKIE['user'];
        $user = $db->query("SELECT * FROM users WHERE name = '$userName'")->fetch();
        $userId = $user['id'];
        return $userId;
    }
};

$userPost = function($id) use ($db) {
    $stmt = $db->prepare("SELECT id, title, created_at, updated_at, user_id, status, text FROM posts WHERE user_id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetchAll();
    return $data;
};