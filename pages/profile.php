<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../functions/helpers.php";
require_once __DIR__ . "/../model/userModel.php";

$username = "";
$email = "";
$imageData = "";
$imagePath = "";

if (!$IsLoggedIn) {
    header("Location: ./?page=home");
    $conn->close();
    exit();
}

if (!empty($_POST) && $_POST["email"]) {
    $imagePath = getUserDetails($conn)[2];
    if (isset($_FILES["picture"]) && strcmp("", $_FILES["picture"]["name"]) !== 0) {
        $picture = $_FILES["picture"];
        $uploadDir = "../uploads/";
        $uploadExt = strtolower(pathinfo($picture["name"], PATHINFO_EXTENSION));
        $imagePath = $uploadDir . $_SESSION["user"] . "." . $uploadExt;
        if (!validateFile($picture)) {
            echo "Profilbild ungültig";
            return;
        }
        ensureDirectoryExists($uploadDir);
        if (!move_uploaded_file($picture["tmp_name"], $imagePath)) {
            echo "Fehler beim Hochladen des Profilbildes!";
            return;
        }
    } else if (isset($_POST["deleteImage"]) && $_POST["deleteImage"] && file_exists($imagePath)) {
        unlink($imagePath);
        $imagePath = "";
    }
    updateUser($conn, $_SESSION["user"], $_POST["email"], $imagePath);
}

$userDetails = getUserDetails($conn);
if ($userDetails != null) {
    $username = $userDetails[0];
    $email = $userDetails[1];
    $imagePath = $userDetails[2];
}

$conn->close();
?>

<section class="container my-5 profile">
    <div class="">
        <h2 class="mb-4 mt-2 profile__title">Profil</h2>
        <form action="./?page=profile" method="POST" enctype="multipart/form-data">
            <div class="form-floating mb-3">
                <?php echo '<input type="text" class="form-control" id="username" placeholder="Benutzername" value="' . $username . '" disabled>' ?>
                <label for="username">Benutzername</label>
            </div>
            <div class="form-floating mb-3">
                <?php echo '<input type="email" class="form-control" id="email" name="email" placeholder="E-Mail" value="' . $email . '" required>' ?>
                <label for="email">E-Mail</label>
            </div>
            <div class="mb-3">
                <span class="ms-1 me-3">Passwort verwalten</span>
                <a class="btn btn-primary" role="button" href="./?page=changePassword">Passwort ändern</a>
            </div>
            <div class="mb-3">
                <?php echo '<img src="' . $imagePath . '" class="profile__image" alt="Profilbild" />' ?>
            </div>
            <div class="mb-3 text-start form-check">
                <input type="checkbox" class="form-check-input" id="deleteImage" name="deleteImage">
                <label class="form-check-label" for="deleteImage">Profilbild löschen</label>
            </div>
            <div class="mb-3 text-start">
                <label for="formFile" class="form-label ms-1 mb-1 profile__upload">Profilbild
                    ändern</label>
                <input class="form-control profile__upload" type="file" id="formFile" name="picture"
                    placeholder="Profilbild" accept=".png, .jpg, .gif">
            </div>
            <button type="submit" class="btn btn-primary fw-semibold col-12 mb-3 profile__button">Änderungen
                speichern</button>
        </form>
    </div>
</section>