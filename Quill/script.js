// Enable drag and drop functionality
Sortable.create(document.getElementById('notes-list'), {
  group: 'notes',
  animation: 150,
  onAdd: function (evt) {
    // Get the note ID and folder ID
    var noteId = evt.item.getAttribute('data-note-id');
    var folderId = evt.to.getAttribute('data-folder-id');
    
    // Add the note to the folder in the database
    addNoteToFolder(noteId, folderId);
  }
});

// Handle sorting notes
$('#sort-notes-by').change(function () {
  var sortBy = $(this).val();
  getNotes(sortBy);
});

// Add a new note to the database
function addNewNote() {
  var noteTitle = $('#new-note-title').val();
  var noteContent = $('#new-note-content').val();
  addNoteToDatabase(noteTitle, noteContent);
}

// Retrieve notes from the database
function getNotes(sortBy) {
  $.ajax({
    url: 'php/notes.php',
    type: 'GET',
    data: { folder_id: activeFolderId, sortBy: sortBy },
    success: function (response) {
      var notes = JSON.parse(response);
      var notesHtml = '';

      for (var i = 0; i < notes.length; i++) {
        var note = notes[i];
        var noteHtml = '<li class="note" data-note-id="' + note.id + '">' +
          '<div class="note-title">' + note.title + '</div>' +
          '<div class="note-content">' + note.content + '</div>' +
          '</li>';
        notesHtml += noteHtml;
      }

      $('#notes-list').html(notesHtml);
    }
  });
}

function getNotes(sortBy) {
  // Check if notes-list element exists
  if (!document.getElementById('notes-list')) {
    console.error('notes-list element not found!');
    return;
  }

  // Make AJAX request to get notes
  $.ajax({
    url: 'php/notes.php',
    type: 'POST',
    data: { sortBy: sortBy },
    success: function (response) {
      $('#notes-list').html(response);
    }
  });
}


// Add a note to a folder in the database
function addNoteToFolder(noteId, folderId) {
  $.ajax({
    url: 'php/add_note_to_folder.php',
    type: 'POST',
    data: { noteId: noteId, folderId: folderId },
    success: function (response) {
      console.log(response);
    }
  });
}

// Add a new note to the database
function addNoteToDatabase(noteTitle, noteContent) {
  $.ajax({
    url: 'php/add_note.php',
    type: 'POST',
    data: { noteTitle: noteTitle, noteContent: noteContent },
    success: function (response) {
      console.log(response);
    }
  });
}

// Initialize the page with notes sorted by time created
getNotes('time_created');
