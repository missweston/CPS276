<?php
function addClearNames(){
    $output = "";
    if(isset($_POST['addName'])) // Check if the addName button was clicked
    {
        $names = explode("\n", $_POST['namelist']); //
         
        $newName= $_POST['name']; // Get the new name from the form input
        $parts = explode(" ", $newName); // Split the name into first and last name
        $firstName = $parts[0]; // Assume the first part is the first name
        $lastName = $parts[1]; // Assume the second part is the last name
        $names[] = $lastName . ", " . $firstName; // Format as "Last, First" and add to the array
         
        sort($names); // Sort the names alphabetically
         $output = implode("\n", $names); // Join the names back into a single string with new lines

    } elseif(isset($_POST['clearNames'])) { // Check if the clearNames button was clicked
        $output = ""; // Clear the output

    } 

    return $output; // Return the updated output


}

/* What is the purpose of separating the functionality between index.php and processNames.php in this assignment?
     Is to separating the process logic from the presentation logic.

How does the $_SERVER["REQUEST_METHOD"] variable help determine when to process form submissions in PHP?
    It checks if the form was submitted with POST method.

How does PHP handle string-to-array conversion using the explode function, and why is this useful in this application?
    It converts a string into an array; useful for handling comma separated values
What role does the implode function play in formatting the output for the textarea?
    It converts an array back into a string, useful for displaying names in the textarea.
How does the use of "\n" inside a double-quoted string affect how names are displayed in the textarea? Why not use <br>?
    "\n" creates a new line in the textarea, while <br> is for HTML rendering.
How does processNames.php determine whether to add a new name or clear all names based on which button was clicked?
    Based on name attributes. It checks which button was clicked using isset on $_POST variables addnames and clearNames.
*/
    

