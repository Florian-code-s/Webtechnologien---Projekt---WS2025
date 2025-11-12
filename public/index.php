<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

$IsLoggedIn = true;

$page = $_GET['page'] ?? 'home';

$allowedPages = ['home', 'about'];
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