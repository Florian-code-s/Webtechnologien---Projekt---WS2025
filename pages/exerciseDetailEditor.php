<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/exerciseModel.php';

if (!$IsLoggedIn || !isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== 1) {
    header("Location: ./?page=login");
    $conn->close();
    exit();
}

$exercise = [];

if (!isset($_GET["id"]) || !isset($_GET["lessonId"])) {
    header("Location: ?page=home");
    $conn->close();
    exit();
}

// Löschen von Exercise
if (isset($_GET["delete"]) && strcmp($_GET["delete"], "1") === 0) {
    deleteExercise($conn, $_GET["id"]);
    header("Location: ?page=lessonDetailEditor&id=" . htmlspecialchars($_GET["lessonId"]));
    $conn->close();
    exit();
}

// Erstellen oder Bearbeiten von Exercise
if (isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["boxHtml"]) && isset($_POST["infoText"]) && isset($_POST["hintLink"]) && isset($_POST["correctAnswer"])) {
    if (strcmp($_GET["id"], "") === 0) {
        createExercise($conn, trim($_POST["title"]), trim($_POST["description"]), $_POST["boxHtml"], trim($_POST["infoText"]), $_POST["hintLink"], $_POST["correctAnswer"], $_GET["lessonId"]);
    } else {
        modifyExercise($conn, $_GET["id"], trim($_POST["title"]), trim($_POST["description"]), $_POST["boxHtml"], trim($_POST["infoText"]), $_POST["hintLink"], $_POST["correctAnswer"]);
    }
    header("Location: ?page=lessonDetailEditor&id=" . htmlspecialchars($_GET["lessonId"]));
    $conn->close();
    exit();
}

// Laden von Exercise
$exercise = getExercise($conn, $_GET["id"]);

$conn->close();
?>

<section class="container my-5 editor">
    <div class="">
        <h2 class="mb-4 mt-2 editor__title">Exercise Detail Editor</h2>
        <div>
            <form
                action="./?page=exerciseDetailEditor&lessonId=<?php echo htmlspecialchars($_GET["lessonId"]); ?>&id=<?php echo isset($exercise["id"]) ? htmlspecialchars($exercise["id"]) : ""; ?>"
                method="POST">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Titel"
                        value="<?php echo isset($exercise["title"]) && $exercise["title"] ? htmlspecialchars($exercise["title"]) : ''; ?>"
                        maxlength="100" required>
                    <label for="title">Titel</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="description" name="description" placeholder="Beschreibung"
                        maxlength="1000" required
                        rows="3"><?php echo isset($exercise["description"]) && $exercise["description"] ? htmlspecialchars($exercise["description"]) : ''; ?></textarea>
                    <label for="description">Beschreibung</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="boxHtml" name="boxHtml"
                        placeholder="Box HTML (HTML inkl. inline CSS zur Anzeige bei der Aufgabe)" maxlength="1000"
                        required
                        rows="3"><?php echo isset($exercise["box_html"]) && $exercise["box_html"] ? htmlspecialchars($exercise["box_html"]) : ''; ?></textarea>
                    <label for="boxHtml">Box HTML (HTML inkl. inline CSS zur Anzeige bei der Aufgabe)</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="infoText" name="infoText" placeholder="Info" maxlength="1000"
                        required
                        rows="3"><?php echo isset($exercise["info_text"]) && $exercise["info_text"] ? htmlspecialchars($exercise["info_text"]) : ''; ?></textarea>
                    <label for="infoText">Info</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="hintLink" name="hintLink" placeholder="Hint Link"
                        value="<?php echo isset($exercise["hint_link"]) && $exercise["hint_link"] ? $exercise["hint_link"] : ''; ?>"
                        maxlength="255">
                    <label for="hintLink">Hint Link</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="correctAnswer" name="correctAnswer"
                        placeholder="Richtige Antwort"
                        value="<?php echo isset($exercise["correct_answer"]) && $exercise["correct_answer"] ? htmlspecialchars($exercise["correct_answer"]) : ''; ?>"
                        maxlength="255" required>
                    <label for="correctAnswer">Richtige Antwort</label>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2 mb-3">
                    <button type="submit" class="btn btn-primary editor__button">Speichern</button>
                    <?php if (strcmp($_GET["id"], "") !== 0): ?> <a
                            href="./?page=exerciseDetailEditor&delete=1&lessonId=<?php echo htmlspecialchars($_GET["lessonId"]); ?>&id=<?php echo htmlspecialchars($exercise["id"]); ?>"
                            class="btn btn-danger">Löschen</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</section>