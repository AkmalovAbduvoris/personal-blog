Personal Blog

This is a simple personal blog application built with PHP. It allows users to create, edit, and delete posts. The application uses a MySQL database for storing posts and user information.

Steps to Install

1.Clone the repository to your local machine:

    git clone https://github.com/AkmalovAbduvoris/personal-blog.git

2.Navigate to the project directory:

    cd personal-blog

3.Set up your database:

    mv credentials.example.php credentials.php

 change

    <?php
    $dbPassword = 'your_password';
    $dbUser = 'your_username';
    $database = 'your_databese_name';

4.Запусти встроенный сервер PHP:

    php -S localhost:8000
