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

function getLessonsWithStatus(mysqli $conn, int $userId): array
{
  $sql = "
        SELECT
            l.id,
            l.title,
            l.description,
            COALESCE(ulp.status, 'not_started') AS status,
            COALESCE(ulp.progress_percent, 0) AS progress_percent
        FROM lessons l
        LEFT JOIN user_lesson_progress ulp
            ON ulp.lesson_id = l.id AND ulp.user_id = ?
        ORDER BY l.id ASC
    ";  

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $lessons = [];
    while ($row = $result->fetch_assoc()) {
        $lessons[] = $row;
    }

    $stmt->close();
    return $lessons;
}

function startLesson(mysqli $conn, int $userId, int $lessonId): bool
{
    $sql = "
        INSERT INTO user_lesson_progress (user_id, lesson_id, status, progress_percent)
        VALUES (?, ?, 'in_progress', 0)
        ON DUPLICATE KEY UPDATE status = 'in_progress'
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $lessonId);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

function loadProgress(mysqli $conn, int $userId, int $lessonId): ?array
{
    $sql = "
        SELECT status, progress_percent
        FROM user_lesson_progress
        WHERE user_id = ? AND lesson_id = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $lessonId);
    $stmt->execute();
    $result = $stmt->get_result();
    $progress = $result->fetch_assoc();
    $stmt->close();

    return $progress ?: null;
}

function saveProgress(mysqli )