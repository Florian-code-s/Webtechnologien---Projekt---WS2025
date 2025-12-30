<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
session_start();

if (!isset($_SESSION["logged_in"])) {
    $_SESSION["logged_in"] = false;
}

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
    $IsLoggedIn = true;
}


$page = $_GET['page'] ?? 'home';


$allowedPages = ['home', 'about', 'login', 'register', 'logout', 'finishedLessons', 'finishedLessonsDiagram', 'lessons', 'lesson_bg_color', 'changePassword', 'profile', 'wiki', 'wiki_selectors', 'wiki_box_model', 'wiki_flexbox', 'wiki_typography', 'lessonsEditor', 'lessonDetailEditor', 'exerciseDetailEditor'];
$adminPages = ['lessonsEditor', 'lessonDetailEditor', 'exerciseDetailEditor'];

if (!in_array($page, $allowedPages)) {
    $page = 'home';
}

if(in_array($page, $adminPages) && (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== 1)) {
    $page = 'home';
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . "/../pages/$page.php";
require_once __DIR__ . '/../includes/footer.php';
?>

</body>
</html>