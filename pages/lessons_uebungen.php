<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/lessonModel.php';
require_once __DIR__ . '/../model/exerciseModel.php';

if (!isset($IsLoggedIn) || !$IsLoggedIn) {
    header("Location: ?page=login");
    exit;
}

$userId = (int)($_SESSION['user_id'] ?? 0);
$lessonId = (int)($_GET['id'] ?? 0);

if ($lessonId <= 0) {
    header("Location: ?page=home");
    exit;
}

$lesson = getLesson($conn, (string)$lessonId);
$exercises = getExercises($conn, (string)$lessonId);

if (!$lesson) {
    die("Lesson nicht gefunden");
}

// Lesson starten / Fortschritt initialisieren
startLesson($conn, $userId, $lessonId);
?>

<section class="container py-5">
  <a href="?page=home" class="btn btn-outline-secondary mb-3">← Zurück</a>

  <h1 class="mb-3"><?php echo htmlspecialchars($lesson['title']); ?></h1>
  <p class="lead"><?php echo htmlspecialchars($lesson['description']); ?></p>

  <?php if (empty($exercises)): ?>
    <div class="alert alert-info">Keine Übungen vorhanden.</div>
  <?php endif; ?>

  <?php foreach ($exercises as $exercise): ?>
    <div class="card mb-4">
      <div class="card-body">
        <h5><?php echo htmlspecialchars($exercise['title']); ?></h5>
        <p><?php echo htmlspecialchars($exercise['description']); ?></p>

        <!-- Aufgabe -->
        <div class="mb-3">
          <?php echo $exercise['box_html']; ?>
        </div>

        <!-- Eingabe -->
        <form method="post">
          <textarea class="form-control mb-2" name="answer" required></textarea>
          <button class="btn btn-primary">Antwort prüfen</button>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
</section>
