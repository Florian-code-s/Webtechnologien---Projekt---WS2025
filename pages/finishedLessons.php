<?php
require_once "../functions/objects.php";
function getFinishedLessons()
{
    return [new LessonResult("Lesson 1", "25.07.2023"), new LessonResult("Lesson 2", "25.07.2023")];
}

$finishedLessons = getFinishedLessons();
?>

<?php if (isset($IsLoggedIn) && $IsLoggedIn): ?>
    <!-- Wenn eingeloggt -->
    <section class="finishedLessons">
        <div class="d-flex justify-content-center align-items-center">
            <div class="card shadow finishedLessons__card">
                <div class="card-body">
                    <h2 class="card-title mb-4 mt-2 text-center finishedLessons__card--title">Absolvierte Lessons</h2>
                    <div class="card-text justify-content-start">
                        <ol>
                            <?php
                            foreach ($finishedLessons as $finishedLesson) {
                                echo "<li>" . $finishedLesson->name . ", absolviert am " . $finishedLesson->date . "</li>";
                            }
                            ?>
                        </ol>
                    </div>
                    <?php require_once __DIR__ . "/../pages/finishedLessonsDiagram.php"; ?>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <!-- Wenn ausgeloggt -->
<?php endif; ?>