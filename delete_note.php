<?php

//Define the query
$query = "DELETE FROM note WHERE noteID={$_POST['noteID']}";

//sends the query to delete the entry
mysqli_query($conn, $query);

if (mysqli_affected_rows($conn) == 1) { 
//if it updated
?>

            <strong>Note Has Been Deleted</strong><br /><br />
    
<?php
 } else { 
//if it failed
?>
    
            <strong>Deletion Failed</strong><br /><br />
    

<?php
} 
?>