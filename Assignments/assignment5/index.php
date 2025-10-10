<?php
require_once "classes/Directories.php"; // Include the Directories class

$message = ""; // to store success or error messages

if (isset($_POST['submit'])) {
    $Directories = new Directories(); // Create an instance of the Directories class
    $Directories->directoryname = $_POST['directoryname']; // Set the directory name from form input
    $Directories->filecontent = $_POST['filecontent']; // Set the file content from form input
    $message = $Directories->createDirectory(); // Call the method to create directory and file, store the message
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>File and Directory</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
    <div class="container">
      <h1>File and Directory Assignment</h1>

      <p>Enter a folder name and the contents of a file.  Folder names should contain alpha numeric characters only.</p>
      <p><?php echo $message; ?></p>
      
          
      <form method="post" action="index.php">
        <div class="form-group">
          <label for="foldername">Folder Name</label>
          <input type="text" class="form-control" id="directoryname" name="directoryname">
        </div>
        <div class="form-group">
          <label for="filecontent">File Content</label>
          <textarea name="filecontent" id="filecontent" name="filecontent" class="form-control" cols="20" rows="6"></textarea>
          
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
      </form>

      
    </div>
</body>
</html>