<?php


$lessonId = 'bg_color';
$completedLessons = isset($_COOKIE['completed_lessons']) ? json_decode($_COOKIE['completed_lessons'], true) : [];
$isCompleted = in_array($lessonId, $completedLessons);
$message = '';
$messageType = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
    $userAnswer = trim(strtolower(preg_replace('/\s+/', ' ', $_POST['answer'])));
    if (strpos($userAnswer, 'background-color') !== false && strpos($userAnswer, 'red') !== false) {
        if (!in_array($lessonId, $completedLessons)) {
            $completedLessons[] = $lessonId;
            setcookie('completed_lessons', json_encode($completedLessons), time() + (86400 * 365), '/');
            $_COOKIE['completed_lessons'] = json_encode($completedLessons);
        }
        $message = 'Korrekt! Du hast die Lektion abgeschlossen!';
        $messageType = 'success';
        $isCompleted = true;
    } else {
        $message = 'Falsch! Der Code muss background-color: red enthalten.';
        $messageType = 'danger';
    }
}
?>

<section class="lessons container py-5">
  <div class="row mb-4">
    <div class="col">
      <a href="?page=lessons" class="btn btn-outline-secondary">&larr; Zurück zu Lektionen</a>
      <h1 class="display-6 mt-3">Background Color Lektion</h1>
      <p class="lead">Schreibe den CSS-Code, um diese Box rot zu färben.</p>
    </div>
  </div>

  <div class="row">

    <!-- Aufgabenbereich -->
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Aufgabe</h5>
        </div>
        <div class="card-body">
          
          
          <div style="background-color: red; width: 100%; height: 200px; border-radius: 8px; 
                      box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center;">
          </div>
        </div>
      </div>
    </div>

    
    <div class="col-md-6">
      <div class="card">
        <div class="card-header bg-info text-white">
          <h5 class="mb-0">Dein CSS-Code</h5>
        </div>
        <div class="card-body">
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
              Mit der CSS-Eigenschaft <code>background-color</code> kannst du die Hintergrundfarbe eines Elements setzen.
            </p>
            <pre><code>.box {
  background-color: red;
}</code></pre>
            <p class="mb-0">
              <a href="?page=wiki" class="btn btn-sm btn-outline-secondary">📚 Zum Wiki</a>
            </p>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
