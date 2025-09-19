<?php
$numbers = range(1, 50); // Creates an array from 1 to 50
$evenNumbers= " ";

foreach ($numbers as $number) {
    if ($number % 2 == 0) {
        $evenNumbers .= $number . ' - ';
  
    }
}// Remove the trailing ' - ' if it exists
$evenNumbers = rtrim($evenNumbers, ' - ');     

$form= <<<html
    <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Email address</label>
  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
</div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>
html;

function createTable($rows, $cols) {
    $table = '<table class="table table-bordered">';
    for ($r = 0; $r < $rows; $r++) {
        $table .= '<tr>';
        for ($c = 0; $c < $cols; $c++) {
            $table .= '<td>Row ' . ($r + 1) . ' Col ' . ($c + 1) . '</td>';
        }
        $table .= '</tr>';
    }
    $table .= '</table>';
    return $table;
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body class="container"> 
   <?php 
      echo $evenNumbers;
      echo $form;
      echo createTable(8, 6);
      ?>
      </body>
</html> 