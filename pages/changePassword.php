<?php
$error = "";

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../functions/helpers.php";
require_once __DIR__ . "/../model/userModel.php";

if (!$IsLoggedIn) {
    header("Location: ./?page=home");
    $conn->close();
    exit();
}

if (!empty($_POST) && $_POST["current-password"] && $_POST["new-password"] && $_POST["confirm-password"]) {
    $currentPassword = $_POST["current-password"];
    $newPassword = $_POST["new-password"];
    $confirmPassword = $_POST["confirm-password"];
    if (!checkCredentials($conn, $_SESSION["user"], $currentPassword)[0]) {
        $error = "Passwort nicht korrekt";
    }
    if (strcmp($newPassword, $confirmPassword) !== 0) {
        $error = "Passwörter stimmen nicht überein";
    }
    if (strcmp($error, "") === 0) {
        updatePassword($conn, $_SESSION["user"], $newPassword);
        header("Location: ./?page=profile");
        $conn->close();
        exit();
    }
}
$conn->close();
?>

<section class="container my-5 changePassword">
    <div class="">
        <h2 class="mb-4 mt-2 changePassword__title">Passwort ändern</h2>
        <form action="./?page=changePassword" method="POST">
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="current-password" name="current-password"
                    placeholder="Aktuelles Passwort" required>
                <label for="current-password">Aktuelles Passwort</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="new-password" name="new-password"
                    placeholder="Neues Passwort" required>
                <label for="new-password">Neues Passwort</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="confirm-password" name="confirm-password"
                    placeholder="Passwort bestätigen" required>
                <label for="confirm-password">Passwort bestätigen</label>
            </div>
            <?php if (strcmp($error, "") !== 0): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary fw-semibold col-12 mb-3 changePassword__button">Passwort
                ändern</button>
        </form>

    </div>
</section>