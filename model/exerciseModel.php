<?php

function getExercises(mysqli $conn, string $lessonId): array
{
    $sql = "SELECT `id`, `title`, `description`, `box_html`, `info_text`, `hint_link`, `correct_answer`, `fk_id_lessons` FROM `exercises` WHERE `fk_id_lessons` = ?";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("i", $lessonId);
    $stmt->execute();
    $result = $stmt->get_result();

    $resultExercises = array();
    while($row = $result->fetch_array()) {
        array_push($resultExercises, $row);
    }

    $stmt->close();
    return $resultExercises;
}

function getExercise(mysqli $conn, string $id): array|bool|null
{
    $sql = "SELECT `id`, `title`, `description`, `box_html`, `info_text`, `hint_link`, `correct_answer`, `fk_id_lessons` FROM `exercises`  WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_array();
}

function modifyExercise(mysqli $conn, string $id, string $title, string $description, string $boxHtml, string $infoText, string $hintLink, string $correctAnswer): bool
{
    $sql = "UPDATE `exercises` SET `title` = ?, `description` = ?, `box_html` = ?, `info_text` = ?, `hint_link` = ?, `correct_answer` = ? WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("ssssssi", $title, $description, $boxHtml, $infoText, $hintLink, $correctAnswer, $id);
    $result = $stmt->execute();
    $stmt->close(); 
    return $result;
}

function createExercise(mysqli $conn, string $title, string $description, string $boxHtml, string $infoText, string $hintLink, string $correctAnswer, string $lessonId): bool
{
    $sql = "INSERT INTO `exercises` (`title`, `description`, `box_html`, `info_text`, `hint_link`, `correct_answer`, `fk_id_lessons`)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("ssssssi", $title, $description, $boxHtml, $infoText, $hintLink, $correctAnswer, $lessonId);
    $result = $stmt->execute();
    $stmt->close(); 
    return $result;
}

function deleteExercise(mysqli $conn, string $id): bool
{
    $sql = "DELETE FROM `exercises` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

?>