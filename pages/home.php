<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>

<div class="container mt-5">

<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/lessonModel.php';

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true):

    $userId = (int)($_SESSION['user_id'] ?? 0);

    $totalLessons = countAllLessons($conn);

    $completedLessons = countCompletedLessons($conn, $userId);

    $progressPercent = $totalLessons > 0
        ? ($completedLessons / $totalLessons) * 100
        : 0;
?>

  <!-- DASHBOARD -->
  <div class="mb-5">
    <h2 class="fw-bold text-primary mb-3">Dein Lernfortschritt</h2>

    <div class="d-flex justify-content-between mb-1">
      <span>Abgeschlossen</span>
      <span class="fw-semibold">
        <?php echo $completedLessons; ?> / <?php echo $totalLessons; ?>
      </span>
    </div>

    <div class="progress" style="height: 25px;">
      <div class="progress-bar bg-success"
           role="progressbar"
           style="width: <?php echo $progressPercent; ?>%;"
           aria-valuenow="<?php echo $completedLessons; ?>"
           aria-valuemin="0"
           aria-valuemax="<?php echo $totalLessons; ?>">
        <?php echo round($progressPercent); ?>%
      </div>
    </div>
  </div>

<?php
endif;

require_once __DIR__ . "/../pages/lessons.php";
?>

</div>

</body>
</html>
