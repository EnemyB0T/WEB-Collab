<?php
// Include the database configuration file
include 'config.php';

// Function to fetch all folders
function getFolders() {
    global $db;
    $folders = array();
    $query = $db->query("SELECT * FROM folders ORDER BY folder_name ASC");
    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            $folders[] = $row;
        }
    }
    return $folders;
}

// Function to fetch all notes for a folder
function getNotes($folder_id) {
    global $db;
    $notes = array();
    $query = $db->query("SELECT * FROM notes WHERE folder_id = '$folder_id' ORDER BY date_created DESC");
    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            $notes[] = $row;
        }
    }
    return $notes;
}

// Function to create a new folder
function createFolder($folder_name) {
    global $db;
    $stmt = $db->prepare("INSERT INTO folders (folder_name) VALUES (?)");
    $stmt->bind_param("s", $folder_name);
    $stmt->execute();
    $stmt->close();
}

// Function to create a new note
function createNote($folder_id, $note_title, $note_content) {
    global $db;
    $stmt = $db->prepare("INSERT INTO notes (folder_id, note_title, note_content, date_created, date_modified) VALUES (?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("sss", $folder_id, $note_title, $note_content);
    $stmt->execute();
    $stmt->close();
}

// Function to update a note
function updateNote($note_id, $note_title, $note_content) {
    global $db;
    $stmt = $db->prepare("UPDATE notes SET note_title = ?, note_content = ?, date_modified = NOW() WHERE note_id = ?");
    $stmt->bind_param("ssi", $note_title, $note_content, $note_id);
    $stmt->execute();
    $stmt->close();
}

// Function to delete a note
function deleteNote($note_id) {
    global $db;
    $db->query("DELETE FROM notes WHERE note_id = '$note_id'");
}
?>
