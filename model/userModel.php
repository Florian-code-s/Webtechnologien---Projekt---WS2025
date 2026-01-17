<?php

require_once __DIR__ . "/../functions/helpers.php";

function saveUser(mysqli $conn, string $username, string $email, string $imagePath, string $salt, string $passwordHash): bool
{
    $sql = "INSERT INTO `users` (`username`, `email`, `image_path`, `salt`, `password_hash`)
        VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("sssss", $username, $email, $imagePath, $salt, $passwordHash);
    $result = $stmt->execute();

    $stmt->close(); 
    return $result;
}

function userExists(mysqli $conn, string $username): int
{
    $sql = "SELECT count(*) FROM `users` WHERE `username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $count = $result->fetch_row()[0];
    $stmt->close();
    return $count;
}

function checkCredentials(mysqli $conn, string $username, string $password): array
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

function getUserDetails(mysqli $conn): array|null
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
    //return user profile image if exists, otherwise return default image
    if (empty($imagePath) || !file_exists($imagePath)) {
        $imagePath = "../public/images/user_default.png";
    }
    return [$username, $email, $imagePath];
}

function updateUser(mysqli $conn, string $username, string $email, string $imagePath): void
{
    $sql = "UPDATE `users` SET `email` = ?, `image_path` = ? WHERE `username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $imagePath, $username);
    $stmt->execute();
    $stmt->close();
}

function updatePassword(mysqli $conn, string $username, string $password): void
{
    $salt = getRandomString(20);
    $hashedPassword = hashPassword($password, $salt);

    $sql = "UPDATE `users` SET `salt` = ?, `password_hash` = ? WHERE `username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $salt, $hashedPassword, $username);
    $stmt->execute();

    $stmt->close();
}

?>