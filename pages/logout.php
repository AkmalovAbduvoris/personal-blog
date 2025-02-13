<?php

// TODO:
// 1. Destroy session
// 2. Redirect to login page
session_start();
session_destroy();
header('Location: /pages/login.php');