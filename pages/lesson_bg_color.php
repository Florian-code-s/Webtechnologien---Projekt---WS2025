<?php


require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/lessonModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userId = (int)($_SESSION['user_id'] ?? 0);
if ($userId <= 0) {
    header("Location: ?page=login");
    exit;
}

$lessonId = getLessonIdByTitle($conn, 'Background Color');
if ($lessonId === null) die("Lesson nicht in DB");

startLesson($conn, $userId, $lessonId);

$progress = loadProgress($conn, $userId, $lessonId);
$isCompleted = ($progress && $progress['status'] === 'completed');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {

    $userAnswer = strtolower(trim($_POST['answer']));

    if (strpos($userAnswer, 'background-color') !== false &&
        strpos($userAnswer, 'red') !== false) {

        completeLesson($conn, $userId, $lessonId);
        $isCompleted = true;
        $message = 'Korrekt! Du hast die Lektion abgeschlossen!';
        $messageType = 'success';

    } else {
        // optional: Zwischenstand speichern (z.B. 50%)
        saveProgress($conn, $userId, $lessonId, 50, null);

        $message = 'Falsch! Der Code muss "background-color: red" enthalten.';
        $messageType = 'danger';
    }
}


$dataFile = __DIR__ . '/../data/lessons_bg_color.json';
$lessonData = null;
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $lessonData = json_decode($json, true);
}
if (!$lessonData) {
    $lessonData = [
        'title' => 'Background Color Lektion',
        'description' => 'Schreibe den CSS-Code, um diese Box rot zu färben.',
        'task_box_style' => 'background-color: red; width: 100%; height: 200px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center;',
        'info' => "Mit der CSS-Eigenschaft background-color kannst du die Hintergrundfarbe eines Elements setzen. Beispiel:\n.box {\n  background-color: red;\n}",
        'hint_link' => '?page=wiki'
    ];
}

?>

<section class="lessons container py-5">
  <div class="row mb-4">
    <div class="col">
      <a href="?page=lessons" class="btn btn-outline-secondary">&larr; Zurück zu Lektionen</a>
      <h1 class="display-6 mt-3"><?php echo htmlspecialchars($lessonData['title']); ?></h1>
      <p class="lead"><?php echo htmlspecialchars($lessonData['description']); ?></p>
    </div>
  </div>

  <div class="row">

   
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Aufgabe</h5>
        </div>
        <div class="card-body">
          
          
          <div style="<?php echo htmlspecialchars($lessonData['task_box_style']); ?>">
          </div>

          <?php
         
          include_once __DIR__ . '/../includes/lesson_admin.php';
          ?>
        </div>
      </div>
    </div>

    
    <div class="col-md-6">
      <div class="card">
        <div class="card-header bg-info text-white">
          <h5 class="mb-0">Dein CSS-Code</h5>
        </div>
        <div class="card-body">
          <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo htmlspecialchars($messageType); ?>" role="alert">
              <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
          <?php if ($isCompleted): ?>
            <div class="alert alert-success" role="alert">
              <h5 class="alert-heading">Lektion abgeschlossen!</h5>
              <p>Du hast die Lektion gemeistert!</p>
              <hr>
              <a href="?page=lessons" class="btn btn-success">Zu Lektionen zurück</a>
            </div>
          <?php else: ?>
            <form method="POST">
              <div class="mb-3">
                <label for="answer" class="form-label">Gib den CSS-Code ein:</label>
                <textarea class="form-control form-control-lg" id="answer" name="answer" 
                       placeholder="Bitte hier eingeben..." required autofocus rows="4"></textarea>
              
              </div>
              <button type="submit" class="btn btn-primary btn-lg w-100">Überprüfen</button>
            </form>
          <?php endif; ?>
        </div>
      </div>

      
      <div class="card mt-4">
        <div class="card-header bg-light" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#infoBox">
          <h5 class="mb-0">💡 Info <span style="float: right;">▼</span></h5>
        </div>
        <div class="collapse" id="infoBox">
          <div class="card-body">
            <p>
              <?php echo nl2br(htmlspecialchars($lessonData['info'])); ?>
            </p>
            <p class="mb-0">
              <a href="<?php echo htmlspecialchars($lessonData['hint_link']); ?>" class="btn btn-sm btn-outline-secondary">📚 Zum Wiki</a>
            </p>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


