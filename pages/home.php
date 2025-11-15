<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container my-5">
  <h1 class="text-primary fw-bold mb-4">Das ist die Startseite</h1>
  <?php
    require_once __DIR__ . "/../pages/lessons.php";
    require_once __DIR__ . "/../pages/finishedLessons.php";
  ?>
</div>

    
</body>
</html>