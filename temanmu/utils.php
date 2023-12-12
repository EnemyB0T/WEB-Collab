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

?>