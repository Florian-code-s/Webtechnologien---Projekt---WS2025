<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../functions/helpers.php";
require_once __DIR__ . "/../model/userModel.php";

if (!empty($_POST) && $_POST["username"] && $_POST["email"] && $_POST["password"] && $_POST["confirm-password"] && strcmp($_POST["password"], $_POST["confirm-password"]) === 0) {
    $safeUsername = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
    $safeEmail = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
    $safePassword = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');
    $imagePath = "";
    if (isset($_FILES["picture"]) && strcmp("", $_FILES["picture"]["name"]) !== 0) {
        $picture = $_FILES["picture"];
        if (!validateFile($picture)) {
            echo "Profilbild ungültig";
            return;
        }
        $uploadDir = "../uploads/";
        ensureDirectoryExists($uploadDir);
        $uploadExt = strtolower(pathinfo($picture["name"], PATHINFO_EXTENSION));
        $imagePath = $uploadDir . $safeUsername . "." . $uploadExt;
        if (!move_uploaded_file($picture["tmp_name"], $imagePath)) {
            echo "Fehler beim Hochladen des Profilbildes!";
            return;
        }
    }
    
    $salt = getRandomString(20);
    $hashedPassword = hashPassword($safePassword, $salt);
    if (userExists($conn, $safeUsername) === 1) {
        echo "Benutzer konnte nicht gespeichert werden";
        return;
    }
    $result = saveUser($conn, $safeUsername, $safeEmail, $imagePath, $salt, $hashedPassword);
    if ($result === false) {
        echo "Benutzer konnte nicht gespeichert werden";
        return;
    }

    header("Location: ./?page=login");
    $conn->close();
    exit();
}
$conn->close();
?>

<section class="register">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card text-center shadow register__card">
            <div class="card-body">
                <h2 class="card-title mb-4 mt-2 register__card--title">Registrieren</h2>
                <div class="card-text">
                    <form action="./?page=register" method="POST" enctype="multipart/form-data">
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
                            <label for="formFile" class="form-label ms-1 mb-1 register__upload">Optional: Profilbild
                                hochladen</label>
                            <input class="form-control register__upload" type="file" id="formFile" name="picture"
                                placeholder="Profilbild" accept=".png, .jpg, .gif">
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Passwort" required>
                            <label for="password">Passwort</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="confirm-password" name="confirm-password"
                                placeholder="Passwort bestätigen" required>
                            <label for="confirm-password">Passwort bestätigen</label>
                        </div>
                        <button type="submit" class="btn btn-primary fw-semibold col-12 mb-3 register__button">Account
                            erstellen</button>
                    </form>
                    <p>
                        Schon einen Account? <a href="?page=login" class="register__link">Jetzt einloggen</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>