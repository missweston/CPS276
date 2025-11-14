<?php require 'php/rest_client.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Weather API</title>
  </head>
<body class="container">
  <h1>Enter Zip Code to Get City Weather</h1>
  <?php echo $acknowledgement; ?>
    <form method="post" action="">
            <div class="form-group mb-2">
                <label for="zip_code" class="sr-only">Zip Code:</label>
                <input style="width: 25%;" type="text" class="form-control" id="zip_code" name="zip_code">
            </div>
            <button type="submit" class="btn btn-primary mb-2 ml-2">Submit</button>
        </form>
  <?php echo $output; ?>

    </body>
</html>
