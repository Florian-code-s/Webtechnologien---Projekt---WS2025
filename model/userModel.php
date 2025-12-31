<?php

require_once __DIR__ . "/../functions/helpers.php";

function saveUser($conn, $safeUsername, $safeEmail, $imagePath, $salt, $passwordHash)
{
    $sql = "INSERT INTO `users` (`username`, `email`, `image_path`, `salt`, `password_hash`)
        VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("sssss", $safeUsername, $safeEmail, $imagePath, $salt, $passwordHash);
    $result = $stmt->execute();

    $stmt->close(); 
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

function getUserDetails($conn)
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

?>