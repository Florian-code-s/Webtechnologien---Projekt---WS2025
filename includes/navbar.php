<nav class="navbar navbar-expand-lg" style="background-color:#1E3A8A;">
  <div class="container">
    <a class="navbar-brand text-white fw-bold" href="#">PlatzhalterName</a>

    <!-- Toggle-Button für kleine Bildschirme -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link text-white" href="?page=home">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="?page=about">Über uns</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Kontakt</a></li>
        
        <?php if (isset($IsLoggedIn) && $IsLoggedIn): ?> 
          <!-- Wenn eingeloggt -->
          <li class="nav-item"><a class="nav-link text-warning fw-bold" href="?page=login">Logout</a></li>
        <?php else: ?>
          <!-- Wenn ausgeloggt -->
          <li class="nav-item"><a class="nav-link text-warning fw-bold" href="?page=login">Login</a></li>
          <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>
