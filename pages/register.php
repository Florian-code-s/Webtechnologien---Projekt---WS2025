    <section class="register">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="card text-center shadow register__card">
                <div class="card-body">
                    <h2 class="card-title mb-4 mt-2 register__card--title">Registrieren</h2>
                    <div class="card-text">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Benutzername" required>
                                <label for="username">Benutzername</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-Mail"
                                    required>
                                <label for="email">E-Mail</label>
                            </div>
                            <div class="mb-3 text-start">
                                <label for="formFile" class="form-label ms-1 mb-1 register__upload">Optional: Profilbild hochladen</label>
                                <input class="form-control register__upload" type="file" id="formFile" name="picture" placeholder="Profilbild" accept=".png, .jpg, .gif">
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Passwort" required>
                                <label for="password">Passwort</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="confirm-password"
                                    name="confirm-password" placeholder="Passwort bestätigen" required>
                                <label for="confirm-password">Passwort bestätigen</label>
                            </div>
                            <button type="submit"
                                class="btn btn-primary fw-semibold col-12 mb-3 register__button">Account erstellen</button>
                        </form>
                        <p>
                            Schon einen Account? <a href="?page=login" class="register__link">Jetzt einloggen</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
</section>