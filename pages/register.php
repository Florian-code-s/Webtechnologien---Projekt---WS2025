<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../functions/helpers.php";

function checkMagicNumbers($fileName)
{
    $acceptedMagicNumbers = ["89504E47", "FFD8FFDB", "FFD8FFE0", "FFD8FFEE", "FFD8FFE1", "47494638"];
    $f = fopen($fileName, "r");
    $magicNumber = fread($f, 4);
    fclose($f);
    if (in_array(strtoupper(substr(bin2hex($magicNumber), 0, 8)), $acceptedMagicNumbers)) {
        return true;
    }
    return false;
}

function getFileSuffix($fileName)
{
    $pos = strrpos($fileName, ".");
    $suffix = substr($fileName, $pos + 1);
    return $suffix;
}

function checkSuffix($fileName)
{
    $acceptedSuffixes = ["png", "jpg", "gif"];
    $suffix = getFileSuffix($fileName);
    if (in_array($suffix, $acceptedSuffixes)) {
        return true;
    }
    return false;
}

function validateFile($file)
{
    $maxFileSize = 5000000;
    $validMagicNumber = checkMagicNumbers($file["tmp_name"]);
    $validFileSize = ($file["size"] <= $maxFileSize);
    $validSuffix = checkSuffix($file["name"]);
    if ($validMagicNumber && $validFileSize && $validSuffix) {
        return true;
    }
    return false;
}

function ensureDirectoryExists($path)
{
    if (!is_dir($path)) {
        mkdir($path);
    }
}

function saveUser($conn, $safeUsername, $safeEmail, $imagePath, $salt, $passwordHash)
{
    $sql = "INSERT INTO `users` (`username`, `email`, `image_path`, `salt`, `password_hash`)
        VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("sssss", $safeUsername, $safeEmail, $imagePath, $salt, $passwordHash);
    $result = $stmt->execute();

    $stmt->close(); 
    $conn->close();
    return $result;
}

function userExists($conn, $safeUsername)
{
    $sql = "SELECT count(*) FROM `users` WHERE `username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("s", $safeUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    $count = $result->fetch_row()[0];
    $stmt->close();
    return $count;
}

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
        ensureDirectoryExists("../uploads"); //To Do: set correct path
        $imagePath = "../uploads/" . $safeUsername . ".img";
        move_uploaded_file($picture["tmp_name"], $imagePath);
    }
    
    $salt = getRandomString(20);
    $hashedPassword = hashPassword($safePassword, $salt);
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
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
}
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