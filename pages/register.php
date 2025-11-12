<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .register {
            background-color: #F9FAFB;
        }
        
        .register__card {
            width: 400px; 
            max-width: 100%; 
            border: none;
        }

        .register__card--title {
            color: #1E3A8A;
        }

        .register__upload {
            color: #6e7174;
        }

        .register__button {
            background-color: #3B82F6;
            border: none;
        }

        .register__button:hover {
            background-color: #FACC15;
            color: #1E293B;
        }

        .register__link {
            text-decoration: none;
        }

        .register__link:hover {
            color: #1E3A8A;
        }
    </style>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
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
                            Schon einen Account? <a href="login.php" class="register__link">Jetzt einloggen</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>
</body>

</html>