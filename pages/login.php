<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../model/userModel.php";

$error = "";

if (!empty($_POST) && $_POST["username"] && $_POST["password"]) {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $credCheck = checkCredentials($conn, $username, $password);
    if ($credCheck[0]) {
        $_SESSION["user"] = $username;
        $_SESSION["logged_in"] = true;
        $_SESSION["is_admin"] = $credCheck[1];
        session_regenerate_id();
        header("Location: ?page=home");
    } else {
        $_SESSION["user"] = null;
        $_SESSION["logged_in"] = false;
        $_SESSION["is_admin"] = false;
        $error = "Login nicht erfolgreich";
    }
}
$conn->close();
?>

<section class="login">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card text-center shadow login__card">
            <div class="card-body">
                <h2 class="card-title mb-4 mt-2 login__card--title">Anmelden</h2>
                <div class="card-text">
                    <form action="?page=login" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Benutzername" required>
                            <label for="username">Benutzername</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Passwort" required>
                            <label for="password">Passwort</label>
                        </div>
                        <button type="submit"
                            class="btn btn-primary fw-semibold col-12 mb-3 login__button">Einloggen</button>
                    </form>
                    <?php if (strcmp($error, "") !== 0): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <p>
                        Noch keinen Account? <a href="?page=register" class="login__link">Jetzt registrieren</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>