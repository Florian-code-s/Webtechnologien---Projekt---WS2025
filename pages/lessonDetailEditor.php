<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/lessonModel.php';
require_once __DIR__ . '/../model/exerciseModel.php';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

$lesson = [];
$exercises = [];

if (!isset($_GET["id"])) {
    header("Location: ?page=home");
    exit();
}

// Löschen von Lesson
if (isset($_GET["delete"]) && strcmp($_GET["delete"], "1") === 0) {
    deleteLesson($conn, htmlspecialchars($_GET["id"]));
    header("Location: ?page=lessonsEditor");
    exit();
}

// Erstellen oder Bearbeiten von Lesson
if (isset($_POST["title"]) && isset($_POST["description"])) {
    if (strcmp($_GET["id"], "") === 0) {
        createLesson($conn, htmlspecialchars($_POST["title"]), htmlspecialchars($_POST["description"]));
    } else {
        modifyLesson($conn, htmlspecialchars($_GET["id"]), htmlspecialchars($_POST["title"]), htmlspecialchars($_POST["description"]));
    }
    header("Location: ?page=lessonsEditor");
    exit();
}

// Laden von Lesson und Aufgaben
$lesson = getLesson($conn, htmlspecialchars($_GET["id"]));
$exercises = getExercises($conn, htmlspecialchars($_GET["id"]));

$conn->close();
?>

<section class="container my-5 editor">
    <div class="">
        <h2 class="mb-4 mt-2 editor__title">Lesson Detail Editor</h2>
        <div>
            <form action="./?page=lessonDetailEditor&id=<?php echo isset($lesson["id"]) ? $lesson["id"] : ""; ?>"
                method="POST">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Titel"
                        value="<?php echo isset($lesson["title"]) && $lesson["title"] ? htmlspecialchars($lesson["title"]) : ''; ?>"
                        maxlength="100" required>
                    <label for="title">Titel</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="description" name="description" placeholder="Beschreibung"
                        maxlength="1000" required
                        rows="3"><?php echo isset($lesson["description"]) && $lesson["description"] ? htmlspecialchars($lesson["description"]) : ''; ?></textarea>
                    <label for="description">Beschreibung</label>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2 mb-3">
                    <button type="submit" class="btn btn-primary editor__button">Speichern</button>
                    <?php if (strcmp($_GET["id"], "") !== 0): ?> <a
                            href="./?page=lessonDetailEditor&delete=1&id=<?php echo $lesson["id"]; ?>"
                            class="btn btn-danger">Löschen</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <?php if (strcmp($_GET["id"], "") === 0): ?>
            <h5>Aufgaben können nach Erstellen der Lesson hinzugefügt werden</h5>
        <?php else: ?>
            <table class="table table-responsive align-middle text-break">
                <thead>
                    <tr>
                        <th scope="col" class="w-25">Aufgabentitel</th>
                        <th scope="col" class="w-50">Aufgabenbeschreibung</th>
                        <th scope="col" class="w-25"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($exercises as $exercise): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($exercise["title"]); ?></th>
                            <td><?php echo htmlspecialchars($exercise["description"]); ?></th>
                            <td class="text-end"><a
                                    href="./?page=exerciseDetailEditor&lessonId=<?php echo $lesson["id"]; ?>&id=<?php echo $exercise["id"]; ?>"
                                    class="btn btn-sm btn-primary">Bearbeiten</a></td>
                        </tr>
                    <?php endforeach ?>
                    <tr>
                        <td><a href="./?page=exerciseDetailEditor&lessonId=<?php echo $lesson["id"]; ?>&id="
                                class="btn btn-sm btn-primary">Neue Aufgabe erstellen</a>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</section>