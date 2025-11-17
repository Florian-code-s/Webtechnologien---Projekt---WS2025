<?php if (isset($IsLoggedIn) && $IsLoggedIn): ?>
    <!-- Wenn eingeloggt -->
    <section class="finishedLessonsDiagram">
        <h2 class="card-title mb-4 mt-2 text-center finishedLessonsDiagram__title">Fortschrittsanzeige</h2>
        <div class="d-flex justify-content-center align-items-center min-vh-10">
            <div class="container mx-3 mb-3">
                <div class="row rounded border border-2" style="max-width: 100%">
                    <div class="finishedLessonsDigramFinished rounded-start" style="width: 45%; height: 30px">
                    </div>
                </div>
            </div>
        </div>
        <div class="container mx-3">
            <div class="d-flex align-items-center mb-3">
                <div class="finishedLessonsDigramFinished rounded border border-2 me-3" style="width: 30px; height: 30px;">
                </div>
                <span>absolviert</span>
            </div>

            <div class="d-flex align-items-center mb-3">
                <div class="rounded border border-2 me-3" style="width: 30px; height: 30px;"></div>
                <span>offen</span>
            </div>
        </div>
    </section>
<?php endif; ?>