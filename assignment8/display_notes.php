<?php 
require_once 'classes/Date_time.php';
$dt = new Date_time();
$output = $dt->checkSubmit();
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Display Notes</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
  </head>
  <body>
      
      <div class="container">
        <h1>Display Notes</h1>
        <p><a href="index.php">Add Note</a></p>
        <form action="display_notes.php" method="post">
 
        <div class="form-group">
          <label for="begDate">Beginning Date</label>
          <input type="date" class="form-control" id="begDate" name="begDate">
        </div>
        <div class="form-group">
          <label for="endDate">Ending Date</label>
          <input type="date" class="form-control" id="endDate" name="endDate">
        </div>
        <div class="form-group">
          <input type="submit" name="getNotes"  class="btn btn-primary" value="Get Notes">
        </div>
      </form>
      <div></div>
    </div>
  </body>
 <? echo $output; ?>
</html>