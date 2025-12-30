<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/exerciseModel.php';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

$exercise = [];

if (!isset($_GET["id"]) || !isset($_GET["lessonId"])) {
    header("Location: ?page=home");
}

// Löschen von Exercise
if (isset($_GET["delete"]) && strcmp($_GET["delete"], "1") === 0) {
    deleteExercise($conn, $_GET["id"]);
    header("Location: ?page=lessonDetailEditor&id=" . $_GET["lessonId"]);
}

// Erstellen oder Bearbeiten von Exercise
if (isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["boxStyle"]) && isset($_POST["infoText"]) && isset($_POST["hintLink"]) && isset($_POST["correctAnswer"])) {
    if (strcmp($_GET["id"], "") === 0) {
        createExercise($conn, $_POST["title"], $_POST["description"], $_POST["boxStyle"], $_POST["infoText"], $_POST["hintLink"], $_POST["correctAnswer"], $_GET["lessonId"]);
    } else {
        modifyExercise($conn, $_GET["id"], $_POST["title"], $_POST["description"], $_POST["boxStyle"], $_POST["infoText"], $_POST["hintLink"], $_POST["correctAnswer"]);
    }
    header("Location: ?page=lessonDetailEditor&id=" . $_GET["lessonId"]);
}

// Laden von Exercise
$exercise = getExercise($conn, $_GET["id"]);

$conn->close();
?>

<section class="container my-5 editor">
    <div class="">
        <h2 class="mb-4 mt-2 editor__title">Exercise Detail Editor</h2>
        <div>
            <form action="./?page=exerciseDetailEditor&lessonId=<?php echo $_GET["lessonId"]; ?>&id=<?php echo isset($exercise["id"]) ? $exercise["id"] : ""; ?>"
                method="POST">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Titel"
                        value="<?php echo isset($exercise["title"]) && $exercise["title"] ? $exercise["title"] : ''; ?>"
                        required>
                    <label for="title">Titel</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="description" name="description"
                        placeholder="Beschreibung"
                        value="<?php echo isset($exercise["description"]) && $exercise["description"] ? $exercise["description"] : ''; ?>"
                        required>
                    <label for="description">Beschreibung</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="boxStyle" name="boxStyle"
                        placeholder="Box Style (inline CSS)"
                        value="<?php echo isset($exercise["box_style"]) && $exercise["box_style"] ? $exercise["box_style"] : ''; ?>"
                        required>
                    <label for="boxStyle">Box Style (inline CSS)</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="infoText" name="infoText" placeholder="Info"
                        value="<?php echo isset($exercise["info_text"]) && $exercise["info_text"] ? $exercise["info_text"] : ''; ?>"
                        required>
                    <label for="infoText">Info</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="hintLink" name="hintLink" placeholder="Hint Link"
                        value="<?php echo isset($exercise["hint_link"]) && $exercise["hint_link"] ? $exercise["hint_link"] : ''; ?>"
                        required>
                    <label for="hintLink">Hint Link</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="correctAnswer" name="correctAnswer"
                        placeholder="Richtige Antwort"
                        value="<?php echo isset($exercise["correct_answer"]) && $exercise["correct_answer"] ? $exercise["correct_answer"] : ''; ?>"
                        required>
                    <label for="correctAnswer">Richtige Antwort</label>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2 mb-3">
                    <button type="submit" class="btn btn-primary editor__button">Speichern</button>
                    <?php if (strcmp($_GET["id"], "") !== 0): ?> <a
                            href="./?page=exerciseDetailEditor&delete=1&lessonId=<?php echo $_GET["lessonId"]; ?>&id=<?php echo $exercise["id"]; ?>"
                            class="btn btn-danger">Löschen</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</section>