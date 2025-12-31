<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../functions/helpers.php";
$error = "";

function checkCredentials($conn, $username, $password)
{
    $sql = "SELECT `salt`, `password_hash`, `is_admin` FROM `users` WHERE `username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        return [false, false];
    }

    $row = $result->fetch_row();
    $stmt->close();
    $salt = $row[0];
    $passwordHashFromDB = $row[1];

    $hashedPassword = hashPassword($password, $salt);

    if (strcmp($passwordHashFromDB, $hashedPassword) == 0) {
        return [true, $row[2]];
    }
    return [false, false];
}

if (!empty($_POST) && $_POST["username"] && $_POST["password"]) {
    $safeUsername = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
    $safePassword = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    $credCheck = checkCredentials($conn, $safeUsername, $safePassword);
    if ($credCheck[0]) {
        $conn->close();
        $_SESSION["user"] = $safeUsername;
        $_SESSION["logged_in"] = true;
        $_SESSION["is_admin"] = $credCheck[1];
        header("Location: ?page=home");
        exit;
    } else {
        $conn->close();
        $_SESSION["user"] = null;
        $_SESSION["logged_in"] = false;
        $_SESSION["is_admin"] = false;
        $error = "Login nicht erfolgreich";
    }
}
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