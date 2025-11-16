<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

if (!isset($_SESSION["logged_in"])) {
    $_SESSION["logged_in"] = false;
}




$page = $_GET['page'] ?? 'home';

$allowedPages = ['home', 'about', 'login', 'register', 'logout', 'finishedLessons', 'lessons', 'changePassword'];
if (!in_array($page, $allowedPages)) {
    $page = 'home';
}



require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . "/../pages/$page.php";
require_once __DIR__ . '/../includes/footer.php';
?>

</body>
</html>