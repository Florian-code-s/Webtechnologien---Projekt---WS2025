<?php

require_once __DIR__ . '/../config/database.php';

$username = "";
$email = "";
$imageData = "";
$imagePath = "";

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

function fillUserDetails($conn)
{
    $sql = "SELECT `username`, `email`, `image_path` FROM `users` WHERE `username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION["user"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        return null;
    }

    $row = $result->fetch_row();
    $stmt->close();
    $username = $row[0];
    $email = $row[1];
    $imagePath = $row[2];
    //load user profile image if exists, otherwise show default image
    if (file_exists($imagePath)) {
        $imageData = "data:image/*;base64, " . base64_encode(file_get_contents($imagePath));
    } else {
        $imageData = "data:image/*;base64, " . base64_encode(file_get_contents("../public/images/user_default.png"));
    }
    return [$username, $email, $imageData, $imagePath];
}

function updateUser($conn, $username, $email, $imagePath)
{
    $sql = "UPDATE `users` SET `email` = ?, `image_path` = ? WHERE `username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $imagePath, $username);
    $stmt->execute();
    $stmt->close();
}

if (!$IsLoggedIn) {
    header("Location: ./?page=home");
    $conn->close();
    exit();
}

if (!empty($_POST) && $_POST["email"]) {
    $imagePath = "../uploads/" . $_SESSION["user"] . ".img";
    $safeEmail = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
    if (isset($_FILES["picture"]) && strcmp("", $_FILES["picture"]["name"]) !== 0) {
        $picture = $_FILES["picture"];
        if (!validateFile($picture)) {
            echo "Profilbild ungültig";
            return;
        }
        ensureDirectoryExists("../uploads"); //To Do: set correct path
        move_uploaded_file($picture["tmp_name"], $imagePath);
    } else if (isset($_POST["deleteImage"]) && $_POST["deleteImage"] && file_exists("../uploads/" . $_SESSION["user"] . ".img")) {
        unlink("../uploads/" . $_SESSION["user"] . ".img");
        $imagePath = "";
    }
    updateUser($conn, $_SESSION["user"], $_POST["email"], $imagePath);
}

$userDetails = fillUserDetails($conn);
if ($userDetails != null) {
    $username = $userDetails[0];
    $email = $userDetails[1];
    $imageData = $userDetails[2];
    $imagePath = $userDetails[3];
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
                <?php echo '<img src="' . $imageData . '" class="profile__image" alt="Profilbild" />' ?>
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