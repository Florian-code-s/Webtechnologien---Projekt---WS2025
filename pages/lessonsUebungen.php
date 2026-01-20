
<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/lessonModel.php';
require_once __DIR__ . '/../model/exerciseModel.php';

/* Hier werden dynamisch die Lessons aus der DB geladen */
if (!isset($IsLoggedIn) || !$IsLoggedIn) {
    header("Location: ?page=login");
    exit;
}

$userId = (int) ($_SESSION['user_id'] ?? 0);
$lessonId = (int) ($_GET['id'] ?? 0);

if ($lessonId <= 0) {
    header("Location: ?page=home");
    exit;
}

$lesson = getLesson($conn, (string) $lessonId);
$exercises = getExercises($conn, (string) $lessonId);

if (!$lesson) {
    die("Lesson nicht gefunden");
}

// Lesson starten 
startLesson($conn, $userId, $lessonId);

$feedback = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exerciseId = (int) ($_POST['exercise_id'] ?? 0);
    $answer = trim((string) ($_POST['answer'] ?? ''));

    if ($exerciseId > 0 && $answer !== '') {
        $ex = getExerciseById($conn, $exerciseId);

        if ($ex) {
            $userAnswer = strtolower(preg_replace('/\s+/', ' ', $answer));
            $correct = strtolower(preg_replace('/\s+/', ' ', (string) $ex['correct_answer']));

            if ($correct !== '' && strpos($userAnswer, $correct) !== false) {
                $feedback[$exerciseId] = ['type' => 'success', 'msg' => 'Richtig!'];
                saveProgress($conn, $userId, $lessonId, 100);
                completeLesson($conn, $userId, $lessonId);
            } else {
                $feedback[$exerciseId] = ['type' => 'danger', 'msg' => 'Falsch prüfe deine Lösung.'];
            }
        } else {
            $feedback[$exerciseId] = ['type' => 'danger', 'msg' => 'Exercise nicht gefunden.'];
        }
    }
}


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
                <?php
                $exId = (int) $exercise['id'];
                ?>

                <?php if (isset($feedback[$exId])): ?>
                    <div class="alert alert-<?php echo $feedback[$exId]['type']; ?>">
                        <?php echo $feedback[$exId]['msg']; ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="?page=lessonsUebungen&id=<?php echo (int) $lessonId; ?>">
                    <input type="hidden" name="exercise_id" value="<?php echo $exId; ?>">

                    <textarea class="form-control mb-2" name="answer" required></textarea>

                    <button class="btn btn-primary" type="submit">
                        Prüfen
                    </button>
                    <?php if (isset($exercise['hint_link']) && strcmp($exercise['hint_link'], "") !== 0): ?> <a
                            href="<?php echo htmlspecialchars($exercise['hint_link']); ?>"
                            target="_blank"
                            class="btn btn-secondary">Hinweis öffnen</a>
                    <?php endif; ?>                  
                </form>

            </div>
        </div>
    <?php endforeach; ?>
</section>