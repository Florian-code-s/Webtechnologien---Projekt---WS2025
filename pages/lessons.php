<?php
require_once "../functions/objects.php";
function getLessons()
{
    return [new Lesson("Lesson 1"), new Lesson("Lesson 2")];
}

$lessons = getLessons();
?>


    <section class="lessons mb-3">
        <div class="d-flex justify-content-center align-items-center">
            <div class="card shadow lessons__card">
                <div class="card-body">
                    <h2 class="card-title mb-4 mt-2 text-center lessons__card--title">Verfügbare Lessons</h2>
                    <div class="card-text justify-content-start">
                        <ol>
                            <?php
                            foreach ($lessons as $lesson) {
                                echo "<li>" . $lesson->name . "</li>";
                            }
                            ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
