<?php

function checkCredentials($username, $password) {
    if(strcmp($username, "User") == 0 && strcmp($password, "123") == 0) {
        return true;
    }
    return false;
}

session_start();
if (!empty($_POST) && $_POST["username"] && $_POST["password"]) {
    $safeUsername = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
    $safePassword = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');
    if(checkCredentials($safeUsername, $safePassword)) {
        $_SESSION["user"] = $safeUsername;
        header("Location: ./home.php");        
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anmeldung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .login {
            background-color: #F9FAFB;
        }
        
        .login__card {
            width: 400px; 
            max-width: 100%; 
            border: none;
        }

        .login__button {
            background-color: #3B82F6;
            border: none;
        }

        .login__card--title {
            color: #1E3A8A;
        }

        .login__button:hover {
            background-color: #FACC15;
            color: #1E293B;
        }

        .login__link {
            text-decoration: none;
        }

        .login__link:hover {
            color: #1E3A8A;
        }
    </style>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <section class="login">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="card text-center shadow login__card">
                <div class="card-body">
                    <h2 class="card-title mb-4 mt-2 login__card--title">Anmelden</h2>
                    <div class="card-text">
                        <form action="login.php" method="POST"> 
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Benutzername"
                                    required>
                                <label for="username">Benutzername</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Passwort"
                                    required>
                                <label for="password">Passwort</label>
                            </div>
                            <button type="submit"
                                class="btn btn-primary fw-semibold col-12 mb-3 login__button">Einloggen</button>
                        </form>
                        <p>
                            Noch keinen Account? <a href="register.php" class="login__link">Jetzt registrieren</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>
</body>

</html>