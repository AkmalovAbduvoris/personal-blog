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

$fetchPosts = function($currentPage) use ($db) {
    $postsPerPage = 2;
    $offset = ($currentPage - 1) * $postsPerPage;

    $postsCountStmt = $db->query("SELECT COUNT(*) AS posts_count FROM posts WHERE status = 'published'");
    $postsCount = $postsCountStmt->fetch()['posts_count'];
    $totalPages = ceil($postsCount / $postsPerPage);

    $stmt = $db->prepare("
        SELECT posts.id, title, text, name, created_at, updated_at 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        LIMIT :limit OFFSET :offset
    ");

    $stmt->bindValue(':limit', $postsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return [
        'posts' => $data,
        'totalPages' => $totalPages
    ];
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

$searchPosts = function($search, $status) use ($db) {
    $stmt = $db->prepare("SELECT posts.id, title, text, name, created_at, updated_at 
                          FROM posts 
                          JOIN users ON posts.user_id = users.id 
                          WHERE title LIKE :search
                          AND status LIKE :status");
    
    $like = "%$search%";
    $likeStatus = "%$status%";
    $stmt->bindParam(':search', $like, PDO::PARAM_STR);
    $stmt->bindParam(':status', $likeStatus, PDO::PARAM_STR);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
};


function paginate($totalPages, $currentPage) {
    echo "<div style='margin-top: 20px;'>";
    
    for ($page = 1; $page <= $totalPages; $page++) { 
        if ($currentPage == $page) {
            echo "<span style='margin-right:10px; font-weight:bold; color:red;'> $page </span>";
        } else {
            echo "<a href='?page=$page' style='margin-right:10px; text-decoration:none;'> $page </a>";
        }
    }
}