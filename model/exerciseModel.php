<?php

function getExercises($conn, $lessonId)
{
    $sql = "SELECT `id`, `title`, `description`, `box_style`, `info_text`, `hint_link`, `fk_id_lessons` FROM `exercises` WHERE `fk_id_lessons` = ?";
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

function getExercise($conn, $id)
{
    $sql = "SELECT `id`, `title`, `description`, `box_style`, `info_text`, `hint_link`, `fk_id_lessons` FROM `exercises`  WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_array();
}

function modifyExercise($conn, $id, $title, $description, $boxStyle, $infoText, $hintLink)
{
    $sql = "UPDATE `exercises` SET `title` = ?, `description` = ?, `box_style` = ?, `info_text` = ?, `hint_link` = ? WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("sssssi", $title, $description, $boxStyle, $infoText, $hintLink, $id);
    $result = $stmt->execute();
    $stmt->close(); 
    return $result;
}

function createExercise($conn, $title, $description, $boxStyle, $infoText, $hintLink, $lessonId)
{
    $sql = "INSERT INTO `exercises` (`title`, `description`, `box_style`, `info_text`, `hint_link`, `fk_id_lessons`)
        VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("sssssi", $title, $description, $boxStyle, $infoText, $hintLink, $lessonId);
    $result = $stmt->execute();
    $stmt->close(); 
    return $result;
}

function deleteExercise($conn, $id)
{
    $sql = "DELETE FROM `exercises` WHERE `id` = ?;";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

?>