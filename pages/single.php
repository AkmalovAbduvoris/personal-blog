<?php
require "../controllers/post_controller.php";

if(isset($_POST['id'])) {
    $id = $_POST['id'];
}
    $item = $singlePost($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="container">
        <ul>
            <li class="header__list">
                <a href="/">Home</a>
            </li>
        </ul>
        </div>
    </header>
    <div class="container">
    <?php
                    echo "
                    <li class='item'>
                    <h2>{$item['title']}</h2>
                    <p>{$item['text']}</p>
                    <div class='wrap'>
                    <p>{$item['created_at']}</p>
                    </div>
                    </li>";
    ?>
    </div>
</body>
</html>