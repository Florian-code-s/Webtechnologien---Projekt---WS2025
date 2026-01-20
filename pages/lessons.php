<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/lessonModel.php';

// Show lessons only for logged-in users. `$IsLoggedIn` is set in `public/index.php`.
if (isset($IsLoggedIn) && $IsLoggedIn):

    $userId = (int)($_SESSION['user_id'] ?? 0);
    if ($userId <= 0) {
        ?>
        <section class="container py-5">
          <div class="alert alert-danger" role="alert">
            user_id fehlt in der Session. Bitte neu einloggen.
          </div>
        </section>
        <?php
        $conn->close();
        exit;
    }

    // Alle Lessons + Status/Progress für den User
    $lessons = getLessonsWithStatus($conn, $userId);

    $totalLessons = count($lessons);
    $completedCount = 0;

    foreach ($lessons as $l) {
        if (($l['status'] ?? '') === 'completed') {
            $completedCount++;
        }
    }

    $progressPercentage = $totalLessons > 0 ? ($completedCount / $totalLessons) * 100 : 0;
    ?>

    <section class="lessons container py-5">
      <div class="row mb-4">
        <div class="col">
          <h1 class="text-primary fw-bold mb-4">CSS Lektionen</h1>
          <p class="lead">Beherrsche CSS-Grundlagen mit interaktiven Aufgaben.</p>

          
        </div>
      </div>

      <div class="row">
        <div class="col-md-8 mx-auto">

          <?php if ($totalLessons === 0): ?>
            <div class="alert alert-info" role="alert">
              Es wurden noch keine Lessons angelegt.
            </div>
          <?php else: ?>

            <?php foreach ($lessons as $lesson): 
                $status = $lesson['status'] ?? 'not_started';
                $percent = (int)($lesson['progress_percent'] ?? 0);

                $isCompleted = ($status === 'completed');
                $isInProgress = ($status === 'in_progress');
                $borderColor = $isCompleted ? '#28a745' : '#007bff';

                
                $icon = '❌';
                if ($isCompleted) $icon = '✅';
                else if ($isInProgress) $icon = '🟡';

                $href = '?page=lessons_uebungen&id=' . (int)$lesson['id'];
            ?>

              <div class="card mb-3" style="border: 2px solid <?php echo $borderColor; ?>;">
                <a href="<?php echo $href; ?>" class="card-link text-decoration-none">
                  <div class="card-body">
                    <h5 class="card-title">
                      <?php echo $icon; ?>
                      <?php echo htmlspecialchars($lesson['title']); ?>
                    </h5>

                    <p class="card-text"><?php echo htmlspecialchars($lesson['description']); ?></p>

                    <small class="text-muted">
                      <?php
                        if ($isCompleted) echo 'Abgeschlossen';
                        else if ($isInProgress) echo 'In Bearbeitung (' . $percent . '%)';
                        else echo 'Nicht gestartet';
                      ?>
                    </small>
                  </div>
                </a>
              </div>

            <?php endforeach; ?>

          <?php endif; ?>

        </div>
      </div>
    </section>

<?php else: ?>
    <section class="container py-5">
      <div class="row">
        <div class="col-md-8 mx-auto text-center">
          <div class="alert alert-info" role="alert">
            Bitte melde dich an, um die Lektionen und deinen Fortschritt zu sehen.
            <div class="mt-3">
              <a href="?page=login" class="btn btn-primary">Zum Login</a>
            </div>
          </div>
        </div>
      </div>
    </section>
<?php endif;

$conn->close();
?>
