<?php

function getLessons(mysqli $conn): array
{
    $sql = "SELECT `id`, `title`, `description` FROM `lessons`";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $resultLessons = array();
    while($row = $result->fetch_array()) {
        array_push($resultLessons, $row);
    }

    $stmt->close();
    return $resultLessons;
}

function getLesson(mysqli $conn, string $id): array|bool|null
{
    $sql = "SELECT `id`, `title`, `description` FROM `lessons` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_array();
}

function modifyLesson(mysqli $conn, string $id, string $title, string $description): bool
{
    $sql = "UPDATE `lessons` SET `title` = ?, `description` = ? WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("ssi", $title, $description, $id);
    $result = $stmt->execute();
    $stmt->close(); 
    return $result;
}

function createLesson(mysqli $conn, string $title, string $description): bool
{
    $sql = "INSERT INTO `lessons` (`title`, `description`)
        VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("ss", $title, $description);
    $result = $stmt->execute();
    $stmt->close(); 
    return $result;
}

function deleteLesson(mysqli $conn, string $id): bool
{
    $sql = "DELETE FROM `exercises` WHERE `fk_id_lessons` = ?";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("i", $id);
    $result1 = $stmt->execute();
    $stmt->close(); 

    $sql = "DELETE FROM `lessons` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("i", $id);
    $result2 = $stmt->execute();
    $stmt->close(); 

    return $result1 && $result2;
}

function countAllLessons(mysqli $conn): int
{
    $sql = "SELECT COUNT(*) AS cnt FROM lessons";
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    return (int)$row['cnt'];
}

function countCompletedLessons(mysqli $conn, int $userId): int
{
    $sql = "SELECT COUNT(*) AS cnt
            FROM user_lesson_progress
            WHERE user_id = ? AND status = 'completed'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
    return (int)$row['cnt'];
}

