<nav class="navbar navbar-expand-lg" style="background-color:#1E3A8A;">
  <div class="container">
    <a class="navbar-brand text-white fw-bold" href="#">PlatzhalterName</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link text-white" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Über uns</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Kontakt</a></li>
        
        <?php if (isset($IsLoggedIn) && $IsLoggedIn): ?> 
          <!-- Wenn eingeloggt -->
          <li class="nav-item"><a class="nav-link text-warning fw-bold" href="#">Logout</a></li>
        <?php else: ?>
          <!-- Wenn ausgeloggt -->
          <li class="nav-item"><a class="nav-link text-warning fw-bold" href="#">Login</a></li>
          <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>
