<?php


$isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) || (isset($_SESSION['user']) && strtolower($_SESSION['user']) === 'admin');
if (!$isAdmin) {
    http_response_code(403);
    echo "Zugriff verweigert. Nur für Admins.";
    exit;
}

$lesson = $_GET['lesson'] ?? 'bg_color';
$dataFile = __DIR__ . '/../data/lessons_' . preg_replace('/[^a-z0-9_\-]/i', '', $lesson) . '.json';


$default = [
    'title' => 'Background Color Lektion',
    'description' => 'Schreibe den CSS-Code, um diese Box rot zu färben.',
    'task_box_style' => 'background-color: red; width: 100%; height: 200px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center;',
    'info' => "Mit der CSS-Eigenschaft background-color kannst du die Hintergrundfarbe eines Elements setzen. Beispiel:\n.box {\n  background-color: red;\n}",
    'hint_link' => '?page=wiki'
];

if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $data = json_decode($json, true) ?: $default;
} else {
    $data = $default;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['title'] = $_POST['title'] ?? $data['title'];
    $data['description'] = $_POST['description'] ?? $data['description'];
    $data['task_box_style'] = $_POST['task_box_style'] ?? $data['task_box_style'];
    $data['info'] = $_POST['info'] ?? $data['info'];
    $data['hint_link'] = $_POST['hint_link'] ?? $data['hint_link'];

    if (file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))) {
        $message = 'Änderungen gespeichert.';
    } else {
        $message = 'Fehler beim Speichern.';
    }
}
?>

<section class="container py-5">
  <div class="row">
    <div class="col-md-8 mx-auto">
      <h1 class="mb-4">Aufgabe bearbeiten: <?php echo htmlspecialchars($lesson); ?></h1>
      <?php if ($message): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Titel</label>
          <input class="form-control" name="title" value="<?php echo htmlspecialchars($data['title']); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Kurzbeschreibung</label>
          <input class="form-control" name="description" value="<?php echo htmlspecialchars($data['description']); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Box Style (inline CSS)</label>
          <input class="form-control" name="task_box_style" value="<?php echo htmlspecialchars($data['task_box_style']); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Info-Text</label>
          <textarea class="form-control" name="info" rows="6"><?php echo htmlspecialchars($data['info']); ?></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Hint Link</label>
          <input class="form-control" name="hint_link" value="<?php echo htmlspecialchars($data['hint_link']); ?>">
        </div>
        <button class="btn btn-primary" type="submit">Speichern</button>
        <a class="btn btn-secondary" href="?page=lesson_bg_color">Zurück</a>
      </form>
    </div>
  </div>
</section>
