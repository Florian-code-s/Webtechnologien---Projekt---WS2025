<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/lessonModel.php';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

$lessons = getLessons($conn);

$conn->close();
?>

<section class="container my-5 editor">
    <div class="">
        <h2 class="mb-4 mt-2 editor__title">Lessons Editor</h2>
        <table class="table table-responsive align-middle">
            <thead>
                <tr>
                    <th scope="col" class="w-75">Lesson</th>
                    <th scope="col" class="w-25"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lessons as $lesson): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($lesson["title"]); ?></th>
                        <td class="text-end"><a href="./?page=lessonDetailEditor&id=<?php echo $lesson["id"]; ?>"
                                class="btn btn-sm btn-primary">Bearbeiten</a></td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <td><a href="./?page=lessonDetailEditor&id=" class="btn btn-sm btn-primary">Neue Lesson erstellen</a>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</section>