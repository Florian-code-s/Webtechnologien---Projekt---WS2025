<?php

$isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) || (isset($_SESSION['user']) && strtolower($_SESSION['user']) === 'admin');

if ($isAdmin):
 
  $editUrl = isset($lessonId) ? ("?page=lesson_edit&lesson=" . urlencode($lessonId)) : '?page=lesson_edit';
    ?>
    <div class="mt-3 text-start">
      <a href="<?php echo $editUrl; ?>" class="btn btn-outline-warning btn-sm">Aufgabe bearbeiten</a>
    </div>
<?php endif; ?>
