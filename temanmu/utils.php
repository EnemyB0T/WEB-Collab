<?php

function getUserData($userID, $conn) {
    // Prepare the SQL statement to retrieve user data along with remaining points
    $stmt = $conn->prepare("SELECT u.*, n.nilaiUser FROM user u JOIN nilai n ON u.userID = n.userID WHERE u.userID = ?");
    
    // Bind the userID parameter
    $stmt->bind_param("i", $userID);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Fetch the user data
    if ($userData = $result->fetch_assoc()) {
        return $userData;
    } else {
        // Handle the case where no user data is found
        return null;
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

function getUserData($userID, $conn) {
    // Prepare the SQL statement to retrieve user data
    $stmt = $conn->prepare("SELECT * FROM user WHERE userID = ?");
    
    // Bind the userID parameter
    $stmt->bind_param("i", $userID);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Fetch the user data
    if ($userData = $result->fetch_assoc()) {
        return $userData;
    } else {
        // Handle the case where no user data is found
        return null;
    }
}

function getUserRank($userID, $conn) {
    // First, get the totalNilai for the user
    // echo "reached point a";
    $totalNilaiStmt = $conn->prepare("SELECT totalNilai FROM nilai WHERE userID = ?");
    $totalNilaiStmt->bind_param("i", $userID);
    $totalNilaiStmt->execute();
    $totalNilaiResult = $totalNilaiStmt->get_result();
    
    if ($totalNilaiRow = $totalNilaiResult->fetch_assoc()) {
        // echo "reached point b";
        $totalNilai = $totalNilaiRow['totalNilai'];

        // Now, find the corresponding rank in the tingkatan table
        $rankStmt = $conn->prepare("SELECT tingkatan FROM tingkatan WHERE poinMinimum <= ? ORDER BY poinMinimum DESC LIMIT 1");
        $rankStmt->bind_param("i", $totalNilai);
        $rankStmt->execute();
        $rankResult = $rankStmt->get_result();

        // echo $rankRow['tingkatan'];

        if ($rankRow = $rankResult->fetch_assoc()) {
            return $rankRow['tingkatan'];
        }
    }

    return 'Unranked'; // Return 'Unranked' if no rank is found
}


?>