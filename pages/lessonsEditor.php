<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/lessonModel.php';

if (!$IsLoggedIn || !isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== 1) {
    header("Location: ./?page=login");
    $conn->close();
    exit();
}

$lessons = getLessons($conn);

$conn->close();
?>

<section class="container my-5 editor">
    <div class="">
        <h2 class="mb-4 mt-2 editor__title">Lessons Editor</h2>
        <table class="table table-responsive align-middle text-break">
            <thead>
                <tr>
                    <th scope="col" class="w-75">Lesson</th>
                    <th scope="col" class="w-25"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lessons as $lesson): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($lesson["title"]); ?></td>
                        <td class="text-end"><a href="./?page=lessonDetailEditor&id=<?php echo htmlspecialchars($lesson["id"]); ?>"
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