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

function getUserData($userID, $conn) {
    // Prepare the SQL statement to retrieve user data along with remaining points
    $stmt = $conn->prepare("SELECT * FROM nilai WHERE userID = ?");
    
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
    $totalNilaiStmt = $conn->prepare("SELECT totalNilai FROM nilai WHERE userID = ?");
    $totalNilaiStmt->bind_param("i", $userID);
    $totalNilaiStmt->execute();
    $totalNilaiResult = $totalNilaiStmt->get_result();
    
    if ($totalNilaiRow = $totalNilaiResult->fetch_assoc()) {
        $totalNilai = $totalNilaiRow['totalNilai'];

        // Now, find the corresponding rank in the tingkatan table
        $rankStmt = $conn->prepare("SELECT tingkatan FROM tingkatan WHERE poinMinimum <= ? ORDER BY poinMinimum DESC LIMIT 1");
        $rankStmt->bind_param("i", $totalNilai);
        $rankStmt->execute();
        $rankResult = $rankStmt->get_result();

        if ($rankRow = $rankResult->fetch_assoc()) {
            return $rankRow['tingkatan'];
        }
    }

    return 'Unranked'; // Return 'Unranked' if no rank is found
}

function adjustUserPoints($userID, $conn) {
    // Recalculate totalNilai by summing up nilaiUser, nilaiKonten, and nilaiReply
    $updateStmt = $conn->prepare("UPDATE nilai SET totalNilai = (nilaiUser + nilaiKonten + nilaiReply + nilaiLike) WHERE userID = ?");
    $updateStmt->bind_param("i", $userID);
    $updateStmt->execute();

    // Check if the update was successful
    if ($updateStmt->error) {
        return false; // Update failed
    }
    return true; // Update successful
}

function createThreadOrReply($userID, $isThreadCreation, $conn) {
    // Define the point cost for creating a thread or replying
    $pointCost = 1;

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Fetch the current total points (totalNilai) and nilaiUser for the user
        $stmt = $conn->prepare("SELECT totalNilai, nilaiUser FROM nilai WHERE userID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $totalNilai = $row['totalNilai'];
            $nilaiUser = $row['nilaiUser'];

            // Check if the user has enough total points
            if ($totalNilai >= $pointCost) {
                $pointsToDeduct = min($nilaiUser, $pointCost); // Deduct from nilaiUser first
                $remainingPoints = $pointCost - $pointsToDeduct;

                // Update nilaiUser
                $stmt = $conn->prepare("UPDATE nilai SET nilaiUser = nilaiUser - ? WHERE userID = ?");
                $stmt->bind_param("ii", $pointsToDeduct, $userID);
                $stmt->execute();

                // Deduct remaining points from nilaiKonten or nilaiReply
                if ($remainingPoints > 0) {
                    if ($isThreadCreation) {
                        // Deduct from nilaiKonten for thread creation
                        $stmt = $conn->prepare("UPDATE nilai SET nilaiKonten = nilaiKonten - ? WHERE userID = ?");
                    } else {
                        // Deduct from nilaiReply for replying
                        $stmt = $conn->prepare("UPDATE nilai SET nilaiReply = nilaiReply - ? WHERE userID = ?");
                    }
                    $stmt->bind_param("ii", $remainingPoints, $userID);
                    $stmt->execute();
                    // if($stmt)
                    //     echo '<script>alert("affected")</script>';
                    // else
                    //     echo '<script>alert("not affected")</script>';

                    
                }
                // echo '<script>alert("reached this point")</script>';
                //Update the total points
                // Call adjustUserPoints to update totalNilai
                if (!adjustUserPoints($userID, $conn)) {
                    // Handle failure to update totalNilai
                    echo '<script>alert("reached this point")</script>';
                    $conn->rollback();
                    return "Failed to update total points.";
                }
            } else {
                // Not enough total points to perform the action
                return "Insufficient points to create a thread or reply.";
            }
        } else {
            // User not found in nilai table
            return "User not found.";
        }

        // Commit the transaction
        $conn->commit();

        // Return a success message
        return $isThreadCreation ? "Thread created successfully, points deducted." : "Reply posted successfully, points deducted.";
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        return "Error: " . $e->getMessage();
    }
}





?>