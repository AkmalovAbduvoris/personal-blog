<?php
    require "../controllers/user_controller.php";
    require "../controllers/post_controller.php";

    $title = isset($_POST['title']) ? $_POST['title'] : null;
    $text = isset($_POST['text']) ? $_POST['text'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;

    $userId = $findUserId();

    if($text != null && $title != null) {
        $createPost($title,$text,$status,$userId);
    }
    
    if (isset($_POST['newTitle'],$_POST['newText'],$_POST['newId'],$_POST['newStatus'])){
        $newTitle = $_POST['newTitle'];
        $newText = $_POST['newText'];
        $newStatus = $_POST['newStatus'];
        $id =$_POST['newId'];
        $editPost($newTitle, $newText, $newStatus, $id);
    }

    if (isset($_POST['deleteId'])) {
        $deletePost();
    }

    $data = $userPost($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <div class="container">
        <ul class="header__list">
            <li>
                <a href="/">Home</a>
            </li>
            <!-- <li>
                <a href="?delete_cookie=1">Log out</a>
            </li> -->
        </ul>
    </div>
        </header>
    <div class="container">
        <form class="form" action="user.php" method="post">
            <input type="text" name="title" id="" placeholder="Sarlavhani yozing">
            <input type="text" name="text" id="" placeholder="Text qo'shing">
            <select name="status" id="">
                <option value="drafted">Drafted</option>
                <option value="published">Published</option>
            </select>
            <button class="" type="submit">Add task</button>
        </form>
        <ul>
        <?php
            if(count($data) > 0) {
                foreach($data as $item) {
                    echo "
                    <li class='item'>
                    <h2>{$item['title']}</h2>
                    <p>{$item['text']}</p>
                    <p>Created: {$item['created_at']}</p>
                    <p>Updated: {$item['updated_at']}</p>
                    <div style='display: flex;gap: 5px;'>
                    <form action='/pages/edit_post.php' method='post'>
                    <input type='hidden' name='id' value='{$item['id']}'>
                    <button class='edit'>Edit</button>
                    </form>
                     <form action='user.php' method='post'>
                    <input type='hidden' name='deleteId' value='{$item['id']}'>
                    <button class='delete'>Delete</button>
                    </form>
                    </div>
                    <h4 style='margin-top: 10px;'>{$item['status']}</h4>
                    </li>";
                }
            } else {
                echo "<h1>Please add a Blog.</h1>";
            }
            ?>
        </ul>
    </div>
</body>
</html>