<?php



$completedLessons = isset($_COOKIE['completed_lessons']) ? json_decode($_COOKIE['completed_lessons'], true) : [];
$isCompleted = in_array('bg_color', $completedLessons);

$totalLessons = 1;
$completedCount = count($completedLessons);
$progressPercentage = ($completedCount / $totalLessons) * 100;
?>

<section class="lessons container py-5">
  <div class="row mb-4">
    <div class="col">
      <h1 class="display-6">CSS Lektionen</h1>
      <p class="lead">Beherrsche CSS-Grundlagen mit interaktiven Aufgaben.</p>
      
   
      <div class="mt-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="fw-semibold">Fortschritt</span>
          <span class="badge bg-primary"><?php echo $completedCount; ?>/<?php echo $totalLessons; ?></span>
        </div>
        <div class="progress" style="height: 25px;">
          <div class="progress-bar bg-success" role="progressbar" 
               style="width: <?php echo $progressPercentage; ?>%;" 
               aria-valuenow="<?php echo $completedCount; ?>" 
               aria-valuemin="0" 
               aria-valuemax="<?php echo $totalLessons; ?>">
            <?php echo round($progressPercentage, 0); ?>%
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-8 mx-auto">
      <div class="card" style="border: 2px solid <?php echo $isCompleted ? '#28a745' : '#007bff'; ?>;">
        <a href="?page=lesson_bg_color" class="card-link text-decoration-none">
          <div class="card-body">
            <h5 class="card-title">
              <?php echo $isCompleted ? '✅' : '❌'; ?>
              Background Color
            </h5>
            <p class="card-text">Schreibe den CSS-Code, um eine Box rot zu färben.</p>
            <small class="text-muted">
              <?php echo $isCompleted ? 'Abgeschlossen' : 'Nicht absolviert'; ?>
            </small>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>
