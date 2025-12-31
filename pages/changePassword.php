<?php
$error = "";

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../functions/helpers.php";

function checkCredentials($conn, $username, $password)
{
    $sql = "SELECT `salt`, `password_hash` FROM `users` WHERE `username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        return false;
    }

    $row = $result->fetch_row();
    $stmt->close();
    $salt = $row[0];
    $passwordHashFromDB = $row[1];

    $hashedPassword = hashPassword($password, $salt);

    if (strcmp($passwordHashFromDB, $hashedPassword) == 0) {
        return true;
    }
    return false;
}

function updatePassword($conn, $username, $password)
{
    $salt = getRandomString(20);
    $hashedPassword = hashPassword($password, $salt);

    $sql = "UPDATE `users` SET `salt` = ?, `password_hash` = ? WHERE `username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $salt, $hashedPassword, $username);
    $stmt->execute();

    $stmt->close();
}

if (!$IsLoggedIn) {
    header("Location: ./?page=home");
    $conn->close();
    exit();
}

if (!empty($_POST) && $_POST["current-password"] && $_POST["new-password"] && $_POST["confirm-password"]) {
    $safeCurrentPassword = htmlspecialchars($_POST["current-password"], ENT_QUOTES, 'UTF-8');
    $safeNewPassword = htmlspecialchars($_POST["new-password"], ENT_QUOTES, 'UTF-8');
    if (!checkCredentials($conn, $_SESSION["user"], $safeCurrentPassword)) {
        $error = "Passwort nicht korrekt";
    }
    if (strcmp($_POST["new-password"], $_POST["confirm-password"]) !== 0) {
        $error = "Passwörter stimmen nicht überein";
    }
    if (strcmp($error, "") === 0) {
        updatePassword($conn, $_SESSION["user"], $safeNewPassword);
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