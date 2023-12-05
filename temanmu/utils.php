<?php

function getUsernameFromUserID($userID, $conn) {
    $stmt = $conn->prepare("SELECT username FROM user WHERE userID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['username'];
    } else {
        return null; // Or handle this scenario appropriately
    }
}

function getUserLifePoints($userID, $conn) {
    $stmt = $conn->prepare("SELECT life_points FROM user WHERE userID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['life_points'];
    }
    return 0; // Default if user not found
}

?>